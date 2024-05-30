<?php
require_once "database.php"; // Asegúrate de que este archivo contenga la conexión a la base de datos
session_start();

$message = ""; // Inicializamos la variable de mensaje

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Preparamos la consulta para verificar el token
    $consultaToken = "SELECT n_identificacion FROM usuarios WHERE token = :token";
    $statement = $conn->prepare($consultaToken);

    // Asociamos el parámetro de la consulta
    $statement->bindParam(":token", $token, PDO::PARAM_STR);

    // Ejecutamos la consulta
    $statement->execute();

    // Verificamos si el token es válido
    if ($statement->rowCount() > 0) {
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        $usuarioId = $resultado['n_identificacion'];

        if (isset($_POST['btnResetPassword'])) {
            $nuevaContrasena = $_POST['newPassword'];

            // Validamos la nueva contraseña
            if (strlen($nuevaContrasena) >= 8) {
                // Actualizamos la contraseña en la base de datos
                $hashContrasena = password_hash($nuevaContrasena, PASSWORD_DEFAULT);
                $updatePassword = "UPDATE usuarios SET passwrd = :password, token = NULL WHERE n_identificacion = :user_id";
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
        $message = "El enlace de recuperación es inválido.";
    }
} else {
    $message = "No se proporcionó un token.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="../../Estilo Apartados/estiloResetPassword.css">
</head>
<body>
    <div class="form-container">
        <div class="login-container">
            <div class="contenedorLogo">
                <a href="../../Nosotros.php"><img class="estiloLogoInicioSesion" src="../../Imagenes/LogoMotorApp.jpg"
                        alt="Logo MotorApp"></a>
            </div>
            <div form-container-two>
                <form method="post" class="recoveryForm">
                    <?php if (!empty($message)) {
                        echo "<p>$message</p>";
                    } ?>
                    <?php if (isset($usuarioId)) { ?>
                        <form method="post">
                            <label for="newPassword">Nueva Contraseña:</label>
                            <input class="input" type="password" id="newPassword" name="newPassword" required>
                            <button class="btn btn-login" type="submit" name="btnResetPassword">Restablecer
                                Contraseña</button>
                        </form>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
</body>

</html>