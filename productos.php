<?php
require_once 'database.php';

// Obtener la siguiente referencia automática para el producto
function obtenerSiguienteReferencia($conn) {
    $sql = "SELECT MAX(referencia_producto) AS max_referencia FROM productos";
    $stmt = $conn->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['max_referencia'] + 1;
}

// Manejo del formulario para agregar/editar productos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referenciaProducto = !empty($_POST['referenciaProducto']) ? intval($_POST['referenciaProducto']) : obtenerSiguienteReferencia($conn);
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

    if ($nombreProducto && $descripcion && $categoria && $precio !== null && $cantidadEnStock !== null && $proveedor && $codigoDeBarras && $fechaAdquisicion && $marca && $ubicacionEnAlmacen && $estado) {
        if (isset($_POST['editarProducto']) && $_POST['editarProducto'] == 'true') {
            // Código para editar producto
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
            // Código para agregar producto
            $sqlCheck = "SELECT COUNT(*) AS count FROM productos WHERE referencia_producto = :referencia";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->bindParam(':referencia', $referenciaProducto);
            $stmtCheck->execute();
            $rowCheck = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($rowCheck['count'] == 0) {
                $sql = "INSERT INTO productos (referencia_producto, nombre_producto, descripcion_producto, id_categoria, precio_producto, cantidad_stock, id_proveedor, codigo_barras_producto, fecha_adquisicion_producto, id_marca, ubicacion_almacen_producto, id_estado)
                        VALUES (:referencia, :nombre, :descripcion, :categoria, :precio, :stock, :proveedor, :codigo, :fecha, :marca, :ubicacion, :estado)";
                
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
                    echo "Nuevo producto agregado exitosamente";
                } else {
                    echo "Error al agregar el producto";
                }
            } else {
                echo "La referencia del producto ya existe. No se puede duplicar.";
            }
        }
    } else {
        echo "Por favor, complete todos los campos del formulario.";
    }
}

// Obtener productos de la base de datos
$sql = "SELECT p.*, c.nombre_categoria, pr.nombre_proveedor, m.nombre_marca, e.nombre_estado
        FROM productos p
        LEFT JOIN categoria_producto c ON p.id_categoria = c.id_categoria
        LEFT JOIN proveedor_producto pr ON p.id_proveedor = pr.id_proveedor
        LEFT JOIN marca_producto m ON p.id_marca = m.id_marca
        LEFT JOIN estado_producto e ON p.id_estado = e.id_estado";

$result = $conn->query($sql);
?>

<?php require_once 'Apartados/Paginas/apartadoadmin.php'; ?>
<link rel="stylesheet" href="Estilo Apartados/productos.css">
<div class="contenedor">
<div class="contenedorProductos">
    <div class="contenedorFormulario">
        <h1 class="tituloContenedor">Añadir productos</h1>
        <form id="product-form" action="productos.php" method="post">
            <div>
                <label for="referenciaProducto">Referencia del producto</label>
                <input type="text" id="referenciaProducto" name="referenciaProducto" value="<?php echo obtenerSiguienteReferencia($conn); ?>" readonly>
            </div>
            <div>
                <label for="nombreProducto">Nombre del Producto</label>
                <input type="text" id="nombreProducto" name="nombreProducto" required>
            </div>
            <div>
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>
            <div>
                <label for="categoria">Categoría</label>
                <select class="listaProductos" id="categoria" name="categoria" required>
                    <?php
                    // Consulta para obtener las categorías disponibles
                    $sqlCategorias = "SELECT id_categoria, nombre_categoria FROM categoria_producto";
                    $stmtCategorias = $conn->query($sqlCategorias);
                    while ($rowCategoria = $stmtCategorias->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$rowCategoria['id_categoria']}'>{$rowCategoria['nombre_categoria']}</option>";
                    }
                    ?>
                </select>
                <a class="enlacesformulario" href="categorias.php">Agregar Categoría</a>
            </div>
            <div>
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" required>
            </div>
            <div>
                <label for="cantidadEnStock">Cantidad en Stock</label>
                <input type="number" id="cantidadEnStock" name="cantidadEnStock" required>
            </div>
            <div>
                <label for="proveedor">Proveedor</label>
                <select class="listaProductos" id="proveedor" name="proveedor" required>
                    <?php
                    // Consulta para obtener los proveedores disponibles
                    $sqlProveedores = "SELECT id_proveedor, nombre_proveedor FROM proveedor_producto";
                    $stmtProveedores = $conn->query($sqlProveedores);
                    while ($rowProveedor = $stmtProveedores->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$rowProveedor['id_proveedor']}'>{$rowProveedor['nombre_proveedor']}</option>";
                    }
                    ?>
                </select>
                <a class="enlacesformulario" href="proveedores.php">Agregar Proveedor</a>
            </div>
            <div>
                <label for="codigoDeBarras">Código de Barras</label>
                <input type="text" id="codigoDeBarras" name="codigoDeBarras" required>
            </div>
            <div>
                <label for="fechaAdquisicion">Fecha de Adquisición</label>
                <input type="date" id="fechaAdquisicion" name="fechaAdquisicion" required>
            </div>
            <div>
                <label for="marca">Marca</label>
                <select class="listaProductos" id="marca" name="marca" required>
                    <?php
                    // Consulta para obtener las marcas disponibles
                    $sqlMarcas = "SELECT id_marca, nombre_marca FROM marca_producto";
                    $stmtMarcas = $conn->query($sqlMarcas);
                    while ($rowMarca = $stmtMarcas->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$rowMarca['id_marca']}'>{$rowMarca['nombre_marca']}</option>";
                    }
                    ?>
                </select>
                <a class="enlacesformulario" href="marcas.php">Agregar Marca</a>
            </div>
            <div>
                <label for="ubicacionEnAlmacen">Ubicación en el Almacén</label>
                <input type="text" id="ubicacionEnAlmacen" name="ubicacionEnAlmacen" required>
            </div>
            <div>
                <label for="estado">Estado del Producto</label>
                <select class="listaProductos" id="estado" name="estado" required>
                    <?php
                    // Consulta para obtener los estados disponibles
                    $sqlEstados = "SELECT id_estado, nombre_estado FROM estado_producto";
                    $stmtEstados = $conn->query($sqlEstados);
                    while ($rowEstado = $stmtEstados->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$rowEstado['id_estado']}'>{$rowEstado['nombre_estado']}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="editarProducto" id="editarProducto">
            <button class="BotonAgregar" type="submit">Guardar Producto</button>
            <button class="BotonAgregar" type="reset" onclick="limpiarFormulario()">Limpiar formulario</button>
        </form>
    </div>
