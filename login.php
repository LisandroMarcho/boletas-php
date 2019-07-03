<?php
	session_start();

	include_once("conx.php");

	if(isset($_SESSION["userName"])){
		session_destroy();
		echo "<script>alert('Se cerró la sesión!'); window.location = 'index.php';</script>";
	}else{
		if(isset($_POST["entrar"])){
			$nom = $_POST["username"];
			$pass = $_POST["pass"];
			
			$query = "SELECT idusuario, pass FROM usuarios WHERE nom = '$nom'";
			$consulta = mysqli_query($link, $query);
			
			if(mysqli_num_rows($consulta)==1){
				$data = mysqli_fetch_array($consulta);

				if(password_verify($pass, $data["pass"])){
					$_SESSION["userName"] = $_POST["username"];
					$_SESSION["userId"] = $data["idusuario"];
					echo "<script>alert('Iniciaste sesion correctamente!'); window.location = 'index.php';</script>";
				}else{
				echo "<script>alert('Contraseña incorrecta');";
				}

			}else{
				echo "<script>alert('Error en el inicio de sesion')</script>";
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
		<h2>Iniciar sesión</h2>
		<form method="POST" class="w3-padding">
			<input type="text" name="username" placeholder="Nombre de usuario" required><br><br>
			<input type="password" name="pass" placeholder="Contraseña" required><br><br>
			<a href="registrar.php">Registar un nuevo usuario</a><br>
			<input type="submit" value="Entrar" name="entrar" class="w3-button w3-green">
		</form>
	</div>
</body>

</html>
<?php } ?>