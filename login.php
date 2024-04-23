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
        <h1>Login</h1>
        <hr>
        <form name="form" action="" method="POST" enctype="multipart/form-data">
                Nombre socio:
            <input type="text" name="usuario" value=""/> 
            <br>
            <br>
                Numero socio:
            <input type="text" name="numero" value=""/> 
            <br>
            <br>
            
                Contraseña:
            <input type="password" name="contrasena" value="" />
            <br>
            <br>
            <input type="submit" value="Enviar" name="enviar"/>
            
            <br>
            <br>
            <hr>
            <p>¿No tienes cuenta?</p>
            <a href="registro.php"><input type="button" value="Registro" name="registro" /></a>
 
        </form>
        <?php
        /*Aqui incluyo la conexion a la base de datos que esta creado en otro php separado */
        include './conexion.php';
        /*Aqui se obtiene la conexion de la base de datos utilizando la funcion getConexion() que he creado en otro php diferente*/
        $conexion  = getConnexion();
        
        
        
        ?>
    </body>
</html>
