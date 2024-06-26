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
       
        
    </style>

    </head>
    <body>
       <?php
      
       //aqui se comprueba si los datos introducido en el login son de un usuario invitado y si esta en rol invitado entra
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol']) == 'invitado') {
            ?>

            <h1>Bienvenido Invitado</h1>
            <hr>
            
            <?php
     //aqui incluyo la base de datos que antes e hecho la conexion en otra clase 
        include 'conexion.php';

        // Obtenemos la conexión utilizando la función getConn() ( que hemos definido en el php de conexion a la BD)
        $conexion =  getConnexion();


            //aqui hacemos la consulta a la base de datos para que saque todos lo libros que tiene la baase de datos
            $resultado = mysqli_query($conexion, "select * from libros;")
                    or die("Fallo en la consulta");
            ?>
            <!--aqui hagacemos la tabla -->
            <table>
                <caption>Libros</caption>
                    <thead>
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
                    </thead>
                <!--aqui hagacemos mientras que en la consulta que hemos hecho antes siga habiendo cosas se va a estar hejecutando asta que se acaben el contenido de la misma-->
                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    ?>
                    <tbody>
                        <tr> 
                            
                            <!--aqui se optiene cada parte de la consulta para hacer las columnas--> 
                            <!--con el bucle se va pasando la informacion que se ha sacado de la base de datos-->
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
                    </tbody>

                <?php } 
                ?>
            </table>
            <br>
            <hr>

            <br>
            


            <!-- Formulario con un boton para salir, al pulsarlo se redirige al login y se cierra la sesion(Gestionado en el login el cierre de sesion) -->
            <hr>
             <form action="previsualizacion.php" method="POST">
                <label for="solicitudes">¿Te gustaría comprar? Solicita el cambio</label><br>
                <input type="submit" name="solicitar" value="CAMBIAR ROL" class="boton"/>
            </form><br>


            <!-- Formulario con un boton para salir, al pulsarlo se redirige al login y se cierra la sesion(Gestionado en el login el cierre de sesion) -->
            <hr>
            <form name="form" action="login.php" method="POST">

                <input type="submit" name="salir" value="Salir"  class="boton_salir"/>

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