</div>

<div class="contenedorProductos">
    <table>
        <thead>
            <tr>
                <th>Referencia</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Cantidad en Stock</th>
                <th>Proveedor</th>
                <th>Código de Barras</th>
                <th>Fecha de Adquisición</th>
                <th>Marca</th>
                <th>Ubicación en el Almacén</th>
                <th>Estado del Producto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo $row['referencia_producto']; ?></td>
                    <td><?php echo $row['nombre_producto']; ?></td>
                    <td><?php echo $row['descripcion_producto']; ?></td>
                    <td><?php echo $row['nombre_categoria']; ?></td>
                    <td><?php echo $row['precio_producto']; ?></td>
                    <td><?php echo $row['cantidad_stock']; ?></td>
                    <td><?php echo $row['nombre_proveedor']; ?></td>
                    <td><?php echo $row['codigo_barras_producto']; ?></td>
                    <td><?php echo $row['fecha_adquisicion_producto']; ?></td>
                    <td><?php echo $row['nombre_marca']; ?></td>
                    <td><?php echo $row['ubicacion_almacen_producto']; ?></td>
                    <td><?php echo $row['nombre_estado']; ?></td>
                    <td>
                        <button class="btn-editar-producto" data-producto='<?php echo json_encode($row); ?>'>Editar</button>
                        <a href="eliminar_producto.php?referencia=<?php echo $row['referencia_producto']; ?>" class="btn-eliminar-producto">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botonesEditar = document.querySelectorAll('.btn-editar-producto');
    const botonesEliminar = document.querySelectorAll('.btn-eliminar-producto');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', function () {
            const producto = JSON.parse(this.dataset.producto);
            document.getElementById('referenciaProducto').value = producto.referencia_producto;
            document.getElementById('nombreProducto').value = producto.nombre_producto;
            document.getElementById('descripcion').value = producto.descripcion_producto;
            document.getElementById('categoria').value = producto.id_categoria;
            document.getElementById('precio').value = producto.precio_producto;
            document.getElementById('cantidadEnStock').value = producto.cantidad_stock;
            document.getElementById('proveedor').value = producto.id_proveedor;
            document.getElementById('codigoDeBarras').value = producto.codigo_barras_producto;
            document.getElementById('fechaAdquisicion').value = producto.fecha_adquisicion_producto;
            document.getElementById('marca').value = producto.id_marca;
            document.getElementById('ubicacionEnAlmacen').value = producto.ubicacion_almacen_producto;
            document.getElementById('estado').value = producto.id_estado;

            document.getElementById('editarProducto').value = true;
        });
    });

    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', function (event) {
            if (!confirm('¿Está seguro de que desea eliminar este producto?')) {
                event.preventDefault();
            }
        });
    });
});

function limpiarFormulario() {
    document.getElementById('product-form').reset();
    document.getElementById('referenciaProducto').value = "<?php echo obtenerSiguienteReferencia($conn); ?>";
    document.getElementById('editarProducto').value = "";
}
</script>
