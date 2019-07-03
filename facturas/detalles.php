<?php
session_start();
include_once("../conx.php");


if (isset($_GET["id"])) :
    $idfactura = $_GET["id"];

    $detalles = mysqli_query($link, "SELECT * FROM detalles WHERE idfactura = $idfactura");
    $factura = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM facturas WHERE idfactura = $idfactura"));
    $comercio = mysqli_fetch_array(mysqli_query($link, "SELECT nom, ciudad, calle, numero FROM comercios WHERE idcomercio = $factura[3]"));
    $cliente = mysqli_fetch_array(mysqli_query($link, "SELECT * FROM clientes WHERE idcliente = $factura[4]"));
    $usuario = mysqli_fetch_array(mysqli_query($link, "SELECT nom FROM usuarios WHERE idusuario= $factura[5]"));
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/w3.css">
        <title>Detalles Factura #<?php echo $_GET["id"]; ?></title>
    </head>

    <body>
        <div class="w3-bar w3-black">
            <a href="../" class="w3-bar-item">Inicio</a>
            <a class="w3-bar-item" href="../productos/cargarproducto.php">Cargar productos</a>
            <a class="w3-bar-item" href="../productos/mostrar.php">Mostrar productos</a>
            <a class="w3-bar-item" href="../cargarcliente.php">Cargar cliente</a>
            <a class="w3-bar-item" href="../cargarcomercio.php">Cargar comercio</a>
            <a class="w3-bar-item w3-amber" href="mostrar.php">Mostrar facturas</a>
            <?php if(isset($_SESSION["userId"])){
            $user = $_SESSION["userName"];
            echo "<a class='w3-bar-item' href='../misfacturas.php'>Mis facturas</a>"; 
            }?>
        </div>
        <div class="w3-display-container">
            <table id="factura" class="w3-half w3-table w3-bordered w3-border w3-display-topmiddle w3-margin-top">
                <tr class="w3-bordered">
                    <th colspan="5">
                        Comercio: <?php echo $comercio[0] ?><br>
                        <label><?php echo "$comercio[1], $comercio[2], Nº$comercio[3]"; ?></label>
                    </th>
                </tr>
                <tr class="w3-bordered">
                    <th colspan="5">
                        Cliente: <?php echo strtoupper("$cliente[2], $cliente[1]"); ?><br>
                        <label><?php echo "DNI: $cliente[3] - Tel: $cliente[4] <br> E-Mail: $cliente[5]"; ?></label>
                    </th>
                </tr>
                <tr>
                    <th colspan="3">Usuario:</th>
                    <td colspan="2"><?php echo $usuario[0]; ?></td>
                </tr>
                <tr class="w3-bordered">
                    <th colspan="3">
                        Fecha:
                    </th>
                    <td colspan="2">
                        <label><?php echo date("d/m/Y", strtotime($factura[2])); ?></label>
                    </td>
                </tr>
                <tr class="w3-bordered">
                    <th>Cant</th>
                    <th>Producto</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
                <?php
                while ($r = mysqli_fetch_array($detalles)) {
                    $producto = mysqli_fetch_array(mysqli_query($link, "SELECT nom, descript, precio FROM productos WHERE idproducto = $r[2]"));

                    echo "<tr><td>$r[3]</td><td>$producto[0]</td><td>$producto[1]</td><td>$$producto[2]</td><td>$$r[4]</td></tr>";
                }
                ?>
                <tr>
                    <th colspan="4">Total</th>
                    <td>$<?php echo $factura[1]; ?></td>
                </tr>
            </table>
        </div>
    </body>

    </html>
<?php
else : header("location: facturas.php");
endif;
?>