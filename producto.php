<?php
    include ("conexion.php");

    $bd = new BaseDatos();
    $conexion = $bd->conectar();
    $idTipo = (isset($_GET['idTipo']) ? $_GET['idTipo'] : $_POST['idTipo']);

    function eliminarLinea($idLinea) {
        global $bd;
        $bd->eliminar("delete from cesta_lineas where cesta_lineas.idcesta_lineas = $idLinea");
    }

    function aniadirLinea($idProducto, $cantidad) {
        global $bd;
        $bd->insertar("insert into cesta_lineas values (" . getNuevaIdLinea() . ", 1, $idProducto, $cantidad)");
    }

    function getNuevaIdLinea() {
        global $bd;

        $resNuevaId = $bd->seleccionar("select max(idcesta_lineas) from cesta_lineas");
        $nuevaId = $resNuevaId->fetch_assoc();

        return $nuevaId['max(idcesta_lineas)'] + 1;
    }

    function eliminarLineaPorProducto($idProducto) {
        global $bd;
        $bd->eliminar("delete from cesta_lineas where cesta_lineas.idproducto = $idProducto");
    }

    if (isset($_POST['eliminarLineaId'])) {
        eliminarLinea($_POST['eliminarLineaId']);

    } else if (isset($_POST['insertarProducto'])) {
        eliminarLineaPorProducto($_POST['insertarProducto']);
        aniadirLinea($_POST['insertarProducto'], $_POST['cantidad']);

    } else if (isset($_POST['eliminarProducto'])) {
        eliminarLineaPorProducto($_POST['eliminarProducto']);
    }
?>

<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
    </head>

    <body>
        <div class="header">
            <?php
                $resTipoProd = $bd->seleccionar("select * from tipo_producto where tipo_producto.idTipo_producto = $idTipo");
                $tipoProd = $resTipoProd->fetch_assoc();

                echo "<h1>PRODUCTOS - " . strToUpper($tipoProd['DescTipoProd']) . "</h1>";
            ?>
        </div>

        <div class="nav">
            <a class="botonNav">Familia</a>
            <a class="botonNav" href="index.php">Tipo</a>
            <a class="botonNav" href="fichaProductos.php">Producto</a>
            <a class="botonNav">Usuario</a>
        </div>

        <div class="content">
            <table class="tablaProductos">
                <tr>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Unidad</th>
                    <th>Descripci&oacute;n</th>
                    <th>PVP</th>
                    <th>Descuento</th>
                    <th>Cantidad</th>
                    <th>Añadir</th>
                    <th>Eliminar</th>
                </tr>
                <?php
                    $resProd = $bd->seleccionar("select * from producto where producto.idTipoProducto = $idTipo");
                    while ($prod = $resProd->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo $prod['ProductoNombre'];?></td>
                        <td><?php echo $prod['idTipoProducto'];?></td>
                        <td><?php echo $prod['Unidad'];?></td>
                        <td><?php echo $prod['Descripcion'];?></td>
                        <td><?php echo $prod['pvpUnidad'];?></td>
                        <td><?php echo $prod['Descuento'];?></td>
                        <form method="POST" action=<?php echo $_SERVER['PHP_SELF'];?>>
                            <td><input type="text" name="cantidad"></td>
                            <td><input type="submit" value="Añadir"></td>
                            <input type="hidden" name="insertarProducto" value="<?php echo $prod['idProducto'];?>">
                            <input type="hidden" name="idTipo" value=<?php echo $idTipo;?>>
                        </form>
                        <form method="POST" action=<?php echo $_SERVER['PHP_SELF'];?>>
                            <td><input type="submit" value="Eliminar"></td>
                            <input type="hidden" name="eliminarProducto" value=<?php echo $prod['idProducto'];?>>
                            <input type="hidden" name="idTipo" value=<?php echo $idTipo;?>>
                        </form>
                    </tr>
                <?php }?>
            </table>
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
                    $resCestaLineas = $bd->seleccionar(
                        "select * from cesta_lineas " .
                        "join producto " .
                            "where cesta_lineas.idcesta = 1 && " .
                                  "producto.idProducto = cesta_lineas.idproducto && " .
                                  "producto.idTipoProducto = $idTipo");
                    
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
                            <input type="hidden" name="idTipo" value=<?php echo $idTipo;?>>
                        </form>
                    </tr>
                <?php }?>
            </table>
        </div>
    </body>
</html>