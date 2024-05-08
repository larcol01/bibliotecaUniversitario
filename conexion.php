<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getConnexion(){
    // Establece la conexión con la base de datos utilizando mysqli_connect()
    $conexion = mysqli_connect('localhost', 'root', '', "bibliotecauniversitaria");
    // Verifica si hay errores de conexión utilizando mysqli_connect_errno()
    if (mysqli_connect_errno()) {
        // Si hay un error, muestra un mensaje de error
        echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
    }
    // Establece el conjunto de caracteres de la conexión a utf8 para admitir caracteres especiales
    $conexion->set_charset('utf8');
     // Devuelve la conexión establecida
    return $conexion;
    //
}