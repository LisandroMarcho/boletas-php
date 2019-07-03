<?php
	session_start();
	include_once("conx.php");

	if(isset($_POST["crear"])){
		$usuario = $_POST["username"];
		$pass = $_POST["pass"];
		$hash = password_hash($pass, PASSWORD_DEFAULT);

		$queryExiste = "SELECT * FROM usuarios WHERE nom = '$usuario'";
		$consulta = mysqli_query($link, $queryExiste);

		if(!mysqli_num_rows($consulta)){
			$queryInsert = "INSERT INTO usuarios (nom, pass) VALUES ('$usuario', '$hash')";

			if($consulta = mysqli_query($link, $queryInsert)){
				echo "<script>alert('Se creó el usuario'); window.location = '';</script>";	
			}
		}else{
			echo "<script>alert('Ya hay un usuario con ese nombre');</script>";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/w3.css">
	<title>Comercio</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="./" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item" href="./productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="./productos/mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item" href="cargarcomercio.php">Cargar comercio</a>
		<a class="w3-bar-item" href="./facturas/mostrar.php">Mostrar facturas</a>
		<?php if(isset($_SESSION["userId"])){
			$user = $_SESSION["userName"];
			echo "<a class='w3-bar-item' href='misfacturas.php'>Mis facturas</a>"; 
		}?>
		<a class="w3-bar-item w3-amber" href="login.php">Login</a>
	</div>
	<div class="w3-container">
		<h2>Registrarse</h2>
		<form method="POST" class="w3-padding">
			<input type="text" name="username" placeholder="Nombre de usuario" required><br><br>
			<input type="password" name="pass" placeholder="Contraseña" required><br><br>
			<a href="login.php">Iniciar sesión</a><br>
			<input type="submit" value="Crear usuario" name="crear" class="w3-button w3-green">
		</form>
	</div>
</body>

</html>