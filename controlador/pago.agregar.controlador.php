<?php

session_name("sistemacomercial1");
session_start();

require_once '../negocio/pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_datosFormulario"]) ){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$datosFormulario = $_POST["p_datosFormulario"];

//Convertir todos los datos que llegan concatenados a un array
parse_str($datosFormulario, $datosFormularioArray);
//
//
//echo '<pre>';
//print_r($datosFormularioArray);
//echo '</pre>';

try {
    $objPrestamo = new pago();
    $objPrestamo->setFecha_pago($datosFormularioArray["txtfec"]);
    
    //$objPrestamo->setNumero_pago($datosFormularioArray["cboCuota"]);
    $objPrestamo->setNumero_prestamo($datosFormularioArray["cboCredito"]);
    $objPrestamo->setNumero_cuota($datosFormularioArray["cboCuota"]);
    $objPrestamo->setTotal($datosFormularioArray["txtImporte"]);
    
    $resultado = $objPrestamo->agregar();
    
    if ($resultado == true){
        Funciones::imprimeJSON(200, "La venta ha sido registrada correctamente", "");
    }
    
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}
