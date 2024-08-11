<?php

// Iniciar sesión
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    // Redirigir al usuario al inicio de sesión si no está logueado
    header("Location: Apartados/Paginas/login.php");
    exit();
}

// Conexión a la base de datos
require 'database.php';

// Obtener el ID del usuario logueado
$id_usuario = $_SESSION['id_usuario'];

// Obtener los datos del formulario
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];

// Actualizar los datos en la base de datos
$sql = "UPDATE usuarios SET nombre = ?, telefono = ?, email = ?, fecha_nacimiento = ? WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $nombre, $telefono, $email, $fecha_nacimiento, $id_usuario);

if ($stmt->execute()) {
    echo "Datos actualizados correctamente.";
} else {
    echo "Error al actualizar los datos: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
