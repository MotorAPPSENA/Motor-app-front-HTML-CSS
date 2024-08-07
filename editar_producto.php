<?php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referenciaProducto = !empty($_POST['referenciaProducto']) ? intval($_POST['referenciaProducto']) : null;
    $nombreProducto = !empty($_POST['nombreProducto']) ? $_POST['nombreProducto'] : null;
    $descripcion = !empty($_POST['descripcion']) ? $_POST['descripcion'] : null;
    $categoria = !empty($_POST['categoria']) ? intval($_POST['categoria']) : null;
    $precio = !empty($_POST['precio']) ? floatval($_POST['precio']) : null;
    $cantidadEnStock = !empty($_POST['cantidadEnStock']) ? intval($_POST['cantidadEnStock']) : null;
    $proveedor = !empty($_POST['proveedor']) ? intval($_POST['proveedor']) : null;
    $codigoDeBarras = !empty($_POST['codigoDeBarras']) ? $_POST['codigoDeBarras'] : null;
    $fechaAdquisicion = !empty($_POST['fechaAdquisicion']) ? $_POST['fechaAdquisicion'] : null;
    $marca = !empty($_POST['marca']) ? intval($_POST['marca']) : null;
    $ubicacionEnAlmacen = !empty($_POST['ubicacionEnAlmacen']) ? $_POST['ubicacionEnAlmacen'] : null;
    $estado = !empty($_POST['estado']) ? intval($_POST['estado']) : null;

    if ($referenciaProducto && $nombreProducto && $descripcion && $categoria && $precio !== null && $cantidadEnStock !== null && $proveedor && $codigoDeBarras && $fechaAdquisicion && $marca && $ubicacionEnAlmacen && $estado) {
        $sql = "UPDATE productos SET nombre_producto = :nombre, descripcion_producto = :descripcion, id_categoria = :categoria, precio_producto = :precio, cantidad_stock = :stock, id_proveedor = :proveedor, codigo_barras_producto = :codigo, fecha_adquisicion_producto = :fecha, id_marca = :marca, ubicacion_almacen_producto = :ubicacion, id_estado = :estado WHERE referencia_producto = :referencia";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':referencia', $referenciaProducto);
        $stmt->bindParam(':nombre', $nombreProducto);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':stock', $cantidadEnStock);
        $stmt->bindParam(':proveedor', $proveedor);
        $stmt->bindParam(':codigo', $codigoDeBarras);
        $stmt->bindParam(':fecha', $fechaAdquisicion);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':ubicacion', $ubicacionEnAlmacen);
        $stmt->bindParam(':estado', $estado);

        if ($stmt->execute()) {
            echo "Producto actualizado exitosamente";
        } else {
            echo "Error al actualizar el producto";
        }
    } else {
        echo "Por favor, complete todos los campos.";
    }
} else {
    echo "Solicitud no válida";
}
?>
