<?php session_start(); include_once("conx.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="css/w3.css">
	<title>Comercio</title>
</head>

<body>
	<div class="w3-bar w3-black">
		<a href="./" class="w3-bar-item w3-amber">Inicio</a>
		<a class="w3-bar-item" href="./productos/cargarproducto.php">Cargar productos</a>
		<a class="w3-bar-item" href="./productos/mostrar.php">Mostrar productos</a>
		<a class="w3-bar-item" href="cargarcliente.php">Cargar cliente</a>
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
	<div class="w3-container">
		<h1>Información de ventas</h1>
		<p>
			<h3>Comercios que más vendieron los últimos 30 días</h3>
			<ol>
				<?php
				$query = "SELECT * FROM comercios ORDER BY (SELECT COUNT(*) FROM facturas WHERE fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) LIMIT 5";
				$consulta = mysqli_query($link, $query);
				while ($r = mysqli_fetch_array($consulta)) {
					$facturas = mysqli_fetch_array(mysqli_query($link, "SELECT COUNT(*) FROM facturas WHERE (fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) AND idcomercio = $r[0]"));
					$ingresos = mysqli_fetch_array(mysqli_query($link, "SELECT SUM(total) FROM facturas WHERE (fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) AND idcomercio = $r[0]"));
					echo "<li><h4 style='margin-bottom: 0px;'>$r[1]</h4>$facturas[0] facturas - Ingresos: $$ingresos[0]</li>";
				}
				?>
			</ol>
		</p>
		<p>
			<h3>Productos más vendidos los últimos 30 días</h3>
			<ol>
				<?php
				$query = "SELECT detalles.idproducto, SUM(detalles.uni) AS TotalVentas
						FROM detalles
						WHERE (SELECT idfactura FROM facturas WHERE facturas.idfactura = detalles.idfactura AND (fecha BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()))
						GROUP BY detalles.idproducto
						ORDER BY SUM(detalles.uni) DESC
						LIMIT 5";
				$masvendidos = mysqli_query($link, $query);
				while ($r = mysqli_fetch_array($masvendidos)) {
					$producto = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM productos WHERE idproducto = $r[0]"));
					$comercio = mysqli_fetch_array(mysqli_query($link, "SELECT nom FROM comercios WHERE idcomercio = $producto[6]"));
					echo "<li><h4 style='margin-bottom: 0px;'>$producto[1]</h4><p style='margin: 0; padding: 0;'>$producto[2] - $r[1] unidades vendidas - $comercio[0]</p></li>";
				}
				?>
			</ol>
		</p>
	</div>
</body>

</html>