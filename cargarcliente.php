<?php
session_start();
include_once("conx.php");

if (isset($_POST["cargar"])) {
	$nom = $_POST["nom"];
	$ape = $_POST["ape"];
	$dni = $_POST["dni"];
	$tel = $_POST["tel"];
	$email = $_POST["email"];

	$query = "INSERT INTO clientes (nom, ape, dni, tel, email) VALUES ('$nom', '$ape', '$dni', '$tel', '$email')";
	//		echo $query;
	$consulta = mysqli_query($link, $query);

	if ($consulta) echo "<script>alert('El cliente se cargo satisfactoriamente'); window.location='./';</script>";
	else echo "<script>alert('Hubo un fallo en la carga del cliente');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/w3.css">
	<title>Cargar cliente</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="./" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item" href="./productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="./productos/mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item w3-amber" href="cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item" href="cargarcomercio.php">Cargar comercio</a>
		<a class="w3-bar-item" href="./facturas/mostrar.php">Mostrar facturas</a>
		<?php if(isset($_SESSION["userId"])){
			$user = $_SESSION["userName"];
			echo "<a class='w3-bar-item' href='misfacturas.php'>Mis facturas</a>"; 
		}?>
		<a class="w3-bar-item" href="login.php">
			<?php if(isset($_SESSION["userId"])) echo "Cerrar sesión";
				else echo "Login";?></a>
	</div>
	<form class="w3-panel" method="POST">
		<p>
			<input type="text" name="nom" placeholder="Nombre" required>
		</p>
		<p>
			<input type="text" name="ape" placeholder="Apellido" required>
		</p>
		<p>
			<input type="number" name="dni" placeholder="D.N.I." required pattern="[0-9]">
		</p>
		<p>
			<input type="number" name="tel" placeholder="Teléfono" required>
		</p>
		<p>
			<input type="email" name="email" placeholder="E-Mail" required>
		</p>
		<button class="w3-button w3-green" type="submit" name="cargar">Cargar</button>
	</form>
</body>

</html>