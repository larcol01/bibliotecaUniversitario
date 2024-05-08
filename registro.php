<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
          <title>Registro</title>
    </head>
    <body>
        
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                text-align: center;
            }
            form {
                margin: 20px auto;
                width: 300px;
                background-color: #fff;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h1 {
                margin-top: 0;
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
            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="tel"],
            input[type="submit"],
            input[type="button"] {
                width: calc(100% - 20px);
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }
            input[type="submit"] {
                background-color: rgb(55, 58, 162);
                color: white;
                border: none;
                cursor: pointer;
            }
            form input[type="submit"]:hover {
            background-color: #801cbe;
            }
            input[type="button"] {
                padding: 10px 20px;
                background-color: #801cbe;
                color: white;
                border: none;
                border-radius: 4px;
                cursor: pointer;
            }
            input[type="button"]:hover {
                background-color: rgb(55, 58, 162)
            }
        </style>
       
        <?php
         /* Inlcuimos la conexion a la BD */
        include 'conexion.php';

        // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
        $conexion =  getConnexion();
        //aqui comprueba si se ha pulsado el boton enviar para enviar el formulario
        //si se le ha pulsado entra en el if
       if (isset($_POST['enviar'])) 
           {
                // aqui usando isset( $_REQUEST) se verifican que los campos que se solicitan no estan vacios
                //  si hay algun campo se encuentra vacio no entra en if 
           //si todos los campos se encuentran rellenado entra en el if
                if(isset($_REQUEST['nombre']) && isset($_REQUEST['apellido1']) && isset($_REQUEST['apellido2']) 
                    && isset($_REQUEST['contrasena']) && isset($_REQUEST['email']) && isset($_REQUEST['telefono']) 
                    && isset($_REQUEST['dni'])) {
                    
                    //despues de comprobar si los campos estan todos rellenados y luego de entrar en el if 
                    //la informacion de los campos que se han rellendo antes se guardan en variables para luego ser introducido en la base de datos
                 
                    $nombre = mysqli_real_escape_string($conexion, $_REQUEST['nombre']);
                    $apellido1 = mysqli_real_escape_string($conexion, $_REQUEST['apellido1']);
                    $apellido2 = mysqli_real_escape_string($conexion, $_REQUEST['apellido2']);
                    $contrasena = mysqli_real_escape_string($conexion, $_REQUEST['contrasena']);
                    $email = mysqli_real_escape_string($conexion, $_REQUEST['email']);
                    $telefono = mysqli_real_escape_string($conexion, $_REQUEST['telefono']);
                    $dni = mysqli_real_escape_string($conexion, $_REQUEST['dni']);

                    //aqui despues de guar la informacion en las variables se mete la informacion en la base de datos
                    
                    $sql = "INSERT INTO usuario(nombre, apellido1, apellido2, nombre_usuario, contrasena, email, telefono, dni) 
                            VALUES ('$nombre', '$apellido1', '$apellido2', '$nombre', '$contrasena', '$email', '$telefono', '$dni')";
                    
                    //aqui comprobamos si la consulta que hemos hecho antes se ha hecho bien y si es asi sale un mensaje diciendo que el usuario se ha creado
                    
                    if (mysqli_query($conexion, $sql)) {
                        echo "Se ha creado el usuario";
                    } else //aqui si la consulta no se ha hecho bien le saldra un mensaje con un error
                        {
                        echo "Error al insertar datos: " . mysqli_error($conexion);
                    }

                    // aqui cerramos la conexion a la base de datos
                    mysqli_close($conexion);
                } else //aqui si falta algun dato le saldra un mensaje de que le faltan datos
                    {
                    echo "Por favor, complete todos los campos";
                }
            }


        ?>
        <form name="form" action="" method="POST" enctype="multipart/form-data">
            <h1>Registro</h1>
            <hr>
            <h3>Introducir datos:</h3>
            <br>
            
            Nombre:
            <input type="text" name="nombre" value="" />
            <br>
            <br>
            
            Apellido1:
            <input type="text" name="apellido1" value="" />
            <br>
            <br>
             Apellido2:
            <input type="text" name="apellido2" value="" />
            <br>
            <br>
            
            DNI/NIE:
            <input type="text" name="dni" pattern="[0-9]{8}[TRWAGMYFPDXBNJZSQVHLCKE]$" value=""/>
            <br>
            <br>
            
            Contraseña:
            <input type="password" name="contrasena" value=""/>
            <br>
            <br>
            
            Email:
            <input type="email" name="email" value=""/>
            <br>
            <br>
            
            Telefono:
            <input type="tel" id="telefono" name="telefono" pattern="[6789]\d{8}" placeholder="Ej. 612345678" required>
            <br>
            <br>
            
          
            
            <input type="submit" value="Registrar" name="enviar" /><br><br>
            <hr>
            <p>¿Ya te has registrado?</p>
            <a href="login.php"><input type="button" value="Volver a Login" name="cancelar" /></a>
            
            
        </form>
    </body>
</html>
