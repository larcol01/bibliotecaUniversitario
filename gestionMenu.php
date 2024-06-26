<html>
    <head>
        <meta charset="UTF-8">
        <title>Gestión</title>
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

            h2 {
                font-size: 20px;
                margin-top: 20px;
            }

            h3 {
                margin-top: 20px;
                font-size: 24px;
            }

            .libros {
                margin: 20px auto;
                width: 300px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            .usuarios, .pedidos {
                margin: 20px auto;
                width: 600px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .usuarios input[type="text"],
            .usuarios input[type="password"],
            .usuarios input[type="submit"],
            .libros input[type="text"],
            .libros input[type="password"],
            .libros input[type="submit"],
            .pedidos input[type="text"],
            .pedidos input[type="password"],
            .pedidos input[type="submit"]{
                margin-top: 10px;
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            
            .usuarios input[type="text"]:focus,
            .usuarios input[type="password"]:focus,
            .usuarios input[type="submit"]:focus,
            .libros input[type="text"]:focus,
            .libros input[type="password"]:focus,
            .libros input[type="submit"]:focus,
            .pedidos input[type="text"]:focus,
            .pedidos input[type="password"]:focus,
            .pedidos input[type="submit"]:focus{
                border-color: #801cbe; 
                box-shadow: 0 0 5px #801cbe; 
                outline: none;
            }
            
            
            
            
            .usuarios input[type="submit"],
            .libros input[type="submit"],
            .pedidos input[type="submit"]{
                background-color: rgb(55, 58, 162);
                color: white;
                border: none;
                cursor: pointer;
                transition: background-color 0.3s, transform 0.2s;
                box-shadow: 0 4px 6px #801cbe;
            }

            .usuarios input[type="submit"]:hover,
            .libros input[type="submit"]:hover,
            .pedidos input[type="submit"]:hover{
                background-color: #801cbe;
            }

            .hr {
                margin-top: 20px;
                border: 0;
                border-top: 1px solid #d9bbbb;
            }

        </style>
    </head>
    <body>

        <?php
        /* Iniciamos la sesion */
        session_start();
 /* aqui incluyo la base de datos que antes e hecho la conexion en otra clase */
        include 'conexion.php';

        // Obtenemos la conexión utilizando la función getConn() ( que hemos definido en el php de conexion a la BD)
        $conexion =  getConnexion();

        /* SI HAY UN USUARIO LOGEADO ENTRA */
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'administrador') {

            /* Si se ha enviado algo desde el menu entra en este if */
            if (isset($_REQUEST['enviar'])) {
                /* Guardo la opcion (el value de ese boton) seleccionada para a continuacion realizar la accion necesaria* */
                $_SESSION['opcionMenu'] = $_REQUEST['enviar'];
            }


            /* Este if evalua que se haya seleccionado algo en el menu, si es que si entra */
            if (isset($_SESSION['opcionMenu'])) {

//ROL ADMINISTRADOR
//OPCION VER SOLICITUDES
                /* Si el boton pulsado es ver solicitudes entra */
                if ($_SESSION['opcionMenu'] == 'VerSolicitudes') { 
                    echo "<h1>GESTION DE SOLICITUDES</h1><hr>";

                    /* Se compreba que se haya pulsado el boton de cambiar */
                    if (isset($_REQUEST['cambiar'])) {
                        /* Comprobamos que se haya selecionado algo en caso de que si entra en el if */
                        if (isset($_POST['opciones'])) {
                            /* Recojemos las opciones */
                            $opciones_seleccionadas = $_POST['opciones'];
                            $cambiarRol =$_POST['cambiarRol'];

                            /* Recorremos todas las opciones selecionadas */
                            foreach ($opciones_seleccionadas as $opcion) {
                                
                                    
                                
                               
                                // $opcion contiene el valor (ID) del checkbox seleccionado
                                /* Actualizamos con update el rol a comprador selecionado el id del usuario */

                                $consulta = " UPDATE usuario SET tipo_rol='alumno' WHERE id_usuario='$opcion';";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta cambiar rol");

                                /* Actualizamos tambien la propia tabla de solicitudes */
                                $consulta = " UPDATE solicitudes SET estado='confirmado' WHERE id_usuario='$opcion';";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta estado");

                                /* Obtenemos la fecha actual para introducicirla en la tabla solicitudes y que se registre la fecha del momento */
                                $fecha_actual = date("Y-m-d");

                                /* Introducimos la fecha del momento de confirmacion, utilizando como antes el id del usuario correspondiente */
                                /*$consulta = " UPDATE solicitudes SET fecha_aprobacion = '$fecha_actual' WHERE id_usuario = '$opcion'";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta fecha");*/
                            }
                        } else {
                            // Si no se seleccionaron opciones
                            echo "No se han seleccionado opciones.";
                        }
                    }

                    /* Realizamos un select para que el vendedor pueda ver todos los usuarios que han solicitado el cambio de rol */
                    $consulta = " select * from solicitudes WHERE estado='pendiente';";
                    $consulta = mysqli_query($conexion, $consulta)
                            or die("Fallo en la consulta");
                    ?>

                    <form class="usuarios" action="gestionMenu.php" method="POST">

                        <?php
                        /* Consulta si hay usuarios pendientes */
                        if (mysqli_num_rows($consulta) > 0) {
                            while ($row = mysqli_fetch_assoc($consulta)) {
                                /* Guardo en las variables cada dato de la tabla */
                                $id_solicitud = $row['id_solicitud'];
                                $nombre_opcion = $row['id_usuario'];
                                $estado = $row['estado'];
                                $fecha = $row['fecha_solicitud'];

                                /* Muestra el ID en el valor del checkbox y los demás campos como texto en una etiqueta <label> */
                                echo "<input type='checkbox' name='opciones[]' value='$nombre_opcion'> 
                                <label>ID solicitud: $id_solicitud, ID usuario: $nombre_opcion, Estado: $estado, Fecha: $fecha</label> <br>";
                            }
                        } else {
                            /* Mensaje de que no hay ningun registro que sea acorde a la consulta */
                            echo "No hay opciones disponibles.";
                        }
                        ?>

                        <br><br>
                        <input type="submit" value="cambiar" name="cambiar" />

                    </form>
                    <?php
                }
//ROL ADMINISTRADOR
//OPCION CAMBIAR EL ESTADO DE COMO ESTA LOS LIBROS ES DECIR SI ESTAN DISPONIBLES O ESTAN prestados
                /* Si el boton pulsado es ver solicitudes entra */
                if ($_SESSION['opcionMenu'] == 'LibrosPrestados') { 
                    echo "<h1>GESTION DE LIBROS PRESTADOS</h1><hr>";

                    /* Se compreba que se haya pulsado el boton de cambiar */
                    if (isset($_REQUEST['cambiar'])) {
                        /* Comprobamos que se haya selecionado algo en caso de que si entra en el if */
                        if (isset($_POST['opciones'])) {
                            /* Recojemos las opciones */
                            $opciones_seleccionadas = $_POST['opciones'];
                            
                            /* Recorremos todas las opciones selecionadas */
                            foreach ($opciones_seleccionadas as $opcion) {
                                
                                    
                                
                               
                                // $opcion contiene el valor (ID) del checkbox seleccionado
                                /* Actualizamos con update el rol a comprador selecionado el id del usuario */

                                $consulta = " UPDATE libros SET estado='disponible' WHERE estado='prestados';";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta cambiar rol");

                               
                            }
                        } else {
                            // Si no se seleccionaron opciones
                            echo "No se han seleccionado opciones.";
                        }
                    }

                    /* Realizamos un select para que el vendedor pueda ver todos los usuarios que han solicitado el cambio de rol */
                    $consulta = " select * from libros WHERE estado='prestados';";
                    $consulta = mysqli_query($conexion, $consulta)
                            or die("Fallo en la consulta");
                    ?>

                    <form class="usuarios" action="gestionMenu.php" method="POST">

                        <?php
                        /* Consulta si hay usuarios pendientes */
                        if (mysqli_num_rows($consulta) > 0) {
                            while ($row = mysqli_fetch_assoc($consulta)) {
                                /* Guardo en las variables cada dato de la tabla */
                                $isbn = $row['isbn'];
                                $titulo = $row['titulo'];
                                $idioma = $row['idioma'];
                                $nombre_autor = $row['nombre_autor'];
                                $num_ejemplares = $row['num_ejemplares'];
                                $año = $row['año'];
                                $estado = $row['estado'];
                                $tema = $row['tema'];
                                $nombre_editorial = $row['nombre_editorial'];

                                /* Muestra el ID en el valor del checkbox y los demás campos como texto en una etiqueta <label> */
                                echo "<input type='checkbox' name='opciones[]' value='$nombre_opcion'> 
                                <label>ISBN: $isbn, Titulo: $titulo, Idioma: $idioma, Nombre Autor: $nombre_autor, Numero Ejemplares: $num_ejemplares, Año: $año, 
                                         Estado: $estado, Tema: $tema, Nombre Editorial: $nombre_editorial</label> <br>";
                            }
                        } else {
                            /* Mensaje de que no hay ningun registro que sea acorde a la consulta */
                            echo "No hay opciones disponibles.";
                        }
                        ?>

                        <br><br>
                        <input type="submit" value="cambiar" name="cambiar" />

                    </form>
                    <?php
                }

//ROL ADMINISTRADOR Y AUTOR
//OPCION INSERTAR NUEVO LIBRO
//aqui se insertan lo nuevos libros que quiere meter el administrador

                if ($_SESSION['opcionMenu'] == 'InsertarLibro') {
                    echo "<h1>AÑADIR NUEVO TÍTULO</h1>";
                    /* Compruebo que se ha enviado el formulario */
                    if (isset($_REQUEST['insertar'])) {
                        /* Verifica que los datos se han recibido correctamente, si no es así se le indica al usuario */
                        if (isset($_REQUEST['isbn']) && isset($_REQUEST['titulo']) && isset($_REQUEST['idioma']) && isset($_REQUEST['autor']) && isset($_REQUEST['nEjemplares'])&& isset($_REQUEST['ano'])
                                && isset($_REQUEST['estado']) && isset($_REQUEST['tema']) && isset($_REQUEST['editorial'])) {
                            
                            
                            /*Se obtiene la información del título enviado y se guarda en una variable*/
                            $tituloAComprobar = $_REQUEST['titulo'];
                            /* Realizo una consulta buscando coincidencias con el titulo */
                            $consulta = "SELECT * FROM libros WHERE titulo = '" . $tituloAComprobar . "';";
                            $consulta = mysqli_query($conexion, $consulta)
                                    or die("Fallo en la consulta");
                            /* Si no hay coincidencias en la consulta procede a insertar el nuevo libro en la tabla
                             * Si por el contrario sí hay, informa al usuario con un mensaje */
                            if (mysqli_num_rows($consulta) == 0) {

                                $consulta = "INSERT INTO libros(isbn, titulo,idioma, nombre_autor, num_ejemplares, año, estado, tema, nombre_editorial) "
                                        . "VALUES ('" . $_REQUEST['isbn'] . "','" . $_REQUEST['titulo']. "','" . $_REQUEST['idioma'] . "', '" . $_REQUEST['autor'] . "','" . $_REQUEST['nEjemplares']
                                        . "','" . $_REQUEST['ano'] . "','" . $_REQUEST['estado']. "','" . $_REQUEST['tema'] . "','" . $_REQUEST['editorial'] . "')";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta");

                                print "Se ha registrado el nuevo libro con éxito";
                            } else {
                                print "Ya existe un libro con ese mismo título";
                            }
                        } else {
                            print 'No se ha podido registrar el nuevo libro. Revisa los datos.';
                        }
                    } else {
                        ?>
                        <form class="libros" action="gestionMenu.php" method="POST">
                            <hr>
                            <h3>Introduce los datos del libro</h3>
                            <br>
                            ISBN:
                            <br>
                            <input type="text" name="isbn" min="0" value="" required/>
                            <br><br>

                            Título:
                            <br>
                            <input type="text" name="titulo" value="" required/>
                            <br><br>
                            
                            Idioma:
                            <br>
                            <input type="text" name="idioma" value="" required/>
                            <br><br>
                            
                            Autor:
                            <br>
                            <input type="text" name="autor" value="" required/>
                            <br><br>

                            
                            Numero de ejemplares:
                            <br>
                            <input type="text" name="nEjemplares" value="" required/>
                            <br><br>
                            
                            Año:
                            <br>
                            <input type="text" name="ano" value="" required/>
                            <br><br>
                            
                            Estado:
                            <br>
                            <input type="text" name="estado" value="" required/>
                            <br><br>
                            
                            Tema:
                            <br>
                            <input type="text" name="tema" value="" required/>
                            <br><br>
                            Editorial:
                            <br>
                            <input type="text" name="editorial" value="" required/>
                            <br><br>

                           

                            <input type="submit" name="insertar" value="Insertar"> 
                        </form>

                        <?php
                    }
                }
               
//ROL ADMINISTRADO 
//OPCION ELIMINAR LIBRO
//aqui se eliminan los libros que ya estan registrados en la base de datos
                  if ($_SESSION['opcionMenu'] == 'EliminarLibros') {
                       echo "<h1>ELIMINAR TÍTULO</h1>";
                    /* Compruebo que se ha enviado el formulario */
                    if (isset($_REQUEST['eliminar'])) {
                        
                    
  
                        /* Verifica que los datos se han recibido correctamente, si no es así se le indica al usuario */
                        if (isset($_REQUEST['isbn']) && isset($_REQUEST['titulo']) && isset($_REQUEST['idioma']) && isset($_REQUEST['autor']) && isset($_REQUEST['nEjemplares'])&& isset($_REQUEST['ano'])
                                && isset($_REQUEST['estado']) && isset($_REQUEST['tema']) && isset($_REQUEST['editorial'])) {
                            
                            
                            /*Se obtiene la información del título enviado y se guarda en una variable*/
                            $tituloAComprobar = $_REQUEST['titulo'];
                            /* Realizo una consulta buscando coincidencias con el titulo */
                            $consulta = "SELECT * FROM libros WHERE titulo = '" . $tituloAComprobar . "';";
                            $consulta = mysqli_query($conexion, $consulta)
                                    or die("Fallo en la consulta buscar titulo");
                            /* Si no hay coincidencias en la consulta procede a insertar el nuevo libro en la tabla
                             * Si por el contrario sí hay, informa al usuario con un mensaje */
                            if (mysqli_num_rows($consulta) == 1) {

                                $consulta = "DELETE FROM libros WHERE isbn= '$_REQUEST[isbn]'";
                                        
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta eliminar");

                                print "Se ha eliminado el libro con éxito";
                            } else {
                                print "No se ha encontrado ningun libro con esa informacion";
                            }
                        } else {
                            print 'No se ha podido eliminar el libro. Revisa los datos.';
                        }
                    } else {
                        ?>
                        <form class="libros" action="gestionMenu.php" method="POST">
                            <hr>
                            <h3>Introduce los datos del libro</h3>
                            <br>
                            ISBN:
                            <br>
                            <input type="text" name="isbn" min="0" value="" required/>
                            <br><br>

                            Título:
                            <br>
                            <input type="text" name="titulo" value="" required/>
                            <br><br>
                            
                            Idioma:
                            <br>
                            <input type="text" name="idioma" value="" required/>
                            <br><br>
                            
                            Autor:
                            <br>
                            <input type="text" name="autor" value="" required/>
                            <br><br>

                            
                            Numero de ejemplares:
                            <br>
                            <input type="text" name="nEjemplares" value="" required/>
                            <br><br>
                            
                            Año:
                            <br>
                            <input type="text" name="ano" value="" required/>
                            <br><br>
                            
                            Estado:
                            <br>
                            <input type="text" name="estado" value="" required/>
                            <br><br>
                            
                            Tema:
                            <br>
                            <input type="text" name="tema" value="" required/>
                            <br><br>
                            Editorial:
                            <br>
                            <input type="text" name="editorial" value="" required/>
                            <br><br>

                           

                            <input type="submit" name="eliminar" value="Eliminar"> 
                        </form>

                        <?php
                    }
                      
                  }
                
                
                
//ROL TODOS LOS ROLES MENO ADMINISTRADOR
//OPCION PEDIR
                /* Si el boton que se pulsa en el menu es comprar (por parte del comprador), entra en el if */
                if ($_SESSION['opcionMenu'] == 'Pedir') {
                    /* Redirigimos a la página especificada, en este caso al catalogo */
                    header("Location: catalogo.php");
                    exit;
                }
//ROL TODOS LOS ROLES MENO ADMINISTRADOR

            }
            //OPCION CAMBIAR EL ESTADO DE COMO ESTA LOS LIBROS ES DECIR SI ESTAN DISPONIBLES O ESTAN prestados
                /* Si el boton pulsado es ver solicitudes entra */
                if ($_SESSION['opcionMenu'] == 'DevolverLibros') { 
                    echo "<h1>DEVOLVER LIBROS</h1><hr>";

                    /* Se compreba que se haya pulsado el boton de cambiar */
                    if (isset($_REQUEST['cambiar'])) {
                        /* Comprobamos que se haya selecionado algo en caso de que si entra en el if */
                        if (isset($_POST['opciones'])) {
                            /* Recojemos las opciones */
                            $opciones_seleccionadas = $_POST['opciones'];
                            
                            /* Recorremos todas las opciones selecionadas */
                            foreach ($opciones_seleccionadas as $opcion) {
                                
                               
                                
                               
                                // $opcion contiene el valor (ID) del checkbox seleccionado
                                /* Actualizamos con update el rol a comprador selecionado el id del usuario */

                                $consulta = "  select * from prestamo";
                                $consulta = mysqli_query($conexion, $consulta)
                                        or die("Fallo en la consulta cambiar rol");
                               
                               
                            }
                        } else {
                            // Si no se seleccionaron opciones
                            echo "No se han seleccionado opciones.";
                        }
                    }

                    /* Realizamos un select para que el vendedor pueda ver todos los usuarios que han solicitado el cambio de rol */
                    $consulta = "SELECT * FROM `prestamo`;";
                    $consulta = mysqli_query($conexion, $consulta)
                            or die("Fallo en la consulta");
                    ?>

                    <form class="usuarios" action="gestionMenu.php" method="POST">

                        <?php
                        /* Consulta si hay usuarios pendientes */
                        if (mysqli_num_rows($consulta) > 0) {
                            while ($row = mysqli_fetch_assoc($consulta)) {
                                /* Guardo en las variables cada dato de la tabla */
                                $id_prestamo = $row['id_prestamo'];
                                $fecha_prestamo = $row['fecha_prestamo'];
                                $fecha_devolucion = $row['fecha_devolucion'];
                                $isbn = $row['isbn'];
                                $id_usuario = $row['id_usuario'];
                                
                                /* Muestra el ID en el valor del checkbox y los demás campos como texto en una etiqueta <label> */
                                echo "<input type='checkbox' name='opciones[]' > 
                                <label>ISBN: $isbn, Id_prestamo: $id_prestamo, Fecha_prestamo: $fecha_prestamo, Fecha_devolucion: $fecha_devolucion, Id_usuario: $id_usuario </label><br> <br>";
                            }
                        } else {
                            /* Mensaje de que no hay ningun registro que sea acorde a la consulta */
                            echo "No hay opciones disponibles.";
                        }
                        ?>

                        <br><br>
                        <input type="submit" value="cambiar" name="cambiar" />

                    </form>
                    <?php
                }
            ?>
                    
                    

            <br><hr><hr>
            <a href="menu.php">Volver al Menu</a>
            <hr><hr>

            <?php
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