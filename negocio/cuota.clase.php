<?php
require_once '../datos/Conexion.clase.php';

class cuota extends Conexion{
    public function cargarCuotas($numero_prestamo){
        try {
            $sql = "
                    	SELECT distinct	
                            pc.numero_prestamo,
			    ('N.CUOTA:'|| ' '|| numero_cuota || '| '|| 'FEC.VEN' ||' '||fecha_vencimiento_cuota ||'|'|| 'SALDO:' ||' '|| saldo_cuota ) as descripcion_cuota
                      FROM prestamo, prestamo_cuota as pc
                    WHERE pc.numero_prestamo = :p_numero_prestamo
                    

                          and importe > '0'
                ";
            
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_prestamo", $numero_prestamo);
            $sentencia->execute();
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            return $resultado;
            
        } catch (Exception $exc) {
            throw $exc;
        }
    }
}
