<?php
session_start();

// Verificar si la sesión está establecida
if(!isset($_SESSION['n_identificacion'])) {
    // Si la sesión no está establecida, redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();
}

// Conectar a la base de datos
include 'database.php'; // Asegúrate de que este archivo contiene tu lógica de conexión a la base de datos

// Obtener la información del usuario
$n_identificacion = $_SESSION['n_identificacion'];
$query = "SELECT nombre, foto_perfil FROM usuarios WHERE n_identificacion = :n_identificacion";
$stmt = $conn->prepare($query);
$stmt->execute(['n_identificacion' => $n_identificacion]);
$usuario = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Estilo Apartados/perfil.css">
    <script src="https://code.iconify.design/2/2.2.0/iconify.min.js"></script>
</head>

<body>
    <nav>
        <header>
            <a class="estiloInicio" href="index.php">
                <div class="bar">Inicio</div>
            </a>
            <div class="user">
                <img src="<?php echo $usuario['foto_perfil'] ?: 'Imagenes/fotoPerfil.jpg'; ?>" alt="perfil">
                <div class="name"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
            </div>
        </header>
        <div class="links">
            <a href="productos.php">
                <div class="icon">
                    <span class="iconify-inline" data-icon="flat-color-icons:assistant" data-width="32"
                        data-heigth="32"></span>
                </div>
                <div class="title">Productos</div>
            </a>
            <a href="proveedores.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:contacts" data-width="32" data-heigth="32">
                    </span>
                </div>
                <div class="title">Proveedores</div>
            </a>
            <a href="marcas.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Marcas</div>
            </a>
            <a href="categorias.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Categorías</div>
            </a>
            <a href="pedidos.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Pedidos</div>
            </a>
            <a href="clientes.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Clientes</div>
            </a>
            <a href="configuracion.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Configuración</div>
            </a>
            <a href="index.php">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Cerrar sesión</div>
            </a>
        </div>
    </nav>
</body>
</html>
