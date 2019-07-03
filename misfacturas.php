<?php
session_start();
include_once("conx.php");

	if(!isset($_SESSION["userId"])) header("Location: login.php");
	$idusuario = $_SESSION["userId"];
	$query = "SELECT * FROM facturas WHERE idusuario = $idusuario";
	$facturas = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/w3.css">
    <title>Facturas registradas</title>
</head>

<body>
    <div class="w3-bar w3-black">
        <a href="." class="w3-bar-item">Inicio</a>
        <a class="w3-bar-item" href="./productos/cargarproducto.php">Cargar productos</a>
        <a class="w3-bar-item" href="./productos/mostrar.php">Mostrar productos</a>
        <a class="w3-bar-item" href="cargarcliente.php">Cargar cliente</a>
        <a class="w3-bar-item" href="cargarcomercio.php">Cargar comercio</a>
        <a class="w3-bar-item" href="./facturas/mostrar.php">Mostrar facturas</a>
        <a class="w3-bar-item w3-amber" href="misfacturas.php">Mis facturas</a>
        <a class="w3-bar-item" href="login.php">Cerrar sesión</a>
    </div>
    	
        <div class="w3-panel">
        	<p><h3>Facturas de <?php echo $_SESSION["userName"] ?></h3></p>
        	<div class="w3-display-container">
            <table class="w3-display-topmiddle w3-table w3-striped w3-bordered w3-border">
                <tr class="w3-bordered">
                    <th>#ID</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th></th>
                </tr>
                <?php
                while ($r = mysqli_fetch_array($facturas)) {
                    $cliente = mysqli_query($link, "SELECT nom, ape FROM clientes WHERE idcliente = $r[4]");
                    $cliente = mysqli_fetch_array($cliente);
                    echo "<tr class='w3-bordered'><td>#$r[0]</td><td>$cliente[1], $cliente[0]</td><td>$$r[1]</td><td>" . date("d/m/Y", strtotime($r[2])) . "</td><td><a href='facturas/detalles.php?id=$r[0]'>Detalles</a></td></tr>";
                }
                ?>
            </table>
            </div>
        </div>
</body>

</html>