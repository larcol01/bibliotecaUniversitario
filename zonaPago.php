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
             body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                text-align: center;
            }
            h1 {
                margin-top: 50px;
            }
            table {

                margin: 20px auto;
                width: 800px;
                background-color: #fff;
                padding: 10px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }


            th, td {
                text-align: center;
                padding: 8px;
                border-bottom: 1px solid #ddd; 
            }
            th {
                background-color: #693f82;
                color: white;
            }
            tr:nth-child(even) {
                background-color: #9b0cfa21;
            }

            tr:hover {
                background-color: rgba(155, 12, 250, 0.13);
            }
             tr td {
                border-bottom-color: #801cbe; 
            }
            hr {
                margin-top: 20px; 
                border: 0;
                border-top: 1px solid #d9bbbb;
            }

            .boton{
                background-color: rgb(55, 58, 162); 
                color: white; 
                padding: 10px 20px; 
                border: none; 
                border-radius: 4px; 
                font-size: 16px; 
                cursor: pointer; 
                transition: background-color 0.3s, transform 0.2s; 
                box-shadow: 0 4px 6px #801cbe; 
            }
            .boton:hover {
                background-color: #801cbe; 
                transform: translateY(-2px); 
            }
            .boton:active{
                background-color: rgb(55, 58, 162); 
                transform: translateY(1px); 
                box-shadow: none; 
            }

        </style>

    </head>
    <body>
        <?php
        //aqui inicializo la sesion
        session_start();
        //aqui mira que tipo rol es el usuario
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'alumno' ||  isset($_SESSION['rol']) == 'profesor' ||  isset($_SESSION['rol']) == 'doctorado') {

            //aqui incluyo la base de datos que antes e hecho la conexion en otra clase 
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
                        

                    </tr>

                    <?php
                    foreach ($cesta->getProductos() as $datosProducto) {
                        //aqui saco la informacion y la saco por pantalla
                        echo "<br><br>";
                            echo "<tr><td> Isbn " . $datosProducto -> getIsbn() . "</td>"; //name="borrado[' . $producto->getTitulo() . ']"
                            echo "<td>Titulo "  . $datosProducto -> getTitulo(). "</td>";
                             echo "<td>Idioma "  . $datosProducto -> getIdioma() . "</td>";
                             echo "<td>NombreAutor "  . $datosProducto -> getNombreAutor(). "</td>";
                             echo "<td>Ano"  . $datosProducto -> getAno(). "</td>";
                             echo "<td>Tema "  . $datosProducto -> getTema(). "</td>";
                             echo "<td>NombreEditorial"  . $datosProducto -> getNombreEditorial(). "</td>";
                             echo "<td> Cantidad" . $datosProducto->getCantidad() . "</td>";
                        echo "</tr>";

                        /* Realizamos el suamtorio de cada producto */
                        $sumatorio = $sumatorio +  $datosProducto->getCantidad();
                    }

                    /* Introducidos en la parte del total el sumatorio final de lo que debe pagar el usuario */
                    echo "<tr>  <td colspan='3'>TOTAL:</td> <td class='total'> $sumatorio</td> </tr>";
                    ?>

                </table>


                <br>

                <input type="submit" name="enviar" value="Pedir" class="boton">
            </form>
        <br><br>

            <hr><hr>
            <a href="catalogo.php">Volver</a>
            <hr><hr>
            <?php
            if (isset($_REQUEST['enviar'])) {
                $sumatorio;

               
                //aqui se guarda en una variable el dia en el que se encuentra el usuario
                $dia_presente =  date("Y-m-d");
                //aqui se guarda en un variable el dia que tiene que devolver el libro
                $dia_devolucion = date("Y-m-d +3") ;
                
                /* Realizo el insert en la BBDD registrando asi que el usuario a realizado un pago acorde con un pedido */
                $consulta = "INSERT INTO prestamo (fecha_prestamo,fecha_devolucion,isbn,id_usuario) VALUES ('$dia_presente','$dia_devolucion','51151','$id_usuario');";
                $consulta = mysqli_query($conexion, $consulta)
                        or die("Fallo en la consulta");
                
                echo 'Se ha pedido correctamente';
                

                /* Elimino la variable de sesion cesta para evitar que sus productos sigan estando en su cesta incluso despues de haberlos comprado */
                unset($_SESSION['cesta']);

                /* Redirigimos a la página especificada, en este caso al menu  */
                 header("refresh:5;url=menu.php");
               // header("Location: menu.php");
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