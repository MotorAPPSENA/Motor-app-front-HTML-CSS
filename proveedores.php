<?php
require_once "database.php";

$message = "";

// Verificar si se ha solicitado la edición de un proveedor
if (isset($_GET['editar'])) {
    $id_proveedor = $_GET['editar'];
    
    // Obtener los datos del proveedor seleccionado
    $sql = "SELECT * FROM proveedor_producto WHERE id_proveedor = :id_proveedor";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_proveedor", $id_proveedor);
    $stmt->execute();
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Crear nuevo proveedor o actualizar existente
if (isset($_POST['agregarProveedor']) || isset($_POST['actualizarProveedor'])) {
    $nombre_proveedor = $_POST['nombre_proveedor'];
    $direccion_proveedor = $_POST['direccion_proveedor'];
    $telefono_proveedor = $_POST['telefono_proveedor'];
    $email_proveedor = $_POST['email_proveedor'];
    $id_proveedor = isset($_POST['id_proveedor']) ? $_POST['id_proveedor'] : null;

    if ($id_proveedor) {
        // Actualizar proveedor existente
        $sql = "UPDATE proveedor_producto 
                SET nombre_proveedor = :nombre_proveedor, direccion_proveedor = :direccion_proveedor, telefono_proveedor = :telefono_proveedor, email_proveedor = :email_proveedor 
                WHERE id_proveedor = :id_proveedor";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id_proveedor", $id_proveedor);
        $stmt->bindParam(":nombre_proveedor", $nombre_proveedor);
        $stmt->bindParam(":direccion_proveedor", $direccion_proveedor);
        $stmt->bindParam(":telefono_proveedor", $telefono_proveedor);
        $stmt->bindParam(":email_proveedor", $email_proveedor);

        if ($stmt->execute()) {
            $message = "¡Proveedor actualizado exitosamente!";
        } else {
            $message = "¡Error al actualizar!";
        }
    } else {
        // Crear nuevo proveedor
        $sql = "INSERT INTO proveedor_producto (nombre_proveedor, direccion_proveedor, telefono_proveedor, email_proveedor) 
                VALUES (:nombre_proveedor, :direccion_proveedor, :telefono_proveedor, :email_proveedor)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":nombre_proveedor", $nombre_proveedor);
        $stmt->bindParam(":direccion_proveedor", $direccion_proveedor);
        $stmt->bindParam(":telefono_proveedor", $telefono_proveedor);
        $stmt->bindParam(":email_proveedor", $email_proveedor);

        if ($stmt->execute()) {
            $message = "¡Proveedor registrado exitosamente!";
        } else {
            $message = "¡Error en el registro!";
        }
    }
}

// Leer proveedores
$sql = "SELECT * FROM proveedor_producto";
$proveedores = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Eliminar proveedor
if (isset($_GET['eliminar'])) {
    $id_proveedor = $_GET['eliminar'];
    $sql = "DELETE FROM proveedor_producto WHERE id_proveedor = :id_proveedor";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id_proveedor", $id_proveedor);

    if ($stmt->execute()) {
        $message = "¡Proveedor eliminado exitosamente!";
    } else {
        $message = "¡Error al eliminar!";
    }
}

require ('Apartados/Paginas/apartadoadmin.php'); 
?>

<link rel="stylesheet" href="Estilo Apartados/formulariosAdmin.css">
<div class="contenedorFormulario">
    <form action="proveedores.php" method="post">
        <input type="hidden" name="id_proveedor" value="<?php echo isset($proveedor['id_proveedor']) ? $proveedor['id_proveedor'] : ''; ?>">
        <div class="tituloFormulario"><label for="nombreProveedor">Nombre del Proveedor</label></div>
        <div><input class="inputFormulario" type="text" id="nombreProveedor" name="nombre_proveedor" value="<?php echo isset($proveedor['nombre_proveedor']) ? $proveedor['nombre_proveedor'] : ''; ?>" required></div>
        <div class="tituloFormulario"><label for="direccionProveedor">Dirección</label></div>
        <div><input class="inputFormulario" type="text" id="direccionProveedor" name="direccion_proveedor" value="<?php echo isset($proveedor['direccion_proveedor']) ? $proveedor['direccion_proveedor'] : ''; ?>" required></div>
        <div class="tituloFormulario"><label for="telefonoProveedor">Teléfono</label></div>
        <div><input class="inputFormulario" type="text" id="telefonoProveedor" name="telefono_proveedor" value="<?php echo isset($proveedor['telefono_proveedor']) ? $proveedor['telefono_proveedor'] : ''; ?>" required></div>
        <div class="tituloFormulario"><label for="emailProveedor">Email</label></div>
        <div><input class="inputFormulario" type="email" id="emailProveedor" name="email_proveedor" value="<?php echo isset($proveedor['email_proveedor']) ? $proveedor['email_proveedor'] : ''; ?>"></div>
        <div><button class="botonAgregarFormulario" type="submit" name="<?php echo isset($proveedor) ? 'actualizarProveedor' : 'agregarProveedor'; ?>"><?php echo isset($proveedor) ? 'Actualizar' : 'Agregar'; ?></button></div>
    </form>
</div>

<table class="contenedorTabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Proveedor</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($proveedores as $proveedor): ?>
        <tr>
            <td><?php echo $proveedor['id_proveedor']; ?></td>
            <td><?php echo $proveedor['nombre_proveedor']; ?></td>
            <td><?php echo $proveedor['direccion_proveedor']; ?></td>
            <td><?php echo $proveedor['telefono_proveedor']; ?></td>
            <td><?php echo $proveedor['email_proveedor']; ?></td>
            <td>
                <a href="proveedores.php?editar=<?php echo $proveedor['id_proveedor']; ?>">Editar</a>
                <a href="proveedores.php?eliminar=<?php echo $proveedor['id_proveedor']; ?>">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</body>
</html>
