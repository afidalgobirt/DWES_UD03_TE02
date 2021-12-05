<?php
    include ("conexion.php");

    $bd = new BaseDatos();
    $conexion = $bd->conectar();

    function eliminarLinea($idLinea) {
        global $bd;
        $bd->eliminar("delete from cesta_lineas where cesta_lineas.idcesta_lineas = $idLinea");
    }

    if (isset($_POST['eliminarLineaId'])) {
        eliminarLinea($_POST['eliminarLineaId']);
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
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
                    <a href=<?php echo "producto.php?idTipo=" . $tipoProd['idTipo_producto'];?>><?php echo $tipoProd['DescTipoProd'];?></a>
                </div>
            <?php }?>
        </div>

        <div class="content">
            <h1>CESTA</h1><br>
            <table class="tablaProductos">
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Descuento</th>
                    <th>Cantidad</th>
                    <th>Importe</th>
                    <th>Eliminar</th>
                </tr>
                
                <?php 
                    $resCestaLineas = $bd->seleccionar("select * from cesta_lineas where cesta_lineas.idcesta = 1");
                    while ($cestaLineas = $resCestaLineas->fetch_assoc()) {
                        $resProducto = $bd->seleccionar("select * from producto where producto.idProducto = " . $cestaLineas['idproducto']);
                        $producto = $resProducto->fetch_assoc();
                ?>
                    <tr>
                        <form method="POST" action=<?php echo $_SERVER['PHP_SELF'];?>>
                            <td><?php echo $producto['ProductoNombre'];?></td>
                            <td><?php echo $producto['pvpUnidad'];?></td>
                            <td><?php echo $producto['Descuento'];?></td>
                            <td><?php echo $cestaLineas['cantidad'];?></td>
                            <td><?php echo ($producto['pvpUnidad'] - $producto['Descuento']) * $cestaLineas['cantidad'];?></td>
                            <input type="hidden" name="eliminarLineaId" value=<?php echo $cestaLineas['idcesta_lineas'];?>>
                            <td><input type="submit" value="Eliminar"></td>
                        </form>
                    </tr>
                <?php }?>
            </table>
        </div>
    </body>
</html>
