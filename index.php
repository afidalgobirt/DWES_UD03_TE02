<?php
    include ("conexion.php");

    $bd = new BaseDatos();
    $conexion = $bd->conectar();
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <div class="header">
            <h1>TIENDA BIRT</h1>
        </div>

        <div class="nav">
            <a class="botonNav">Familia</a>
            <a class="botonNav" href="index.php">Tipo</a>
            <a class="botonNav" href="fichaProductos.php">Producto</a>
            <a class="botonNav">Usuario</a>
        </div>

        <div class="content">
            <?php
                $resTipoProd = $bd->seleccionar("select * from tipo_producto");
                while ($tipoProd = $resTipoProd->fetch_assoc()) {
            ?>
                <div class="itemTipoProducto">
                    <span><?php echo $tipoProd['DescTipoProd'];?></span>
                </div>
            <?php }?>
        </div>
    </body>
</html>
