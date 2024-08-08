<?php
require_once "database.php";

$message = "";

// Verificar si se ha solicitado la edición de una categoría
if (isset($_GET['editar'])) {
    $id_categoria = $_GET['editar'];
    
    // Obtener los datos de la categoría seleccionada
    $sql = "SELECT * FROM categoria_producto WHERE id_categoria = :id_categoria";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_categoria", $id_categoria);
    $stmt->execute();
    $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Crear nueva categoría o actualizar existente
if (isset($_POST['agregarCategoria']) || isset($_POST['actualizarCategoria'])) {
    $nombre_categoria = $_POST['nombre_categoria'];
    $id_categoria = isset($_POST['id_categoria']) ? $_POST['id_categoria'] : null;

    if ($id_categoria) {
        // Actualizar categoría existente
        $sql = "UPDATE categoria_producto 
                SET nombre_categoria = :nombre_categoria 
                WHERE id_categoria = :id_categoria";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id_categoria", $id_categoria);
        $stmt->bindParam(":nombre_categoria", $nombre_categoria);

        if ($stmt->execute()) {
            $message = "¡Categoría actualizada exitosamente!";
        } else {
            $message = "¡Error al actualizar!";
        }
    } else {
        // Crear nueva categoría
        $checkSql = "SELECT COUNT(*) FROM categoria_producto WHERE nombre_categoria = :nombre_categoria";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(":nombre_categoria", $nombre_categoria);
        $checkStmt->execute();
        $countCategoria = $checkStmt->fetchColumn();

        if ($countCategoria > 0) {
            $message = "¡La categoría que ingresaste ya se encuentra registrada!";
        } else {
            $sql = "INSERT INTO categoria_producto (nombre_categoria) 
                    VALUES (:nombre_categoria)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":nombre_categoria", $nombre_categoria);

            if ($stmt->execute()) {
                $message = "¡Categoría registrada exitosamente!";
            } else {
                $message = "¡Error en el registro!";
            }
        }
    }
}

// Leer categorías
$sql = "SELECT * FROM categoria_producto";
$categorias = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Eliminar categoría
if (isset($_GET['eliminar'])) {
    $id_categoria = $_GET['eliminar'];
    $sql = "DELETE FROM categoria_producto WHERE id_categoria = :id_categoria";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_categoria", $id_categoria);

    if ($stmt->execute()) {
        $message = "¡Categoría eliminada exitosamente!";
    } else {
        $message = "¡Error al eliminar!";
    }
}

require ('Apartados/Paginas/apartadoadmin.php'); 
?>

<link rel="stylesheet" href="Estilo Apartados/formulariosAdmin.css">
<div class="contenedorFormulario">
    <form action="categorias.php" method="post">
        <input type="hidden" name="id_categoria" value="<?php echo isset($categoria['id_categoria']) ? $categoria['id_categoria'] : ''; ?>">
        <div class="tituloFormulario"><label for="nombreCategoria">Escribe el nombre de la nueva Categoría</label></div>
        <div><input class="inputFormulario" type="text" id="nombreCategoria" name="nombre_categoria" value="<?php echo isset($categoria['nombre_categoria']) ? $categoria['nombre_categoria'] : ''; ?>" required></div>
        <div><button class="botonAgregarFormulario" type="submit" name="<?php echo isset($categoria) ? 'actualizarCategoria' : 'agregarCategoria'; ?>"><?php echo isset($categoria) ? 'Actualizar' : 'Agregar'; ?></button></div>
    </form>
</div>

<table class="contenedorTabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categorias as $categoria): ?>
        <tr>
            <td><?php echo $categoria['id_categoria']; ?></td>
            <td><?php echo $categoria['nombre_categoria']; ?></td>
            <td>
                <a href="categorias.php?editar=<?php echo $categoria['id_categoria']; ?>">Editar</a>
                <a href="categorias.php?eliminar=<?php echo $categoria['id_categoria']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
