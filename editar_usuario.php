<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = !empty($_POST['id_usuario']) ? intval($_POST['id_usuario']) : null;
    $n_identificacion = !empty($_POST['n_identificacion']) ? $_POST['n_identificacion'] : null;
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
    $passwrd = !empty($_POST['passwrd']) ? $_POST['passwrd'] : null;
    $telefono = !empty($_POST['telefono']) ? $_POST['telefono'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $fecha_nacimiento = !empty($_POST['fecha_nacimiento']) ? $_POST['fecha_nacimiento'] : null;
    $rol = !empty($_POST['rol']) ? intval($_POST['rol']) : null;

    if ($id_usuario && $n_identificacion && $nombre && $passwrd && $telefono && $email && $fecha_nacimiento && $rol) {
        $sql = "UPDATE usuarios SET 
                n_identificacion = :n_identificacion, 
                nombre = :nombre, 
                passwrd = :passwrd, 
                telefono = :telefono, 
                email = :email, 
                fecha_nacimiento = :fecha_nacimiento, 
                rol = :rol 
                WHERE id_usuario = :id_usuario";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->bindParam(':n_identificacion', $n_identificacion);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':passwrd', $passwrd);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $stmt->bindParam(':rol', $rol);

        if ($stmt->execute()) {
            echo "Usuario actualizado exitosamente";
        } else {
            echo "Error al actualizar el usuario";
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>
