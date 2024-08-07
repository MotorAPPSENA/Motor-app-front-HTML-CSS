<?php
require_once "database.php";

$message = "";


if (!empty($_POST["nombre_categoria"])) {

    $checkSql = "SELECT COUNT(*) FROM categoria_producto WHERE nombre_categoria = :nombre_categoria";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bindParam(":nombre_categoria", $_POST["nombre_categoria"]);
    $checkStmt->execute();
    $countCategoria = $checkStmt->fetchColumn();

    if ($countCategoria > 0) {
        $message = "¡¡La categoria que ingresaste ya se encuentra registrada!!";
    } else
        $sql = "INSERT INTO categoria_producto (nombre_categoria) 
                    VALUES (:nombre_categoria)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":nombre_categoria", $_POST["nombre_categoria"]);

    if ($stmt->execute()) {
        $message = "¡¡Categoria Registrada exitosamente!!";
    } else {
        $message = "¡¡Error en registro!!";
    }
}
?>
<?php require ('Apartados/Paginas/apartadoadmin.php'); ?>
<link rel="stylesheet" href="Estilo Apartados/formulariosAdmin.css">
<div class="contenedorFormulario">
    <form action="categorias.php" method="post">
        <div class="tituloFormularioSuperior"><h1 for="nombreCategoria">Diligencia la siguiente infromación del nuevo Proveedor</h1></div>
        <div class="tituloFormulario"><label for="nombreCategoria">Nombre</label></div>
        <div><input class="inputFormulario" type="text" id="nombreCategoria" name="nombre_categoria" required></div>
        <div class="tituloFormulario"><label for="nombreCategoria">dirección</label></div>
        <div><input class="inputFormulario" type="text" id="nombreCategoria" name="nombre_categoria" required></div>
        <div class="tituloFormulario"><label for="nombreCategoria">Telefono</label></div>
        <div><input class="inputFormulario" type="text" id="nombreCategoria" name="nombre_categoria" required></div>
        <div class="tituloFormulario"><label for="nombreCategoria">Correo electronico</label></div>
        <div><input class="inputFormulario" type="email" id="nombreCategoria" name="nombre_categoria" required></div>
        <div><button class="botonAgregarFormulario" type="submit" name="agregarCategoria">Agregar</button></div>
    </form>
</div>
<table class="contenedorTabla">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Direccion</th>
            <th>Telefono</th>
            <th>Correo electronicon</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
        </tr>
        <tr>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
            <td>prueba</td>
        </tr>
    </tbody>
</table>
</body>

</html>