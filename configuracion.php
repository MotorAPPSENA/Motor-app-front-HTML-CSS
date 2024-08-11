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

// Consultar los datos del usuario utilizando PDO
$sql = "SELECT n_identificacion, nombre, telefono, email, fecha_nacimiento FROM usuarios WHERE id_usuario = :id_usuario";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id_usuario", $id_usuario, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "Error al obtener los datos del usuario.";
    exit();
}

require ('Apartados/Paginas/apartadoadmin.php');
?>
<meta charset="UTF-8">
<title>Actualizar Perfil</title>
<link rel="stylesheet" href="Estilo Apartados/estiloConfiguracion.css">

<div class="contenedorFormulario">
    <h2 class="tituloContenedor" >Actualizar Perfil</h2>
    <form action="actualizar_perfil.php" method="POST">
        <div>
            <label for="n_identificacion">Número de Identificación:</label>
            <input type="text" id="n_identificacion" name="n_identificacion"
                value="<?php echo htmlspecialchars($user['n_identificacion']); ?>" readonly>
        </div>
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($user['nombre']); ?>"
                required>
        </div>
        <div>
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo htmlspecialchars($user['telefono']); ?>"
                required>
        </div>
        <div>
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>"
                required>
        </div>
        <div>
            <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"
                value="<?php echo htmlspecialchars($user['fecha_nacimiento']); ?>" required>
        </div>
        <div>
            <button class="BotonAgregar" type="submit">Actualizar</button>
        </div>
    </form>
</div>
</body>

</html>