<?php
require_once "database.php"; // Asegúrate de que este archivo contenga la conexión a la base de datos
session_start();

$message = ""; // Inicializamos la variable de mensaje

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Preparamos la consulta para verificar el token
    $consultaToken = "SELECT id_usuario FROM usuarios WHERE token = :token AND token_expiry > NOW()";
    $statement = $conn->prepare($consultaToken);

    // Asociamos el parámetro de la consulta
    $statement->bindParam(":token", $token, PDO::PARAM_STR);

    // Ejecutamos la consulta
    $statement->execute();

    // Verificamos si el token es válido
    if ($statement->rowCount() > 0) {
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        $usuarioId = $resultado['id_usuario'];

        if (isset($_POST['btnResetPassword'])) {
            $nuevaContrasena = $_POST['newPassword'];

            // Validamos la nueva contraseña
            if (strlen($nuevaContrasena) >= 8) {
                // Actualizamos la contraseña en la base de datos
                $hashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
                $updatePassword = "UPDATE usuarios SET password = :password, token = NULL, token_expiry = NULL WHERE id_usuario = :user_id";
                $stmt = $conn->prepare($updatePassword);
                $stmt->bindParam(":password", $hashContrasena, PDO::PARAM_STR);
                $stmt->bindParam(":user_id", $usuarioId, PDO::PARAM_INT);
                $stmt->execute();

                $message = "Tu contraseña ha sido restablecida con éxito.";
            } else {
                $message = "La nueva contraseña debe tener al menos 8 caracteres.";
            }
        }
    } else {
        $message = "El enlace de recuperación es inválido o ha expirado.";
    }
} else {
    $message = "No se ha proporcionado un token.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h2>Restablecer Contraseña</h2>
    <?php if (!empty($message)) { echo "<p>$message</p>"; } ?>
    <?php if (isset($usuarioId)) { ?>
        <form method="post">
            <label for="newPassword">Nueva Contraseña:</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <button type="submit" name="btnResetPassword">Restablecer Contraseña</button>
        </form>
    <?php } ?>
</body>
</html>