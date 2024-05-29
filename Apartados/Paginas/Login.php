<?php

session_start();

$message = ""; // Inicializamos la variable de mensaje

if (isset($_POST['btningresar'])) {
    $usuario = $_POST['n_identificacion'];

    require_once "../../database.php"; // Asegúrate de que este archivo contenga la conexión a la base de datos
    $passwrd = $_POST["passwrd"];

    $consulta = "SELECT passwrd, rol FROM usuarios WHERE n_identificacion = :usuario";
    $statement = $conn->prepare($consulta);

    // Corregir los nombres de los parámetros
    $statement->bindParam(":usuario", $usuario, PDO::PARAM_STR);
    try {
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $valorContrasena = $row["passwrd"];
            $rolUsuario = $row["rol"];

            if (password_verify($passwrd, $valorContrasena)) {
                $_SESSION['n_identificacion'] = $usuario;
                
                if ($rolUsuario == 1) {
                    header("Location: ../../Perfil.php");
                } else {
                    header("Location: ../../PerfilAdmin.php");
                }
            } else {
                $message = "Error en la autenticación"; // Mensaje de error
            }
        } else {
            $message = "No se encontraron registros."; // No se encontró el usuario
        }
    } catch (PDOException $e) {
        $message = "Error en la consulta: " . $e->getMessage(); // Mensaje de error si hay una excepción
    }

} else {
    // Manejar el caso donde no se envían los datos esperados por POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $message = "Datos de inicio de sesión no recibidos.";
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
            <div class="contenedorLogo">
                <a href="../../Nosotros.php"><img class="estiloLogoInicioSesion"
                        src="../../Imagenes/LogoMotorApp.jpg" alt="Logo MotorApp"></a>
            </div>
            <h2>Bienvenido</h2>
            <p>Selecciona el metodo de autenticación</p>
            <div form-container-two>
                <form method="post">
                    <p>
                        <label for="username">Numero de Documento</label>
                        <input class="input" type="text" name="n_identificacion" id="username" />
                    </p>
                    <p>
                        <label for="username">Contraseña</label>
                        <input class="input" type="password" name="passwrd" id="password" />
                    </p>
                    <!-- Aquí colocamos el mensaje de excepción -->
                    <?php if (!empty($message)): ?>
                        <h3 class="alerta"><?= $message ?></h3>
                    <?php endif; ?>
                    <button type="submit" name="btningresar" id="btningresar" class="btn btn-login"
                        value="Iniciar Sesión">
                        INICIAR SESIÓN</button>
                </form>
                <div class="options">
                    <div>
                        Recordar usuario
                        <input type="checkbox" name="rememberme" id="rememberme" />
                    </div>
                    <div>
                        <a href="recovery.php">Olvide mi contraseña</a>
                    </div>
                </div>
                <div class="contPanelInferior">
                    <p>
                </div>
                <div class="contPanelInferior">
                    <a href="Registro.php"><button class="btn btn-login">Registrarse</button></a>
                    </p>
                    <a href="https://www.google.com" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-Google">Google</button></a>
                    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"><button
                            class="btn btn-Facebook">Facebook</button></a>
                </div>
            </div>
        </div>
</body>

</html>