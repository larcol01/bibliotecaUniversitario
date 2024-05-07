<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Zona de Pago</title>
        <style>
            * {
                font-family: Helvetica, Verdana, sans-serif;
                text-align: center;
            }
            
            input {
                border-radius: 4px;
            }
            
            input:hover {
                background-color: lightskyblue;
            }

            table{
                margin-left: auto;
                margin-right: auto;
                width: 80%;

            }
            tr
            {
                height: 40px
            }

            th {
                background-color: lightskyblue;
            }

            td {
                padding-left: 20px;
                text-align: left;
            }
            table, tr, td,th
            {
                border: 2px solid;
                border-collapse: collapse;

            }

            .checkbox {
                text-align: center;
            }

            .total {
                font-weight: bold;
                background-color: lime;
            }


        </style>

    </head>
    <body>
        <?php
        session_start();

        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'alumno' ||  isset($_SESSION['rol']) == 'profesor' ||  isset($_SESSION['rol']) == 'doctorado') {

           include 'conexion.php';

            // Obtenemos la conexión utilizando la función getConn() ( que hemos definido en el php de conexion a la BD)
            $conexion =  getConnexion();

            /* Indicamos que necesitamos que tenga en cuenta a las clases producto y cesta */
            require_once './Cesta.php';
            require_once './Producto.php';

            /* DE AQUI PARA ARRIBA LO VAMOS A BORRAR CUANDO EL ELIMINAR ESTE COMPLETAMENTE IMPLEMENTADO Y EL BOTON DE CONTINUAR */
            $cesta = new Cesta();
            $cesta->unserialize($_SESSION['cesta']);

            /* Creo una variable para guardar el sumatorio del precio */
            $sumatorio = 0;
            ?>

            <form name="factura" action="zonaPago.php" method="POST">
                <h1>Zona de pago</h1>
                <hr>
                <table>
                    <tr>
                        <th>ISBN</th>
                        <th>Título</th>
                        <th>Idioma</th>
                        <th>nombre Autor</th>
                        <th>Año</th>
                        <th>Tema</th>
                        <th>Nombre Editorial</th>

                        <th>Cantidad</th>
                        <th>Eliminar</th>

                    </tr>

                    <?php
                    foreach ($cesta->getProductos() as $datosProducto) {

                        echo "<br><br>";
                            echo "<tr><td> Isbn " . $producto -> getIsbn() . "</td>"; //name="borrado[' . $producto->getTitulo() . ']"
                            echo "<td>Titulo "  . $producto -> getTitulo(). "</td>";
                             echo "<td>Idioma "  . $producto -> getIdioma() . "</td>";
                             echo "<td>NombreAutor "  . $producto -> getNombreAutor(). "</td>";
                             echo "<td>Ano"  . $producto -> getAno(). "</td>";
                             echo "<td>Tema "  . $producto -> getTema(). "</td>";
                             echo "<td>NombreEditorial"  . $producto -> getNombreEditorial(). "</td>";
                             echo "<td> Cantidad" . $producto->getCantidad() . "</td>";
                        echo "</tr>";

                        /* Realizamos el suamtorio de cada producto */
                        $sumatorio = $sumatorio +  $datosProducto->getCantidad();
                    }

                    /* Introducidos en la parte del total el sumatorio final de lo que debe pagar el usuario */
                    echo "<tr>  <td colspan='3'>TOTAL:</td> <td class='total'> $sumatorio</td> </tr>";
                    ?>

                </table>


                <br>

                <input type="submit" name="enviar" value="Pedir">
            </form>
        <br><br>

            <hr><hr>
            <a href="catalogo.php">Volver</a>
            <hr><hr>
            <?php
            if (isset($_REQUEST['enviar'])) {
                $sumatorio;

                /* Obtengo el id del usuario que esta en la sesion */
                $id_usuario = $_SESSION['id_usuario'];


                /* Realizo el insert en la BBDD registrando asi que el usuario a realizado un pago acorde con un pedido */
                $consulta = "INSERT INTO prestamo (fecha_prestamo,fecha_devolucion,isbn,id_usuario) VALUES ('$id_usuario','$sumatorio');";
                $consulta = mysqli_query($conexion, $consulta)
                        or die("Fallo en la consulta");

                /* Realizar consulta select donde recojo el id maximos de pedido en la tabla pedido (esto indica el ultimo pedido que ha realizado, ) */

                $consulta = "SELECT MAX(id_pedido) as pedidoMaximo FROM `pedido` WHERE id_usuario=$id_usuario;";
                $consulta = mysqli_query($conexion, $consulta)
                        or die("Fallo en la consulta");


                /* Extraigo de lo devuelto por la consulta el id maximo para ver el ultimo pedido del usuario */
                $row = mysqli_fetch_assoc($consulta);
                $pedidoIDmax = $row['pedidoMaximo'];


                /* Tambien se ingresa los diferentes datos en la tabla detalle pedidos */
                foreach ($cesta->getProductos() as $valores) {
                    /* Obtenemos la cantidad y el titulo para pasarlo al insert */
                    $cantidad = $valores->getCantidad();
                    $tituloDelLibro = $valores->getTitulo();

                    $consulta = "INSERT INTO detallepedido (tituloLibro,id_pedido,cantidad) VALUES ('$tituloDelLibro','$pedidoIDmax','$cantidad');";
                    $consulta = mysqli_query($conexion, $consulta)
                            or die("Fallo en la consulta");
                }

                /* Elimino la variable de sesion cesta para evitar que sus productos sigan estando en su cesta incluso despues de haberlos comprado */
                unset($_SESSION['cesta']);

                /* Redirigimos a la página especificada, en este caso al menu  */
                header("Location: menu.php");
                exit;
            }
        } else {
            /* Si no hay nadie logeado se le indica que no tiene acceso permitido y se le proporciona un enlace de vuelta al login */
            session_destroy();
            print "ACCESO NO PERMITIDO";
            ?>

            <br><a href="login.php">Volver al Login</a><br><br>
            <?php
        }
        ?>

    </body>
</html>