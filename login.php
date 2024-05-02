<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
   <head>
        <meta charset="UTF-8">
        <title>Login</title>
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
        form {
            margin: 20px auto;
            width: 300px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        form input[type="text"],
        form input[type="password"],
        form input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        form input[type="submit"]:hover {
            background-color: #45a049;
        }
        hr {
            margin-top: 20px;
            border: 0;
            border-top: 1px solid #d9bbbb;
        }
        p {
            margin-top: 20px;
        }
        a {
            text-decoration: none;
        }
        input[type="button"] {
            padding: 10px 20px;
            background-color: #008CBA;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="button"]:hover {
            background-color: #005f75;
        }
        </style>
    </head>
    <body>
       

        <form name="form" action="" method="POST" enctype="multipart/form-data">

            <h1>LOGIN</h1>
            <hr>
            <h3>Accede y encuentra lo que buscas</h3>

            Nombre usuario:
            <br><br>
            <input type="text" name="usuario" value="" />
            <br><br>

            Contraseña:
            <br><br>
            <input type="password" name="contrasena" value="" />
            <br><br>

            <input type="submit" value="Enviar" name="enviar" />
            <br>
            <hr>
            <p>¿No tienes una cuenta? Registrate aquí</p>
            <a href="registro.php"><input type="button" value="Registro" name="registro" /></a>
            
            
        </form>
        <?php
        
        //
        
        
        
        /* inicio sesion */
        session_start();

        /* Si el usuario pulsa el boton de salir en el menu se elimina el usuario de la variable de sesion y se destruye la session */
        if (isset($_REQUEST['salir']))
        {
            unset($_SESSION['usuario']);
            session_destroy();
            
        }

        // Verificar si el formulario  de logeo ha sido enviado
        if (isset($_POST['enviar']))
        {
            echo "1fsdl";
            // Recuperar los datos del formulario
            $usuario_ingresado = $_POST['usuario'];
            $contrasena_ingresada = $_POST['contrasena'];
            
           /*Aqui incluyo la conexion a la base de datos que esta creado en otro php separado */
       /* Inlcuimos la conexion a la BD */
        include 'conexion.php';

        // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
        $conexion =  getConnexion();


            /* Consulta SQL para verificar usuario y contraseña introducido */
            //$consulta = "SELECT id_usuario,nombre,tipo_rol FROM usuario WHERE nombre = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'";

            $consulta = mysqli_query($conexion,"SELECT id_usuario,nombre,tipo_rol FROM usuario WHERE nombre = '$usuario_ingresado' AND contrasena = '$contrasena_ingresada'")
                    or die("Fallo en la consulta");

            /* Sacamos la fila */
            $datosConsulta = mysqli_fetch_assoc($consulta);

 echo "2fsdl";
            // Verificar si la consulta devuelve true porque hay resultados y son mas de 0 filas
           
                    $num_filas = mysqli_num_rows($consulta);
            if ($num_filas > 0)
            {
                echo "3fsdl";
                /* Obtengo el rol (invitado,registrado....) de la consulta realizada */
                $_SESSION['rol'] = $datosConsulta['tipo_rol'];

                // Credenciales válidas, iniciar sesión
                $_SESSION['usuario'] = $usuario_ingresado;

                /* Guardo el nombre del usuario para mostrarle un mensaje de bienvenido */
                $_SESSION['nombreUsuario'] = $datosConsulta['nombre'];

                /* Guardo en variable de sesion el id del usuario para usarlo mas tarde */
                $_SESSION['id_usuario'] = $datosConsulta['id_usuario'];

                /* Si el usuario que se logea tiene como rol invitado, solo le redirigira a previsualizacion donde podra solo observar los productos */
                if ($_SESSION['rol'] == 'invitado')
                {
                    echo "4fsdl";
                    // Redireccionar de inmediato
                    
                    header('Location: previsualizacion.php');
                
                exit;
                    //header("Location: previsualizacion.php");echo "5fsdl";
                    
                }
                if($_SESSION['rol'] == 'alumno'){
                    /* En caso de que el rol del usuario sea comprador/vendedor accedera al menu normal */
                header('Location: menu.php');
                
                exit;
                }
                

                
            } else
            {
                // Credenciales inválidas, mostrar mensaje de error
                echo "Credenciales incorrectas. Por favor, inténtalo de nuevo.";
            }

            // Cerrar la conexión a la base de datos
            $conexion->close();
        }
        
        
        ?>
    </body>
</html>
