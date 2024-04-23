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
        <body>
        
        <button>Prestamo</button>
        <br>
        <br>
        <button>Devolver</button>
        
        
        <?php
        // put your code here
         /* Iniciamos la sesion */
        session_start();

        /* Inlcuimos la conexion a la BD */
        include 'conexion.php';
        
        
        // Obtenemos la conexión utilizando la función getConn() (definida en el php de conexion a la BD)
        $conexion = getConn();
        
        $registros = mysqli_query($conexion, "select nombre_usuario,tipo_rol from usuario_rol") or
                die("Problemas en el select:" . mysqli_error($conexion));
        
        
        //menu de invitado
        if($registros == "invitado"){
            
            
        }
        
        //menu de alumno
        if($registros == "alumno"){
            
        }
        
        //menu de alumno doctorado
        if($registros == "doctorado"){
            
        }
        
        //menu de proferor
        if($registros == "profesor"){
            
        }
        //menu de administrador
        if($registros == "aministrador"){
            
        }
        
        
        
        ?>
    </body>
</html>
