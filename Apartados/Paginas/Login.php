<?php
session_start();
if (isset($_SESSION["n_documento"])) {
    header("");

}

require_once "../../database.php";

if (!empty($_POST["n_documento"]) && !empty($_POST["passwrd"])) {
    $sql = "SELECT n_identificacion, passwrd FROM usuarios WHERE n_identificacion = :n_documento";
    $record = $conn->prepare($sql);
    $record->bindParam(":n_documento", $_POST["n_documento"]);
    $record->execute();
    $result = $record->fetch(PDO::FETCH_ASSOC); // Corrección aquí: asignar resultados a $result

    $message = "";

    if ($result && password_verify($_POST["passwrd"], $result["passwrd"])) {
        $_SESSION["n_documento"] = $result["n_identificacion"];

        $message = "Inicio de sesión exitoso";
    } else {
        $message = "Credenciales incorrectas";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Estilo Apartados/styleLogin.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>LoginMotorApp</title>
</head>

<body>
    <div class="form-container">
        <div class="login-container">
            <a href="../Paginas/Nosotros.php"><img class="estiloLogoInicioSesion" src="../../Imagenes/LogoMotorApp.jpg"
                    alt="Logo MotorApp"></a>
            <h2>Bienvenido</h2>

            <?php if(!empty($message)): ?>
                <p><?= $message ?></p>
            <?php endif; ?>

            <p>Selecciona el metodo de autenticación</p>
            <form method="post" action="../../index.php">
                <p>
                    <label for="username">Numero de Documento</label>
                    <input class="input" type="text" name="n_documento" id="username" />
                </p>
                <p>
                    <label for="username">Contraseña</label>
                    <input class="input" type="password" name="passwrd" id="password" />
                </p>
                <div class="options">
                    <div>
                        Recordar usuario
                        <input type="checkbox" name="rememberme" id="rememberme" />
                    </div>
                    <div>
                        <a href="#">Olvide mi contraseña</a>
                    </div>
                </div>
                <p>
                    <input type="submit" name="btningresar" class="btn btn-login" value="Iniciar Sesión">
                </p>
                <div class="proveedores">
                    <span> Elegir otro metodo de autenticación</span>
                    <a href="https://www.google.com" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-Google">Google</button></a>
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-Facebook">Facebook</button></a>
                </div>
            </form>
        </div>
        <div class="welcome-screen-container">
            <video autoplay muted loop id="videoFondo" object-fit id="video">
                <source src="../../Videos/VideoInicioSesion.mp4" type="video/mp4">
            </video>
        </div>
    </div>