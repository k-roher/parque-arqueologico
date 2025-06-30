<?php
require 'vendor/autoload.php';
require 'db.php';  // Conexión PDO a MySQL

use Google\Client;

header('Content-Type: application/json');

// Obtener token desde el POST
if (!isset($_POST['token'])) {
    echo json_encode(['success' => false, 'message' => 'Token no recibido']);
    exit();
}

$token = $_POST['token'];

// Configurar cliente de Google
$client = new Google_Client();
$client->setClientId('458858792485-bfj140uka5egn1m60qct7nu8tlp032fe.apps.googleusercontent.com');

try {
    // Verificar el token
    $payload = $client->verifyIdToken($token);

    if ($payload) {
        $googleId = $payload['sub'];
        $name = $payload['name'];
        $email = $payload['email'];
        $picture = $payload['picture'];

        // Insertar o ignorar si ya existe
        $stmt = $pdo->prepare("INSERT INTO users (google_id, name, email, picture)
                               VALUES (:google_id, :name, :email, :picture)
                               ON DUPLICATE KEY UPDATE name = :name, picture = :picture");
        $stmt->execute([
            ':google_id' => $googleId,
            ':name' => $name,
            ':email' => $email,
            ':picture' => $picture
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Token inválido']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
