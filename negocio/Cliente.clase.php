<?php

require_once '../datos/Conexion.clase.php';

class Cliente extends Conexion {
    
    public function cargarDatosCliente($nombre) {
        try {
            $sql = "
		select 
			(apellidos|| ', ' || nombres) as nombre_completo, 
		    direccion, 
		    telefono
		from 
		    cliente 
		where 
		    lower(apellidos|| ', ' || nombres) like :p_nombre";
            $sentencia = $this->dblink->prepare($sql);
            $nombre = '%'.  strtolower($nombre).'%';
            $sentencia->bindParam(":p_nombre", $nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);

            return $resultado;
        } catch (Exception $exc) {
            throw $exc;
        }
            
    }
}
