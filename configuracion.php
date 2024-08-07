<?php
require('Apartados/Paginas/apartadoadmin.php');
require_once 'database.php';

// Obtener la información del administrador
session_start();
$id_admin = $_SESSION['id_admin'];
$sql = "SELECT * FROM administradores WHERE id_admin = :id_admin";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id_admin', $id_admin);
$stmt->execute();
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<link rel="stylesheet" href="Estilo Apartados/configuracion.css">

<div class="contenedorConfiguracion">
    <h2>Configuración del Administrador</h2>
    <form action="guardar_configuracion.php" method="POST">
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo $admin['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Nueva Contraseña (dejar en blanco si no desea cambiar)</label>
            <input type="password" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" value="<?php echo $admin['telefono']; ?>">
        </div>
        <button type="submit">Guardar Cambios</button>
    </form>
</div>

</body>
</html>
