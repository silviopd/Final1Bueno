<?php
require_once '../datos/Conexion.clase.php';

class credito extends Conexion{
    public function cargarRecibo($p_nombre){
        try {
            $sql = "

SELECT 	
                            numero_prestamo,
                    ('N.PRE:'|| ' '|| numero_prestamo || '| '|| 'FEC.PRE' ||' '||fecha_prestamo ||'|'|| 'IMPORTE:' ||' '|| importe ) as descripcion_credito
                      FROM prestamo, cliente 
                    WHERE lower(apellidos|| ', ' || nombres) like :p_nombre
                          and importe > '0'";
            $sentencia = $this->dblink->prepare($sql);
            $p_nombre = '%'.  strtolower($p_nombre).'%';
            $sentencia->bindParam(":p_nombre", $p_nombre);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
