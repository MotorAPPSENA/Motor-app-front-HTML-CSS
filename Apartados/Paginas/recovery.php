<?php

ini_set("SMTP", "localhost:8080");
ini_set("smtp_port", "1025");

session_start();

$message = ""; // Inicializamos la variable de mensaje

if (isset($_POST['btnEnviar'])) {
    $correo = $_POST['emailButton'];

    require_once "../../database.php"; // Asegúrate de que este archivo contenga la conexión a la base de datos

    // Preparamos la consulta para prevenir inyecciones SQL
    $consultaCorreo = "SELECT id_usuario, nombre FROM usuarios WHERE email = :email";
    $statement = $conn->prepare($consultaCorreo);

    // Asociamos el parámetro de la consulta
    $statement->bindParam(":email", $correo, PDO::PARAM_STR);
    
    // Ejecutamos la consulta
    $statement->execute();

    // Verificamos si se ha encontrado un resultado
    if ($statement->rowCount() > 0) {
        $resultado = $statement->fetch(PDO::FETCH_ASSOC);
        $nombreUsuario = $resultado['nombre'];
        $usuarioId = $resultado['id_usuario'];

        // Generamos un token único
        $token = bin2hex(random_bytes(50));
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour')); // Token válido por 1 hora

        // Guardamos el token en la base de datos
        $updateToken = "UPDATE usuarios SET token = :token WHERE id_usuario = :user_id";
        $stmt = $conn->prepare($updateToken);
        $stmt->bindParam(":user_id", $usuarioId, PDO::PARAM_INT);
        $stmt->bindParam(":token", $token, PDO::PARAM_STR);
        $stmt->execute();

        // Enviamos el correo electrónico
        $resetLink = "https://tu-sitio-web.com/reset_password.php?token=" . $token;

        $to = $correo;
        $subject = "Recuperación de contraseña";
        $body = "Hola $nombreUsuario, \n\nHaz clic en el siguiente enlace para restablecer tu contraseña: \n\n$resetLink \n\nEste enlace es válido por 1 hora.";
        $headers = "From: no-reply@tu-sitio-web.com";

        if (mail($to, $subject, $body, $headers)) {
            $message = "Hemos enviado un enlace de recuperación a tu correo.";
        } else {
            $message = "Hubo un error al enviar el correo.";
        }
    } else {
        $message = "El correo no existe en la base de datos.";
    }

    echo $message;
} else {
    echo "No se ha enviado el formulario.";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Estilo Apartados/styleRecovery.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>LoginMotorApp</title>
</head>

<body>
    <div class="form-container">
        <div class="login-container">
            <div class="contenedorLogo">
                <a href="../../Nosotros.php"><img class="estiloLogoInicioSesion"
                        src="../../Imagenes/LogoMotorApp.jpg" alt="Logo MotorApp"></a>
            </div>
            <div form-container-two>
                <form method="post" class="recoveryForm">
                    <p>
                        <input class="input" type="email" name="emailButton" id="emailButton" placeholder="Introduce tu correo electronico" />
                    </p>
                    <!-- creamos input para que para ingresar correo electronico de recuperacion -->
                    <?php if (!empty($message)): ?>
                        <h3 class="alerta"><?= $message ?></h3>
                    <?php endif; ?>
                    <button type="submit" name="btnEnviar" id="btnEnviar" class="btn btn-login"
                        value="Iniciar Sesión">
                        ENVIAR</button>
                </form>
            </div>
        </div>
</body>

</html>