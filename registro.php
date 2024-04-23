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
                background-color: #4CAF50;
                color: white;
                border: none;
                cursor: pointer;
            }
            input[type="submit"]:hover {
                background-color: #45a049;
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
       
        <?php
         /* Inlcuimos la conexion a la BD */
        include 'conexion.php';
//hola mundokdm
        // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
        $conexion =  getConnexion();
        //aqui cuando se le da al boton enviar entra
       if (isset($_POST['enviar'])) 
           {
                // Verificar que los campos necesarios no estén vacíos
                if(isset($_REQUEST['nombre']) && isset($_REQUEST['apellido1']) && isset($_REQUEST['apellido2']) 
                    && isset($_REQUEST['contrasena']) && isset($_REQUEST['email']) && isset($_REQUEST['telefono']) 
                    && isset($_REQUEST['dni'])) {

                    //Aqui se preparan los datos para hacer el insert
                    $nombre = mysqli_real_escape_string($conexion, $_REQUEST['nombre']);
                    $apellido1 = mysqli_real_escape_string($conexion, $_REQUEST['apellido1']);
                    $apellido2 = mysqli_real_escape_string($conexion, $_REQUEST['apellido2']);
                    $contrasena = mysqli_real_escape_string($conexion, $_REQUEST['contrasena']);
                    $email = mysqli_real_escape_string($conexion, $_REQUEST['email']);
                    $telefono = mysqli_real_escape_string($conexion, $_REQUEST['telefono']);
                    $dni = mysqli_real_escape_string($conexion, $_REQUEST['dni']);

                    // aqui ya se insertan los datos en la base de datos
                    $sql = "INSERT INTO usuario(nombre, apellido1, apellido2, nombre_usuario, contraseña, email, telefono, dni) 
                            VALUES ('$nombre', '$apellido1', '$apellido2', '$nombre', '$contrasena', '$email', '$telefono', '$dni')";

                    // aqui si la consulta se ha hecho correctamente saldra un mensaje de que se ha creado bien el usuario
                    if (mysqli_query($conexion, $sql)) {
                        echo "Se ha creado el usuario";
                    } else //aqui si no se a hecho bien la consulta saldra un error
                        {
                        echo "Error al insertar datos: " . mysqli_error($conexion);
                    }

                    // aqui cierro la conexion
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
