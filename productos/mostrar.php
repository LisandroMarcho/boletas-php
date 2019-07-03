<?php
	session_start();
	include_once("../conx.php");

	if(!isset($_SESSION["userName"])){
		header("Location: ../login.php");
	}

	if(isset($_GET["idcomercio"])) $idcomercio = $_GET["idcomercio"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/w3.css">
	<title>Productos</title>
</head>
<body>
	<div class="w3-bar w3-black">
		<a href="../" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item" href="cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item w3-amber" href="mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="../cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item" href="../cargarcomercio.php">Cargar comercio</a>
		<a class="w3-bar-item" href="../facturas/mostrar.php">Mostrar facturas</a>
		<?php if(isset($_SESSION["userId"])){
			$user = $_SESSION["userName"];
			echo "<a class='w3-bar-item' href='../misfacturas.php'>Mis facturas</a>"; 
		}?>
		<a class="w3-bar-item" href="../login.php">
			<?php if(isset($_SESSION["userId"])) echo "Cerrar sesión";
				else echo "Login";?></a>
	</div>
	<?php if(isset($idcomercio)): $productos = mysqli_query($link, "SELECT * FROM productos WHERE idcomercio = $idcomercio AND cant >= 1")?>
	<form class="w3-panel w3-table" method="POST" action="../facturas/crearfactura.php">
		<?php echo "<input type='hidden' name='idcomercio' value=$idcomercio>"; ?>
		<div class="w3-display-container">
			<table class="w3-display-topmiddle w3-table w3-striped w3-bordered w3-border">
				<tr><th></th><th>#ID</th><th>Producto</th><th>Descripciòn</th><th>Stock</th><th>Precio</th><th></th></tr>
				<?php
					while($r = mysqli_fetch_array($productos)){
						echo "<tr>
								<td><img width='150px' src='../$r[3]'></td>
								<td>$r[1]</td>
								<td>$r[2]</td>
								<td>$r[5]</td>
								<td>$r[4]</td>
								<td><input class='checkprod' type='checkbox' value=$r[0] name='id[]' onclick='checkTo10(this)' /></td>
							</tr>";
					}
				?>
			</table>
		</div>
		<input class="w3-button w3-green w3-display-bottommiddle w3-margin-bottom" type="submit" name="deprods" value="Ir a facturación">

		<script src="../js/checkprod.js"></script>
	</form>
	<?php else: $comercios = mysqli_query($link, "SELECT idcomercio, nom FROM comercios")?>
	<form class="w3-panel" method="get">
		<select name="idcomercio">
			<?php
				while($r = mysqli_fetch_array($comercios)){
					echo "<option value=$r[0]>$r[1]</option>";
				}
			?>
		</select><br><br>
		<input class="w3-button w3-green" type="submit" value="Buscar...">
	</form>
	<?php endif; ?>
</body>
</html>