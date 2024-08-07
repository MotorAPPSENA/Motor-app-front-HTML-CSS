<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $id_admin = $_SESSION['id_admin'];
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : null;

    if ($nombre && $email) {
        $sql = "UPDATE administradores SET 
                nombre = :nombre, 
                email = :email, 
                telefono = :telefono ";

        if ($password) {
            $sql .= ", password = :password ";
        }

        $sql .= "WHERE id_admin = :id_admin";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_admin', $id_admin);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        if ($password) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':telefono', $telefono);

        if ($stmt->execute()) {
            echo "Configuración actualizada exitosamente";
        } else {
            echo "Error al actualizar la configuración";
        }
    } else {
        echo "Por favor, complete todos los campos obligatorios.";
    }
}
