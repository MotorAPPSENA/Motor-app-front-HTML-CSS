<?php
require_once "../../database.php";

$message = "";

if (!empty($_POST["n_identificacion"]) && !empty($_POST["passwrd"])) {
    // Verificar si el número de identificación ya existe
    $checkSql = "SELECT COUNT(*) FROM usuarios WHERE n_identificacion = :n_identificacion";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(":n_identificacion", $_POST["n_identificacion"]);
    $checkStmt->execute();
    $count = $checkStmt->fetchColumn();

    if ($count > 0) {
        $message = "El número de identificación ya está registrado.";
    } else {
        // Si no existe, proceder con la inserción
        $sql = "INSERT INTO usuarios(n_identificacion, nombre, passwrd, telefono, email, fecha_nacimiento) 
                VALUES (:n_identificacion, :nombre, :passwrd, :telefono, :email, :fecha_nacimiento)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":n_identificacion", $_POST["n_identificacion"]);
        $password = password_hash($_POST["passwrd"], PASSWORD_BCRYPT);
        $stmt->bindParam(":passwrd", $password);
        $stmt->bindParam(":nombre", $_POST["nombre"]);
        $stmt->bindParam(":telefono", $_POST["telefono"]);
        $stmt->bindParam(":email", $_POST["email"]);
        $stmt->bindParam(":fecha_nacimiento", $_POST["fecha_nacimiento"]);

        if ($stmt->execute()) {
            $message = "¡¡Registro exitoso! Inicia Sesión!!";
        } else {
            $message = "Error en registro.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Estilo Apartados/estiloRegistroN.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>RegistroMotorApp</title>
</head>

<body>
    <div class="form-container">
        <div class="login-container">
            <div class="contenedorLogo">
                <a href="../../Nosotros.php"><img class="estiloLogoInicioSesion"
                        src="../../Imagenes/LogoMotorApp.jpg" alt="Logo MotorApp"></a>
            </div>
            <h2>Bienvenido</h2>
            <p>Por favor registra los datos solicitados</p>
            <div>
                <form class="Bloques" id="registro" name="registro" method="post" action="Registro.php"
                    autocomplete="off">
                    <div class="bloqueUno">
                        <div class="bloid">
                            <label for="identificacion">Numero de identificación</label>
                            <input class="input" type="text" name="n_identificacion" id="n_identificacion" autofocus
                                required />
                        </div>
                        <div class="bloid">
                            <label for="nombre">Nombre</label>
                            <input class="input" type="text" name="nombre" id="nombre" required />
                        </div>
                    </div>
                    <div class="bloqueDos">
                        <div class="bloid">
                            <label for="contraseña">Contraseña</label>
                            <input class="input" type="password" name="passwrd" id="passwrd" required />
                        </div>
                        <div class="bloid">
                            <label for="telefono">Numero de telefono</label>
                            <input class="input" type="text" name="telefono" id="telefono" required />
                        </div>
                    </div>
                    <div class="bloqueTres">
                        <div class="bloid">
                            <label for="correo_electronico">correo electronico</label>
                            <input class="input" type="email" name="email" id="email" required />
                        </div>
                        <div class="bloid">
                            <label for="fecha_nacimiento">Fecha de nacimiento</label>
                            <input class="input" type="date" name="fecha_nacimiento" id="fecha_nacimiento" required />
                        </div>
                    </div>
            </div>
            <div class="contPanelInferior">
            <p>
                <button class="btn btn-login" value="Registrarse" id="registro" name="registro"
                    type="submit">Registrarse</button>
                </form>
                <?php if (!empty($message)): ?>
                <div class="excepcionRegistro">
                    <a href="Login.php"><button class="btnExcepcion"><?= $message ?></button></a>
                </div>
            <?php endif; ?>
            </div>
            <div class="contPanelInferior">
            </p>
            <span> Elegir otro metodo de autenticación</span>
            <a href="https://www.google.com" target="_blank" rel="noopener noreferrer"><button
                    class="btn btn-Google">Google</button></a>
            <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"><button
                    class="btn btn-Facebook">Facebook</button></a>
            </div>
        </div>
</body>

</html>