<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded-lg shadow-md text-center">
        <h1 class="text-2xl font-bold text-green-800 mb-4">Bienvenido, <?php echo $_SESSION['user_name']; ?> 👋</h1>
        <img src="<?php echo $_SESSION['user_picture']; ?>" alt="Foto de perfil" class="rounded-full mx-auto mb-4 w-32">
        <p class="text-gray-700"><strong>Email:</strong> <?php echo $_SESSION['user_email']; ?></p>
        <a href="logout.php" class="mt-4 inline-block bg-red-500 text-white px-4 py-2 rounded shadow hover:bg-red-700">Cerrar Sesión</a>
    </div>
</body>
</html>
