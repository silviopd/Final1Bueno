<?php

require_once '../negocio/pago.clase.php';
require_once '../util/funciones/Funciones.clase.php';

if (! isset($_POST["p_numero_pago"])){
    Funciones::imprimeJSON(500, "Faltan parametros", "");
    exit();
}

$objPrestamo = new pago();

try {
    $numeroPago = $_POST["p_numero_pago"];
    $resultado = $objPrestamo->anular($numeroPago);
    if ($resultado == true){
        Funciones::imprimeJSON(200, "Venta anulada correctamente", "");
    }
} catch (Exception $exc) {
    Funciones::imprimeJSON(500, $exc->getMessage(), "");
}

