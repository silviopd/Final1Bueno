<?php

 require_once '../negocio/cuota.clase.php';
    require_once '../util/funciones/Funciones.clase.php';

    try {
        $prestamo = $_POST["p_numero_prestamo"];
	$obj = new cuota();
        
        $resultado = $obj->cargarCuotas($prestamo);
	Funciones::imprimeJSON(200, "", $resultado);
	
    } catch (Exception $exc) {
	Funciones::imprimeJSON(500, $exc->getMessage(), "");
	
    }
