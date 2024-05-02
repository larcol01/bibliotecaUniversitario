<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
       <?php
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'invitado') {
            ?>

            <h1>Bienvenido Invitado</h1>
            <hr>
            <h2>Títulos Disponibles en Catálogo</h2>

            <?php
            /* Inlcuimos la conexion a la BD */
            include 'conexion.php';

            // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
             $conexion = getConn();

            $consultaGeneral = "select * from libro;";
            $resultado = mysqli_query($conexion, $consultaGeneral)
                    or die("Fallo en la consulta");
            ?>
            <table>
                <tr>
                    <th>Titulo</th>
                    <th>Autor</th>
                    <th>Precio</th>
                    <th>Editorial</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>

                    <tr>
                        <td><?php echo $row['titulo'] ?></td>
                        <td><?php echo $row['autor'] ?></td>
                        <td><?php echo $row['precio'] ?> €</td>
                        <td><?php echo $row['editorial'] ?> </td>
                    </tr>


                <?php } ?>
                     </table><br>
            <hr>

            <br>
            <form action="previsualizacion.php" method="POST">
                <label for="solicitudes">¿Te gustaría comprar? Solicita el cambio</label><br>
                <input type="submit" name="solicitar" value="CAMBIAR ROL" />
            </form><br>


            <!-- Formulario con un boton para salir, al pulsarlo se redirige al login y se cierra la sesion(Gestionado en el login el cierre de sesion) -->
            <hr>
            <form name="form" action="login.php" method="POST">

                <input type="submit" name="salir" value="Salir" />

            </form><br>


            <?php
            /* Recojemos el id del usuario de la variable de sesion */
            $id_usuario = $_SESSION['id_usuario'];

            /* Si el usuario invitado pulsa solicitar, entra en el if y se realiza un insert en la tabla de solicitudes, donde quedara 
              su peticion de cambio de rol registrada con el estado en pendiente para que despues el vendedor efectue el cambio a comprador */
            if (isset($_POST['solicitar'])) {
                // Verificar si ya existe una solicitud para el usuario actual
                $consulta_existente = "SELECT * FROM solicitudes WHERE id_usuario = $id_usuario";
                $resultado_existente = mysqli_query($conexion, $consulta_existente);

                if (mysqli_num_rows($resultado_existente) == 0) {
                    // No hay solicitud existente, procede a insertar una nueva solicitud


                    $consulta = "INSERT INTO solicitudes (id_usuario) VALUES ($id_usuario);";

                    $consulta = mysqli_query($conexion, $consulta)
                            or die("Fallo en la consulta");
                } else {
                    // Ya hay una solicitud existente para el usuario
                    echo "Ya ha enviado una solicitud previamente. Espere a que el administrador cambie su rol.";
                }
            }
        } else {
            session_destroy();
            header("Location: login.php");
            exit;
        }
        ?>
    </body>
</html>
