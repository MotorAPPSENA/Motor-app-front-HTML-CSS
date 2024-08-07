<?php
require_once 'database.php';

// Manejo del formulario para agregar productos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['agregarProducto'])) {
    // Recoger datos del formulario y asegurar que no estén vacíos
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
<div class="contenedorProductos">
    <div class="contenedorFormulario">
        <h1 class="tituloContenedor">Añadir productos</h1>
        <form id="product-form" action="productos.php" method="post">
            <div>
                <label for="referenciaProducto">Referencia del producto</label>
                <input type="text" id="referenciaProducto" name="referenciaProducto" required>
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
                </select><br>
                <a class="enlacesformulario" href="marcas.php">Agregar Marca</a>
            </div>
            <div>
                <label for="ubicacionEnAlmacen">Ubicación en Almacén</label>
                <input type="text" id="ubicacionEnAlmacen" name="ubicacionEnAlmacen" required>
            </div>
            <div>
                <label for="estado">Estado</label>
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
            <div class="botonesformulario">
            <button type="submit" name="agregarProducto" class="BotonAgregar">Agregar Producto</button>
            <button type="button" class="BotonAgregar" onclick="clearForm()">Limpiar</button>
            </div>
        </form>
    </div>
    <div class="contenedorListaProductos">
        <table class="tablaproductos">
            <thead class="encabezadostabla">
                <tr>
                    <th>Referencia</th>
                    <th>Nombre del Producto</th>
                    <th>Descripción</th>
                    <th>Categoría</th>
                    <th>Precio</th>
                    <th>Cantidad en Stock</th>
                    <th>Proveedor</th>
                    <th>Código de Barras</th>
                    <th>Fecha de Adquisición</th>
                    <th>Marca</th>
                    <th>Ubicación en Almacén</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="product-list">
                <?php
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$row['referencia_producto']}</td>
                                <td>{$row['nombre_producto']}</td>
                                <td>{$row['descripcion_producto']}</td>
                                <td>{$row['nombre_categoria']}</td>
                                <td>{$row['precio_producto']}</td>
                                <td>{$row['cantidad_stock']}</td>
                                <td>{$row['nombre_proveedor']}</td>
                                <td>{$row['codigo_barras_producto']}</td>
                                <td>{$row['fecha_adquisicion_producto']}</td>
                                <td>{$row['nombre_marca']}</td>
                                <td>{$row['ubicacion_almacen_producto']}</td>
                                <td>{$row['nombre_estado']}</td>
                                <td>
                                    <button onclick=\"editProduct(this)\">Editar</button>
                                    <button onclick=\"deleteProduct(this)\">Eliminar</button>
                                    <button onclick=\"saveProduct(this)\" style=\"display:none;\">Guardar</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='13'>No hay productos</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Función para limpiar el formulario
function clearForm() {
    document.getElementById('product-form').reset();
}

// Función para editar un producto de la tabla
function editProduct(button) {
    const row = button.closest('tr');
    const cells = row.getElementsByTagName('td');
    
    for (let i = 0; i < cells.length - 1; i++) {
        const cell = cells[i];
        const input = document.createElement('input');
        input.type = 'text';
        input.value = cell.innerText;
        cell.innerText = '';
        cell.appendChild(input);
    }
    
    const saveButton = row.querySelector('button[onclick="saveProduct(this)"]');
    saveButton.style.display = 'inline';
    button.style.display = 'none';
}

// Función para guardar los cambios de un producto editado en la tabla
function saveProduct(button) {
    const row = button.closest('tr');
    const inputs = row.querySelectorAll('input');
    const referencia = inputs[0].value;

    if (confirm(`¿Estás seguro de que deseas guardar los cambios para el producto con referencia ${referencia}?`)) {
        const formData = new FormData();
        formData.append('referenciaProducto', referencia);
        formData.append('nombreProducto', inputs[1].value);
        formData.append('descripcion', inputs[2].value);
        formData.append('categoria', inputs[3].value);
        formData.append('precio', inputs[4].value);
        formData.append('cantidadEnStock', inputs[5].value);
        formData.append('proveedor', inputs[6].value);
        formData.append('codigoDeBarras', inputs[7].value);
        formData.append('fechaAdquisicion', inputs[8].value);
        formData.append('marca', inputs[9].value);
        formData.append('ubicacionEnAlmacen', inputs[10].value);
        formData.append('estado', inputs[11].value);

        fetch('editar_producto.php', {
            method: 'POST',
            body: formData
        }).then(response => response.text())
        .then(data => {
            alert(data);
            window.location.reload();
        }).catch(error => {
            console.error('Error:', error);
        });
    }
}

// Función para eliminar un producto de la tabla
function deleteProduct(button) {
    const row = button.closest('tr');
    const referencia = row.getElementsByTagName('td')[0].innerText;

    if (confirm(`¿Estás seguro de que deseas eliminar el producto con referencia ${referencia}?`)) {
        window.location.href = `eliminar_producto.php?referencia=${referencia}`;
    }
}
</script>

