<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

function imprimirCestaBorrar($cesta) {
    ?>


    <h2>Mi Cesta</h2>
    <form name="borrar" action="catalogo.php" method="POST">
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
            foreach ($cesta->getProductos() as $producto) {
               //aqui saca los libros que estan en la base de datos y se saca por pantalla
                echo "<tr><td> Isbn " . $producto -> getIsbn() . "</td>"; //name="borrado[' . $producto->getTitulo() . ']"
               echo "<td>Titulo "  . $producto -> getTitulo(). "</td>";
                echo "<td>Idioma "  . $producto -> getIdioma() . "</td>";
                echo "<td>NombreAutor "  . $producto -> getNombreAutor(). "</td>";
                echo "<td>Ano"  . $producto -> getAno(). "</td>";
                echo "<td>Tema "  . $producto -> getTema(). "</td>";
                echo "<td>NombreEditorial"  . $producto -> getNombreEditorial(). "</td>";
                echo "<td> Cantidad" . $producto->getCantidad() . "</td>";
                echo '<td class="checkbox"><input class="boton" type="checkbox"  name="borrado[' . $producto -> getTitulo() . ']" value="' . htmlspecialchars( $producto -> getTitulo()) . '"/></td></tr>';
            }

            //Lo pongo aqui o lo gestiono mas abajo
            /* Guardamos la cesta en la variable de sesion serializada */
            $_SESSION['cesta'] = $cesta->serialize();
            ?>
        </table>
        <br>
        <input class="boton" type="submit" value="Eliminar" name="eliminar"/>
    </form><br>

    <!-- Botón para ir a la página de zona de pago -->
    <form action="zonaPago.php" method="GET">

        <input class="boton_salir" type="submit" value="Ir a la zona de pago" />

    </form>

    <?php
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Catálogo de Compra</title>

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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        caption{
            font-size: 24px;
            font-weight: bold;
            padding: 10px;
            background-color: #f2f2f2;
            border-radius: 8px 8px 0 0;
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
        
       
        tr:hover {
            background-color: rgba(155, 12, 250, 0.13);
        }
        tbody tr td {
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

        .boton_salir{
            margin-bottom: 5%;
            background-color: #801cbe; 
            color: white; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 4px; 
            font-size: 16px; 
            cursor: pointer; 
            transition: background-color 0.3s, transform 0.2s; 
            box-shadow: 0 4px 6px rgb(55, 58, 162); 
        }
        .boton_salir:hover {
            background-color: rgb(55, 58, 162); 
            transform: translateY(-2px); 
        }
        .boton_salir:active{
            background-color: #801cbe; 
            transform: translateY(1px); 
            box-shadow: none; 
        }
        table tr td input[type="number"]{
            width: 60px;
        }
        </style>
    </head>
    <body>

        <h1>Catalogo de libros</h1>

        <?php
        /* inicio sesion */
        session_start();
        //aqui se mira que tipo rol es el usuario
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'alumno' ||  isset($_SESSION['rol']) == 'profesor' ||  isset($_SESSION['rol']) == 'doctorado') {

            /* Indicamos que haga referencia a usar la clase cesta y producto */
            require_once './Cesta.php';
            require_once './Producto.php';

            /* Si la cesta esta vacia entra en el if */
            if (!isset($_SESSION['cesta'])) {
                /* Se crea una cesta vacia y se guarda serializada en la variable de sesion */
                $nuevaCesta = new Cesta();
                $_SESSION['cesta'] = $nuevaCesta->serialize();
            }


             /* aqui incluyo la base de datos que antes e hecho la conexion en otra clase */
            include 'conexion.php';

            // Obtenemos la conexión utilizando la función getConn() ( que hemos definido en el php de conexion a la BD)
            $conexion =  getConnexion();
            $consulta = "select * from libros;";

            $consulta = mysqli_query($conexion, $consulta)
                    or die("Fallo en la consulta");

            /* Sacamos la fila */
            //$datosConsulta = mysqli_fetch_assoc($consulta);
            ?>


            <form name="enviar" action="catalogo.php" method="POST">
                <table>
                    <tr>
                        <th>Cantidad</th>
                        <th>ISBN</th>
                        <th>Titulo</th>
                        <th>Idioma</th>
                        <th>Autor</th>
                        <th>Año</th>
                        <th>Tema</th>
                        <th>Editorial</th>
                    </tr>

                    <?php
                    //aqui se saca el borrado de la cesta de libros que va a pedir prestados
                    while ($row = mysqli_fetch_assoc($consulta)) {
                              $isbns = $row['isbn'];
                              $titulos= $row['titulo'];
                              $idiomas = $row['idioma'];
                              $nombre_autores= $row ['nombre_autor'];
                              $ano = $row['año'];
                              $temas= $row['tema'];
                              $nombre_editoriales =  $row['nombre_editorial'];
                              
                              
                        ?>

                        <tr>
                            <td> 
                                <input type='number' name='cantidad[<?php echo $row['isbn'] . " | " . $row['titulo'] . " | " .$row['idioma'] . " | " .
                                        $row ['nombre_autor']." | "  . $row['año'] ." | "  . $row['tema'] ." | "  . $row['nombre_editorial'] ?>]' value='0' id= 'input'>
                                
                            </td>
                            <td><?php echo $row['isbn'] ?></td>
                            <td><?php echo $row['titulo'] ?></td>
                            <td><?php echo $row['idioma'] ?></td>
                            <td><?php echo $row['nombre_autor'] ?></td>
                            <td><?php echo $row['año'] ?></td>
                            <td><?php echo $row['tema'] ?> </td>
                            <td><?php echo $row['nombre_editorial'] ?> </td>
                        </tr>


                    <?php } ?>

                </table>

                <br>
                <input class="boton" type="submit" value="Añadir a la cesta" name="enviar" />

            </form>

            <br><hr><hr>
            <a href="menu.php">Volver al Menu</a>
            <hr><hr>

            <?php
            /* Si nos ha llegado las cantidades del libro que se quiere comprar entra en el if */
            if (isset($_POST['cantidad'])) {
                /* Recojo el array asociativo pasado por el formulario, donde la clave del mismo se compone del titulo y el precio del libto 
                  y el valor se corresponde a la cantidad de ese libro que ha selecionado el usuario */
                $cantidades = $_POST['cantidad'];

                /* Se crea una cesta vacia para obtener la cesta de la variable de sesion */
                $cesta = new Cesta();

                /* Guardamos la cesta en la variable de sesion serializada */
                $cesta->unserialize($_SESSION['cesta']);

                /* Recorremos con el foreach el array devuelto y extraemos las claves y sus valores */
                foreach ($cantidades as $clave => $cantidad) {
                    /* Si la cantidad del libro es mayor que cero entra en el if y... */
                    if ($cantidad > 0) {
                      
                        $isbnDelLibro = $isbns ;
                        $tituloDelLibro = $titulos ;
                        $idiomaDelLibro = $idiomas;
                        $nombreAutor = $nombre_autores;
                        $anoDelLibro = $ano;
                        $temaDelLibro = $temas;
                        $nombre_editorial = $nombre_editoriales;


                        /* Con esta solución lo que hariamos sería comprobar primero si en la cesta ya está
                         * guardado ese título, y si está lo que hará será modificar solo la cantidad */
                        $productoExistente = $cesta->buscarProductoPorTitulo($tituloDelLibro);
                        
                        /* Verificar si el producto ya existe en la cesta */
                        if ($productoExistente) {

                            // Si el producto ya existe, actualizar la cantidad
                            $productoExistente->setCantidad($productoExistente->getCantidad() + $cantidad);
                        } else {
                            
                            // Si el producto no existe, crear un nuevo producto y agregarlo a la cesta
                            $producto  = new Producto($isbnDelLibro,$tituloDelLibro,$idiomaDelLibro, $nombreAutor,$nombreAutor,$anoDelLibro, $temaDelLibro,$nombre_editorial,$cantidad);
                            $cesta->agregarProducto($producto);
                        }
                    }
                }
                imprimirCestaBorrar($cesta);
            }
            if (isset($_POST['borrado'])) {
                // Obtener los títulos de los productos marcados para eliminar
                $titulosMarcados = array_keys($_POST['borrado']);

                /* Se crea una cesta vacía para obtener la cesta de la variable de sesión */
                $cesta = new Cesta();

                /* Guardamos la cesta en la variable de sesión serializada */
                $cesta->unserialize($_SESSION['cesta']);
                // Recorrer la cesta para eliminar los productos marcados
                foreach ($cesta->getProductos() as $indice => $producto) {
                    $tituloProducto = $producto->getTitulo();
                    // Iterar sobre todos los elementos de $titulosMarcados
                    foreach ($titulosMarcados as $tituloMarcado) {
                        if ($tituloProducto == $tituloMarcado) {

                            // Eliminar el producto que coincide con el título
                            $cesta->eliminarProducto($indice);

                            // No es necesario seguir iterando, ya encontramos una coincidencia
                            break;
                        }
                    }
                }

                //Reindexamos indices de cesta para no dejar huecos despues del borrado
                $cesta->reindexar();
                // Actualizar la variable de sesión con la cesta modificada
                $_SESSION['cesta'] = $cesta->serialize();

                // Mostrar la cesta actualizada
                imprimirCestaBorrar($cesta);
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