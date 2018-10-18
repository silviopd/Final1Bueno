<?php

 require_once '../negocio/credito.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
	$obj = new credito();
        $nombres = $_POST["p_nombre"];
        $resultado = $obj->cargarRecibo($nombres);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
