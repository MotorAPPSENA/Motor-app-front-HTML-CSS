<?php
require_once 'database.php';

if (isset($_GET['referencia'])) {
    $referencia = intval($_GET['referencia']);

    $sql = "DELETE FROM productos WHERE referencia_producto = :referencia";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':referencia', $referencia);

    if ($stmt->execute()) {
        echo "Producto eliminado exitosamente";
    } else {
        echo "Error al eliminar el producto";
    }
} else {
    echo "Referencia de producto no proporcionada.";
}
?>

