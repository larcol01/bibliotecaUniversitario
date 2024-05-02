<!DOCTYPE html>
<?php
/* inicio sesion */
session_start();
?>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Menu_invitado</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
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
            .cursor{
                cursor: url('./libro.png'), auto;
            }
            th,td {
                text-align: center;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;

            }
        </style>
    </head>
    <body>
       <?php
        if (isset($_SESSION['usuario']) && isset($_SESSION['tipo_rol']) == 'invitado') {
            ?>

            <h1>Bienvenido Invitado</h1>
            <hr>
            <h2>Títulos Disponibles en Catálogo</h2>

            <?php
     /* Inlcuimos la conexion a la BD */
        include 'conexion.php';

        // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
        $conexion =  getConnexion();


            //$consultaGeneral = "select * from libros;";
            $resultado = mysqli_query($conexion, "select * from libros;")
                    or die("Fallo en la consulta");
            ?>
            <table>
                <tr>
                    <th>ISBN</th>
                    <th>Titulo</th>
                    <th>Idioma</th>
                    <th>Autor</th>
                    <th>Nº Ejemplares</th>
                    <th>Estado</th>
                    <th>Año</th>
                    <th>Tema</th>
                    <th>Editorial</th>
                </tr>

                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>

                    <tr>
                        <td><?php echo $row['isbn'] ?></td>
                        <td><?php echo $row['titulo'] ?></td>
                        <td><?php echo $row['idioma'] ?></td>
                        <td><?php echo $row['nombre_autor'] ?></td>
                        <td><?php echo $row['num_ejemplares'] ?></td>
                        <td><?php echo $row['estado'] ?> </td>
                        <td><?php echo $row['año'] ?></td>
                        <td><?php echo $row['tema'] ?></td>
                        <td><?php echo $row['nombre_editorial'] ?> </td>
                    </tr>


                <?php } 
                ?>
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
