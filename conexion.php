<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getConnexion(){
    $conexion = mysqli_connect('localhost', 'root', '', "bibliotecauniversitaria");
    if (mysqli_connect_errno()) {
        echo "Fallo al conectar a MySQL: " . mysqli_connect_error();
    }
    $conexion->set_charset('utf8');
    return $conexion;
    
}