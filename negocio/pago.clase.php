<?php

require_once '../datos/Conexion.clase.php';

class pago extends Conexion{
             private $numero_pago;
             private $numero_prestamo;
           
             private $fecha_pago;
             private $total;
             private $estado;
             private $numero_cuota;
             function getNumero_pago() {
                 return $this->numero_pago;
             }

             function getNumero_prestamo() {
                 return $this->numero_prestamo;
             }

             function getFecha_pago() {
                 return $this->fecha_pago;
             }

             function getTotal() {
                 return $this->total;
             }

             function getEstado() {
                 return $this->estado;
             }

             function getNumero_cuota() {
                 return $this->numero_cuota;
             }

             function setNumero_pago($numero_pago) {
                 $this->numero_pago = $numero_pago;
             }

             function setNumero_prestamo($numero_prestamo) {
                 $this->numero_prestamo = $numero_prestamo;
             }

             function setFecha_pago($fecha_pago) {
                 $this->fecha_pago = $fecha_pago;
             }

             function setTotal($total) {
                 $this->total = $total;
             }

             function setEstado($estado) {
                 $this->estado = $estado;
             }

             function setNumero_cuota($numero_cuota) {
                 $this->numero_cuota = $numero_cuota;
             }

                  
             
                          
             
    public function agregar() {
        $this->dblink->beginTransaction();
        try {
            $sql = "select * from f_generar_correlativo('pago') as nc";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->execute();
            $resultado = $sentencia->fetch();
            
            if ($sentencia->rowCount()){
                $nuevoNumeroPrestamo = $resultado["nc"];
                $this->setNumero_pago($nuevoNumeroPrestamo);
                $sql = "
                        INSERT INTO public.pago_prestamo
                                    (
                                            numero_pago, 
                                            fecha_pago, 
                                            total_pagado
                                    )
                        VALUES 
                                    (
                                            :p_numero_pago, 
                                            :p_fecha_pago, 
                                            :p_total_pagado
                                    );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_numero_pago", $this->getNumero_pago());
                $sentencia->bindParam(":p_fecha_pago", $this->getFecha_pago());
                $sentencia->bindParam(":p_total_pagado", $this->getTotal());
                
                //Ejecutar la sentencia preparada
                $sentencia->execute();

                $sql = "
                    INSERT INTO public.pago_prestamo_cuota(
                        numero_pago, 
                        numero_prestamo, 
                        numero_cuota,
                        importe_pagado) 
                        VALUES (
                        :p_numero_pago, 
                        :p_numero_prestamo, 
                        :p_numero_cuota,
                        :p_importe_pagado
                        );
                    ";
                
                //Preparar la sentencia
                $sentencia = $this->dblink->prepare($sql);
                
                //Asignar un valor a cada parametro
                $sentencia->bindParam(":p_numero_pago", $this->getNumero_pago());
                $sentencia->bindParam(":p_numero_prestamo", $this->getNumero_prestamo());
                $sentencia->bindParam(":p_numero_cuota", $this->getNumero_cuota());
                $sentencia->bindParam(":p_importe_pagado", $this->getTotal());
                
                $sentencia->execute();
                
                 $sql="
                    update prestamo_cuota
                        set saldo_cuota = saldo_cuota - :p_importe_pagado
                     where  numero_cuota = :p_numero_cuota
                    ";
                
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_importe_pagado", $this->getTotal());
                $sentencia->bindParam(":p_numero_cuota", $this->getNumero_infraccion());
                $sentencia->execute();
                
                //Actualizar el correlativo en +1
                $sql = "update correlativo set numero = numero + 1 where tabla = 'pago'";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->execute();
                
                //Terminar la transacción
                $this->dblink->commit();
                
                return true;
                
                }
            
            
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
        
        return false;
        
    }         
             
    
    public function listar($fecha1, $fecha2, $tipo){
        try {
            $sql = "select * from f_listado_pagos(:p_fecha1,:p_fecha2, :p_tipo)";
            $sentencia = $this->dblink->prepare($sql);
            
            $sentencia->bindParam(":p_fecha1", $fecha1);
            $sentencia->bindParam(":p_fecha2", $fecha2);
            $sentencia->bindParam(":p_tipo", $tipo);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            return $resultado;
        } catch (Exception $ex) {
            
        }
    }
    
    public function anular($numeroPago) {
        $this->dblink->beginTransaction();
        try {
            //ACTUALIZAR EL ESTADO CON LA LETRA A
            $sql = "update pago_prestamo set estado = 'A' where numero_pago = :p_numero_pago";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_pago", $numeroPago);
            $sentencia->execute();
            
            $sql = "select numero_cuota , importe_pagado from pago_prestamo_cuota
                     where numero_pago = :p_numero_pago";
            $sentencia = $this->dblink->prepare($sql);
            $sentencia->bindParam(":p_numero_pago", $numeroPago);
            $sentencia->execute();
            
            $resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            
            for ($i = 0; $i < count($resultado); $i++) {
                $sql = "update prestamo_cuota 
                        set saldo_cuota = saldo_cuota + :p_importe_pagado
                        where numero_cuota = :p_numero_cuota";
                $sentencia = $this->dblink->prepare($sql);
                $sentencia->bindParam(":p_importe_pagado", $resultado[$i]["importe_pagado"]);
                $sentencia->bindParam(":p_numero_cuota", $resultado[$i]["numero_cuota"]);
                
                $sentencia->execute();
            } 
            
            //Terminar la transacción
            $this->dblink->commit();
            
            return true;
                    
        } catch (Exception $exc) {
            $this->dblink->rollBack(); //Extornar toda la transacción
            throw $exc;
        }
    }
}
