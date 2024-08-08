<?php
require_once "database.php";

$message = "";

// Verificar si se ha solicitado la edición de una marca
if (isset($_GET['editar'])) {
    $id_marca = $_GET['editar'];
    
    // Obtener los datos de la marca seleccionada
    $sql = "SELECT * FROM marca_producto WHERE id_marca = :id_marca";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_marca", $id_marca);
    $stmt->execute();
    $marca = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Crear nueva marca o actualizar existente
if (isset($_POST['agregarMarca']) || isset($_POST['actualizarMarca'])) {
    $nombre_marca = $_POST['nombre_marca'];
    $id_marca = isset($_POST['id_marca']) ? $_POST['id_marca'] : null;

    if ($id_marca) {
        // Actualizar marca existente
        $sql = "UPDATE marca_producto 
                SET nombre_marca = :nombre_marca 
                WHERE id_marca = :id_marca";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id_marca", $id_marca);
        $stmt->bindParam(":nombre_marca", $nombre_marca);

        if ($stmt->execute()) {
            $message = "¡Marca actualizada exitosamente!";
        } else {
            $message = "¡Error al actualizar!";
        }
    } else {
        // Crear nueva marca
        $sql = "INSERT INTO marca_producto (nombre_marca) 
                VALUES (:nombre_marca)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre_marca", $nombre_marca);

        if ($stmt->execute()) {
            $message = "¡Marca registrada exitosamente!";
        } else {
            $message = "¡Error en el registro!";
        }
    }
}

// Leer marcas
$sql = "SELECT * FROM marca_producto";
$marcas = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Eliminar marca
if (isset($_GET['eliminar'])) {
    $id_marca = $_GET['eliminar'];
    $sql = "DELETE FROM marca_producto WHERE id_marca = :id_marca";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_marca", $id_marca);

    if ($stmt->execute()) {
        $message = "¡Marca eliminada exitosamente!";
    } else {
        $message = "¡Error al eliminar!";
    }
}

require ('Apartados/Paginas/apartadoadmin.php'); 
?>

<link rel="stylesheet" href="Estilo Apartados/formulariosAdmin.css">
<div class="contenedorFormulario">
    <form action="marcas.php" method="post">
        <input type="hidden" name="id_marca" value="<?php echo isset($marca['id_marca']) ? $marca['id_marca'] : ''; ?>">
        <div class="tituloFormulario"><label for="nombreMarca">Escribe el nombre de la nueva Marca</label></div>
        <div><input class="inputFormulario" type="text" id="nombreMarca" name="nombre_marca" value="<?php echo isset($marca['nombre_marca']) ? $marca['nombre_marca'] : ''; ?>" required></div>
        <div><button class="botonAgregarFormulario" type="submit" name="<?php echo isset($marca) ? 'actualizarMarca' : 'agregarMarca'; ?>"><?php echo isset($marca) ? 'Actualizar' : 'Agregar'; ?></button></div>
    </form>
</div>

<table class="contenedorTabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Marca</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($marcas as $marca): ?>
        <tr>
            <td><?php echo $marca['id_marca']; ?></td>
            <td><?php echo $marca['nombre_marca']; ?></td>
            <td>
                <a href="marcas.php?editar=<?php echo $marca['id_marca']; ?>">Editar</a>
                <a href="marcas.php?eliminar=<?php echo $marca['id_marca']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
