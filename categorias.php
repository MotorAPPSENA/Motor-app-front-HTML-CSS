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
        <div class="tituloFormulario"><label for="nombreCategoria">Escribe el nombre de la nueva Categoría</label></div>
        <div><input class="inputFormulario" type="text" id="nombreCategoria" name="nombre_categoria" required></div>
        <div><button class="botonAgregarFormulario" type="submit" name="agregarCategoria">Agregar</button></div>
    </form>
</div>
<table class="contenedorTabla" >
    <thead>
        <tr>
            <th>Id</th>
            <th>Categoria</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>prueba</td>
            <td>prueba</td>
        </tr>
        <tr>
            <td>prueba</td>
            <td>prueba</td>
        </tr>
    </tbody>
</table>
</body>

</html>