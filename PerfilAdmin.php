<?php
session_start();

// Verificar si la sesión está establecida
if(!isset($_SESSION['n_identificacion'])) {
    // Si la sesión no está establecida, redirigir al usuario a la página de inicio de sesión
    header("Location: login.php");
    exit();
}
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
    <div class="contenedorTablas">
        <table>
            <caption>Mis pedidos</caption>
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Fecha compra</th>
                    <th>Estado</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>000001</td>
                    <td>16/01/2024</td>
                    <td>Entregado</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/Producto casco.jpg"
                            alt=""></td>
                    <td>MotuoMr Casco de motocicleta unisex</td>
                    <td>296.000$</td>
                </tr>
                <tr>
                    <td>002562</td>
                    <td>16/01/2024</td>
                    <td>Entregado</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/Producto Chaqueta.jpg"
                            alt=""></td>
                    <td>Chaqueta de motocicleta para motocicleta</td>
                    <td>430.000$</td>
                </tr>
                <tr>
                    <td>000054</td>
                    <td>16/01/2024</td>
                    <td>Enviado</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/producto guantes.jpg"
                            alt=""></td>
                    <td>COFIT - Guantes de motocicleta para hombres y mujeres, compatibles con pantalla táctil</td>
                    <td>78.000 $</td>
                </tr>
                <tr>
                    <td>001800</td>
                    <td>16/01/2024</td>
                    <td>Entregado</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/producto balaclava.jpg"
                            alt=""></td>
                    <td>ILM Motorcycle Balaclava Face Mask for Ski Model FM01</td>
                    <td>33.000$</td>
                </tr>
                <tr>
                    <td>0000200</td>
                    <td>16/01/2024</td>
                    <td>Cerrado</td>
                    <td> <img class="tamañoImgPedidos"
                            src="../../Imagenes/Imagenes Productos/producto chaqueta malla.jpg" alt=""></td>
                    <td>Chaqueta de malla para motocicleta para hombre, chaqueta de verano para motociclismo con
                        chaqueta de protección Armor Racing</td>
                    <td>213.000$</td>
                </tr>
                <tr>
                    <td>000016</td>
                    <td>16/01/2024</td>
                    <td>Cerrado</td>
                    <td> <img class="tamañoImgPedidos"
                            src="../../Imagenes/Imagenes Productos/producto chaqueta malla.jpg" alt=""></td>
                    <td>Chaqueta de malla para motocicleta para hombre, chaqueta de verano para motociclismo con
                        chaqueta de protección Armor Racing</td>
                    <td>213.000$</td>
                </tr>
                <tr>
                    <td>000425</td>
                    <td>16/01/2024</td>
                    <td>Cerrado</td>
                    <td> <img class="tamañoImgPedidos"
                            src="../../Imagenes/Imagenes Productos/producto chaqueta malla.jpg" alt=""></td>
                    <td>Chaqueta de malla para motocicleta para hombre, chaqueta de verano para motociclismo con
                        chaqueta de protección Armor Racing</td>
                    <td>213.000$</td>
                </tr>
                <tr>
                    <td>000224</td>
                    <td>16/01/2024</td>
                    <td>Cerrado</td>
                    <td> <img class="tamañoImgPedidos"
                            src="../../Imagenes/Imagenes Productos/producto chaqueta malla.jpg" alt=""></td>
                    <td>Chaqueta de malla para motocicleta para hombre, chaqueta de verano para motociclismo con
                        chaqueta de protección Armor Racing</td>
                    <td>213.000$</td>
                </tr>
                <tr>
                    <td>000145</td>
                    <td>16/01/2024</td>
                    <td>Cerrado</td>
                    <td> <img class="tamañoImgPedidos"
                            src="../../Imagenes/Imagenes Productos/producto chaqueta malla.jpg" alt=""></td>
                    <td>Chaqueta de malla para motocicleta para hombre, chaqueta de verano para motociclismo con
                        chaqueta de protección Armor Racing</td>
                    <td>213.000$</td>
                </tr>


            </tbody>
        </table>

        <table class="tablaCarrito">
            <caption>Carrito</caption>
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Estado</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Total</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>000001</td>
                    <td>Carrito</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/Producto casco.jpg"
                            alt=""></td>
                    <td>MotuoMr Casco de motocicleta unisex</td>
                    <td>296.000$</td>
                    <td>
                        <div class="botonesTablas">
                            <button>Comprar</button>
                            <button>Eliminar de carrito</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>002562</td>
                    <td>Carrito</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/Producto Chaqueta.jpg"
                            alt=""></td>
                    <td>Chaqueta de motocicleta para motocicleta</td>
                    <td>430.000$</td>
                    <td>
                        <div class="botonesTablas">
                            <button>Comprar</button>
                            <button>Eliminar de carrito</button>
                        </div>
                    </td>

                </tr>
                <tr>
                    <td>000054</td>
                    <td>Carrito</td>
                    <td> <img class="tamañoImgPedidos" src="../../Imagenes/Imagenes Productos/producto guantes.jpg"
                            alt=""></td>
                    <td>COFIT - Guantes de motocicleta para hombres y mujeres, compatibles con pantalla táctil</td>
                    <td>78.000 $</td>
                    <td>
                        <div class="botonesTablas">
                            <button>Comprar</button>
                            <button>Eliminar de carrito</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <nav>
        <header>
            <a class="estiloInicio" href="index.php">
                <div class="bar">Inicio</div>
            </a>
            <div class="user">
                <img src="Imagenes/fotoPerfil.jpg" alt="perfil">
                <div class="name">Nombre Administrador</div>
            </div>
        </header>
        <div class="links">
            <a href="#">
                <div class="icon">
                    <span class="iconify-inline" data-icon="flat-color-icons:assistant" data-width="32"
                        data-heigth="32"></span>
                </div>
                <div class="title">Productos</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:contacts" data-width="32" data-heigth="32">
                    </span>
                </div>
                <div class="title">Proveedores</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Marcas</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Categorías</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Pedidos</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Clientes</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Configuración</div>
            </a>
            <a href="#">
                <div class="icon">
                    <span class="iconify" data-icon="flat-color-icons:about" data-width="32" data-heigth="32"></span>
                </div>
                <div class="title">Cerrar sesión</div>
            </a>
        </div>
    </nav>
</body>
</html>