<?php
session_start();
include_once("conx.php");

if (isset($_POST["cargar"])) {
	$nom = $_POST["nom"];
	$ciudad = $_POST["ciudad"];
	$calle = $_POST["calle"];
	$num = $_POST["num"];
	$nomDueno = $_POST["nomdueno"];
	$apeDueno = $_POST["apedueno"];
	$dniDueno = $_POST["dnidueno"];


	$query = "INSERT INTO comercios (nom, ciudad, calle, numero, nomdueno, apedueno, dnidueno) VALUES ('$nom', '$ciudad', '$calle', '$num', '$nomDueno', '$apeDueno', '$dniDueno')";
	$consulta = mysqli_query($link, $query);

	if ($consulta) echo "<script>alert('El comercio se cargo satisfactoriamente'); window.location='./';</script>";
	else echo "<script>alert('Hubo un fallo en la carga del comercio');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/w3.css">
	<title>Cargar comercio</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="./" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item" href="./productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="./productos/mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item w3-amber" href="cargarcomercio.php">Cargar comercio</a>
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
			<input type="text" name="nom" placeholder="Nombre del comercio" required>
		</p>
		<p>
			<input type="text" name="ciudad" placeholder="Ciudad" required>
		</p>
		<p>
			<input type="text" name="calle" placeholder="Calle" required>
		</p>
		<p>
			<input type="number" name="num" placeholder="Número" required>
		</p>
		<p>
			<input type="text" name="nomdueno" placeholder="Nombre del dueño" required>
		</p>
		<p>
			<input type="text" name="apedueno" placeholder="Apellido del dueño" required>
		</p>
		<p>
			<input type="number" name="dnidueno" placeholder="DNI del dueño" required pattern="[0-9]">
		</p>
		<button class="w3-button w3-green" type="submit" name="cargar">Cargar</button>
	</form>
</body>

</html>