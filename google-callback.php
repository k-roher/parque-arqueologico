<?php
require 'vendor/autoload.php';
require 'db.php';  // Conexión a MySQL

use Google\Client;
use Google\Service\Oauth2;

session_start();

$client = new Google_Client();
$client->setClientId("458858792485-bfj140uka5egn1m60qct7nu8tlp032fe.apps.googleusercontent.com");  
$client->setClientSecret("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");  
$client->setRedirectUri("http://localhost/google-callback/);
$client->addScope("email");
$client->addScope("profile");

if (!isset($_GET['code'])) {
    header("Location: login.html");
    exit();
}

// Obtener token
$token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
if (isset($token['error'])) {
    echo "Error al autenticar con Google: " . htmlspecialchars($token['error_description']);
    exit();
}

// Configurar el token de acceso
$client->setAccessToken($token['access_token']);

// Obtener datos del usuario
$oauth2 = new Oauth2($client);
$userInfo = $oauth2->userinfo->get();

// Guardar datos en sesión
$_SESSION['user_id'] = $userInfo->id;
$_SESSION['user_name'] = $userInfo->name;
$_SESSION['user_email'] = $userInfo->email;
$_SESSION['user_picture'] = $userInfo->picture;

// Insertar o actualizar usuario en la base de datos
try {
    $stmt = $pdo->prepare("INSERT INTO users (google_id, name, email, picture) 
                           VALUES (:google_id, :name, :email, :picture) 
                           ON DUPLICATE KEY UPDATE name=:name, picture=:picture");
    $stmt->execute([
        ':google_id' => $userInfo->id,
        ':name' => $userInfo->name,
        ':email' => $userInfo->email,
        ':picture' => $userInfo->picture
    ]);
} catch (PDOException $e) {
    die("Error al guardar en la base de datos: " . $e->getMessage());
}

// Redirigir al dashboard
header("Location: dashboard.php");
exit();
