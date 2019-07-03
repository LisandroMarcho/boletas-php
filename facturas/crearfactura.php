<?php
include_once("../conx.php");
session_start();

if (isset($_POST["crear"])) {
	if (isset($_POST["id"])) {
		$total = $_POST["total"];
		$idcomercio = $_POST["idcomercio"];
		$idcliente = $_POST["idcliente"];
		$idusuario = $_SESSION['userId'];
		$fecha = Date("Y-m-d");

		$consulta = mysqli_query($link, "INSERT INTO facturas (total, fecha, idcomercio, idcliente, idusuario) VALUES ($total, '$fecha', $idcomercio, $idcliente, $idusuario)");
		$idfactura = mysqli_insert_id($link);

		if ($consulta) {
			foreach ($_POST["id"] as $index => $id) {
				$producto = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM productos WHERE idproducto = $id"));
				$cant = $_POST["cant"][$index];
				$stockactual = $producto["cant"] - $cant;
				$sub = $producto["precio"] * $cant;

				$detalle = mysqli_query($link, "INSERT INTO detalles (idfactura, idproducto, uni, subtotal) VALUES ($idfactura, $id, $cant, $sub)");
				$resta = mysqli_query($link, "UPDATE productos SET cant = $stockactual WHERE idproducto = $id;");
				if ($detalle) echo "<script>console.log('Detalle cargado #$key');</script>";
			}
		}

		echo "<script>alert('Factura creada'); window.location = './mostrar.php';</script>";
	} else {
		echo "<script>alert('No hay suficientes elementos');</script>";
	}
}

if (isset($_POST["id"]) && isset($_POST["deprods"])) {
	$clientes = mysqli_query($link, "SELECT * FROM clientes");
	$idcomercio = $_POST["idcomercio"];
	$comercio = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM comercios WHERE idcomercio = $idcomercio"));
	//print_r($comercio);
} else {
	echo "<script>alert('Selecciona al menos un elemento'); window.location='../productos/mostrar.php'</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="../css/w3.css">
	<title>Crear factura</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="../" class="w3-bar-item">Inicio</a>
		<a class="w3-bar-item" href="../productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="../productos/mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="../cargarcliente.php">Cargar cliente</a>
		<a class="w3-bar-item" href="../cargarcomercio.php">Cargar comercio</a>
		<a class="w3-bar-item" href="mostrar.php">Mostrar facturas</a>
		<?php if(isset($_SESSION["userId"])){
			$user = $_SESSION["userName"];
			echo "<a class='w3-bar-item' href='../misfacturas.php'>Mis facturas</a>"; 
		}?>
	</div>
	<div class="w3-display-container">
		<form method="POST" class="w3-panel w3-display-topmiddle w3-center">
			<table border=1 id="factura" class="w3-half w3-table w3-bordered w3-border w3-striped w3-margin-bottom">
				<tr>
					<th colspan="5">
						Comercio: <?php
									echo strtoupper($comercio[1]) . "<br>";
									echo "$comercio[2], $comercio[3], $comercio[4]";
									echo "<input type='hidden' name='idcomercio' value=$comercio[0]>";
									?>
					</th>
				</tr>
				<tr>
					<th colspan="5">
						Cliente: <select name="idcliente" id="selectCliente" onchange="verCliente()">
							<?php
							while ($r = mysqli_fetch_array($clientes)) {
								echo "<option value=$r[0] data-dni='$r[3]' data-tel='$r[4]' data-email='$r[5]'>$r[2], $r[1]</option>";
							}
							?>
						</select><br>
						<label id="labelCliente"></label>
					</th>
				</tr>
				<tr>
					<th colspan="5">
						Nombre de usuario: <?php echo $_SESSION["userName"]; ?>
					</th>
				</tr>
				<tr>
					<th>Cant</th>
					<th>Producto</th>
					<th>Descripción</th>
					<th>Precio</th>
					<th>Subtotal</th>
				</tr>
				<?php
				foreach ($_POST["id"] as $id) {
					$query = "SELECT * FROM productos WHERE idproducto = $id";
					$producto = mysqli_fetch_array(mysqli_query($link, $query));
					echo "<tr>";
					echo "<input type='hidden' value=$producto[0] name='id[]' />";
					echo "<td><input type='number' value=1 max=$producto[5] min=1 name='cant[]' onchange='calcularSubtotal(this)' required><input type='hidden' value=$producto[5] name='prod[$producto[0]][stock]'></td>";
					echo "<td>$producto[1]</td>"; // Producto
					echo "<td>$producto[2]</td>"; // Descripcion 
					echo "<td><label>$producto[4]</label></td>"; // Precio
					echo "<td><input type='number' class='subtotal_' value='$producto[4]' readonly></td>";
					echo "</tr>";
				}
				?>
				<tr>
					<th colspan="4">Total:</th>
					<td id="tdTotal"><input type="number" name="total" readonly></td>
				</tr>
			</table>
			<p>
				<input class="w3-button w3-green" type="submit" name="crear" value="Guardar factura">
			</p>
		</form>

		<br>

	</div>
	<script src="../js/crearFactura.js"></script>
</body>

</html>