<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MotorApp</title>
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,200,0,0" />
	<link rel="stylesheet" href="style.css">
	<script src="https://code.iconify.design/2/2.2.0/iconify.min.js"></script>
</head>

<body>
	<!-- Aqui Empieza nuestra barra de navagacion responsive-->
	<nav>
		<div class="mobile">
			<div class="header">
					<div class="logo">
					<a class="aLogo" href="Nosotros.php"><img class="tamañoLogo" src="./Imagenes/LogoMotorApp.jpg" alt="Logo MotorApp"></a>
					</div>
				<div class="more">
					<button id="bMore">
						<span class="material-symbols-outlined">menu</span>
					</button>
				</div>
			</div>
			<div id="links" class="links">
				<a href="index.html">Inicio</a>
				<a href="Perfil.php">Mi perfil</a>
				<a href="Apartados/Paginas/Login.php">Iniciar Sesion</a>
				<a href="Apartados/Paginas/Registro.php">Registrarse</a>
			</div>
		</div>
		<div class="desktop">
			<div class="logo">
				<a class="aLogo" href="Nosotros.php"><img class="tamañoLogo" src="./Imagenes/LogoMotorApp.jpg" alt="Logo MotorApp"></a>
			</div>
			<div class="primary">
				<a href="index.php">Inicio</a>
				<a href="Perfil.php">Mi perfil</a>
			</div>
			<div class="secondary full">
				<a href="Apartados/Paginas/Login.php">Iniciar Sesion</a>
				<a href="Apartados/Paginas/Registro.php">Registrarse</a>
			</div>
			<div class="secondary mini">
				<a href="#" class="more">Menu</a>
				<div class="submenu">
					<a href="Apartados/Paginas/Login.php">Iniciar Sesion</a>
					<a href="Apartados/Paginas/Registro.php">Registrarse</a>
				</div>
			</div>
		</div>
	</nav>
	<script>
		const bMore = document.querySelector("#bMore");
		const links = document.querySelector("#links")

		bMore.addEventListener("click", (e) => {
			links.classList.toggle("collapsed");
		});
	</script>