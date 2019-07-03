<?php
session_start();
include_once("../conx.php");

if (isset($_POST["cargar"])) {
	$producto = $_POST["producto"];
	$desc = $_POST["desc"];
	$precio = $_POST["precio"];
	$cant = $_POST["cant"];
	$idcomercio = $_POST["idcomercio"];
	$imgdir = "imgs/default.jpeg";

	$query = "INSERT INTO productos (nom, descript, imgurl, precio, cant, idcomercio) VALUES ('$producto', '$desc', '$imgdir','$precio', '$cant', $idcomercio)";
	$consulta = mysqli_query($link, $query);

	if(isset($_FILES["img"])){
		$tmp_name = $_FILES["img"]["tmp_name"];
		$name = mysqli_insert_id($link);
		$namedir = join("\\", array(__DIR__, "..","imgs" ,$name . "." . pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION)));

		if(move_uploaded_file($tmp_name, $namedir)) $imgdir = "imgs/$name." . pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
		mysqli_query($link, "UPDATE productos SET imgurl = '$imgdir' WHERE idproducto = $name");
	}

	if ($consulta) echo "<script>alert('El producto se cargo satisfactoriamente'); window.location='./mostrar.php';</script>";
	else {
		$error = mysqli_error($link);
		echo '<script>alert("Hubo un fallo en la carga del producto");console.log("'.$error.'")</script>';}
}

$comercios = mysqli_query($link, "SELECT idcomercio, nom FROM comercios");
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/w3.css">
	<title>Cargar producto</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="../" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item w3-amber" href="./productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="../cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item" href="../cargarcomercio.php">Cargar comercio</a>
		<a class="w3-bar-item" href="../facturas/mostrar.php">Mostrar facturas</a
		>
		<?php if(isset($_SESSION["userId"])){
			$user = $_SESSION["userName"];
			echo "<a class='w3-bar-item' href='../misfacturas.php'>Mis facturas</a>"; 
		}?>
		<a class="w3-bar-item" href="../login.php">
			<?php if(isset($_SESSION["userId"])) echo "Cerrar sesión";
				else echo "Login";?></a>	
	</div>

	<form class="w3-container" method="POST" enctype="multipart/form-data">
		<p>	
			<label>Imagen del producto</label><br>
			<input type="file" name="img" id="img" accept="image/jpeg, image/x-png"required>
		</p>
		<p>
			<input type="text" name="producto" placeholder="Nombre del producto" required>
		</p>
		<p>
			<input type="text" name="desc" placeholder="Descripción del producto" required>
		</p>
		<p>
			<input type="number" name="precio" placeholder="Precio del producto" required>
		</p>
		<p>
			<input type="number" name="cant" placeholder="Cantidad de stock" required>
		</p>
		<p>
			<label>Selecciona el comercio</label><br>
			<select name="idcomercio">
				<?php
				while ($r = mysqli_fetch_array($comercios)) {
					echo "<option value=$r[0]>$r[1]</option>";
				}
				?>
			</select>
		</p>
		<button class="w3-button w3-green" type="submit" name="cargar">Cargar</button>
	</form>
</body>

</html>