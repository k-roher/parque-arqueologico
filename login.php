<?php
require 'vendor/autoload.php';

session_start();

// Configurar el cliente de Google
$client = new Google_Client();
$client->setClientId('458858792485-bfj140uka5egn1m60qct7nu8tlp032fe.apps.googleusercontent.com');  // Reemplaza con tu Client ID
$client->setClientSecret('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');  // Reemplaza con tu Client Secret
$client->setRedirectUri('http://localhost/google-callback.php');
$client->addScope("email");
$client->addScope("profile");

// Obtener URL de autenticación
$login_url = $client->createAuthUrl();

// Botón para iniciar sesión
echo "<a href='$login_url'>Iniciar sesión con Google</a>";
