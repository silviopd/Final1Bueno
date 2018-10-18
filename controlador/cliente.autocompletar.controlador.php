<?php

require_once '../negocio/Cliente.clase.php';

$obj = new Cliente();

$valorBusqueda = $_GET["term"];

$resultado = $obj->cargarDatosCliente($valorBusqueda);

$datos = array();

for ($i = 0; $i < count($resultado); $i++) {
    $registro = array
            (
                "label" => $resultado[$i]["nombre_completo"],
                "value" => array
                            (
                                "nombre" => $resultado[$i]["nombre_completo"],
                                "direccion" => $resultado[$i]["direccion"],
                                "telefono" => $resultado[$i]["telefono"]
                            )
            );
    
    $datos[$i] = $registro;
}

echo json_encode($datos);

