<!DOCTYPE html>

<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        /* Verifico que hay un usuario guardado en la variable de sesion, lo cual me indica si se han logeado, si este es el caso entra en el if
          y se hace la comprobacion del rol para redirigir al usuario a su menu personalizado en funcion de este */
        if (isset($_SESSION['usuario']) && ((isset($_SESSION['rol']) == 'comprador') || isset($_SESSION['rol']) == 'vendedor')) {
            /* Guardamos en usuario_ingresado el usuario de la variable de session */
            $usuario_ingresado = $_SESSION['usuario'];

            /* Recogemos tambien su rol, necesario para saber que mostrar a cada uno */
            $rol = $_SESSION['rol'];

            /* Recojemos su nombre tambien, para mostrarle un mensaje personalizado */
            $nombreUsuario = $_SESSION['nombreUsuario'];

            /* Por ultimo recojemos su id de usuario */
            // $id_usuario = $_SESSION['id_usuario'];


           /* aqui incluyo la base de datos que antes e hecho la conexion en otra clase */
            include 'conexion.php';

            // Obtenemos la conexión utilizando la función getConn() ( que hemos definido en el php de conexion a la BD)
            $conexion =  getConnexion();
            ?> 

            <!-- Mensaje de bienvenida personalizado con el nombre del usuario -->
            <h1>Menú de Accesos</h1>
            <hr>
            <?php
            /* Mensaje de bienvenida en funcion del usuario que sea usando la variable de sesion */
            print "<h2>Bienvenido, usuario: " . $nombreUsuario . "</h2>";
            ?>
            <hr> 
            <h3>¿Qué quieres hacer?</h3>
            <!-- Formulario que alberga los diferentes botones que se mostraran en funcion del rol que posea el ususario-->
            <form name="form" action="gestionMenu.php" method="POST" enctype="multipart/form-data">


                <!-- En funcion del rol que tenga el usuario podra hacer diferentes cosas:
                -VENDEDOR: podra > *ver estado de las cestas, podra cambiar el estado del pedido a enviado y cambiar el rol al invitado
                -COMPRADOR: podra > comprar productos(poner y quitarlos de la cesta), cerrar pedido,ver estado de su compra(enviado...),ver historial de compras,¿pagar?
                -INVITADO: podra > SOLO VER PRODUCTOS Y SOLICITAR CAMBIO-->

                <!--A ESTE MENU SOLO PUEDEN LLEGAR EL COMPRADOR Y EL VENDEDOR, ya que al invitado se le redirige directamente a la unica pantalla que puede ver, en el mismo login -->

                <?php
                if ($rol == 'administrador') {
                    ?>
                    <label for="solicitudes">Comprueba las solicitudes de tus clientes</label><br><br>
                    <input type="submit" value="VerSolicitudes" name="enviar" /><br><br>

                    <label for="estados">Cambia los estados de los pedidos</label><br><br>
                    <input type="submit" value="CambiarEstados" name="enviar" /><br><br>

                    <label for="nuevosLibros">Añade nuevos títulos disponibles</label><br><br>
                    <input type="submit" value="InsertarLibro" name="enviar" /><br><br>



                    <?php
                }
                if ($rol == 'autor') {
                    ?>
                    <label for="solicitudes">Accede al catálogo y pedir</label><br><br>
                    <input type="submit" value="Pedir" name="enviar" /><br><br>

                    <label for="solicitudes">Devolver libros</label><br><br>
                    <input type="submit" value="DevolverLibros" name="enviar" /><br><br>

                    <?php
                }
                ?> 
                    <?php
                }
                if ($rol == 'alumno') {
                    ?>
                    <label for="solicitudes">Accede al catálogo y pedir</label><br><br>
                    <input type="submit" value="Pedir" name="enviar" /><br><br>

                    <label for="solicitudes">Devolver libros</label><br><br>
                    <input type="submit" value="DevolverLibros" name="enviar" /><br><br>

                    <?php
                
                ?>




            </form>
            <hr> 
            <!-- Formulario con un boton para salir comun a todos los usuarios, al pulsarlo se redirige al login y se cierra la sesion(Gestionado en el login el cierre de sesion) -->

            <form name="form" action="login.php" method="POST" enctype="multipart/form-data">
                <p>¿Ya terminaste?</p>
                <input type="submit" value="salir" name="salir" />

            </form>



            <?php
        } else {
            /* En caso de que no exista ningun usuario en la variable de sesion indica que nadie se ha logeado por lo tanto le prohibimos el acceso y le ofrecemos 
              volver al login para que se autentique correctamente para acceder */
            session_destroy();
            print "ACCESO NO PERMITIDO";
            ?>
            <br><a href="login.php">Volver al Login</a><br><br>

            <?php
        }
        ?>

    </body>
</html>
