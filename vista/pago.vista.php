<?php
    
    require_once '../util/funciones/definiciones.php';
    
    //date_default_timezone_set("America/Lima");
    
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo C_NOMBRE_SOFTWARE; ?></title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	
        <?php
	    include 'estilos.vista.php';
	?>
	
	<!-- AutoCompletar-->
	<link href="../util/jquery/jquery.ui.css" rel="stylesheet">

    </head>
    <body class="skin-green layout-top-nav">
        <!-- Site wrapper -->
        <div class="wrapper">

            <?php
                include 'cabecera.vista.php';
            ?>

	    <form id="frmgrabar">
		<div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1 class="text-bold text-black" style="font-size: 20px;">Registrar nueva Pago</h1>
                    <ol class="breadcrumb">
                        <button type="button" class="btn btn-danger btn-sm" id="btnregresar">Regresar</button>
			<button type="submit" class="btn btn-primary btn-sm">Registrar el pago</button>
                    </ol>
                </section>
		<small>
		    <section class="content">
                    <div class="box box-success">
                        <div class="box-body">
                      
                            
                            <div class="row">
                                <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Fecha de pago</label>
                                        <input type="date" class="form-control input-sm" id="txtfec" name="txtfec" required="" value="<?php echo date('Y-m-d'); ?>"/>
                                      </div>
                                  </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xs-6">
                                      <div class="form-group">
                                        <label>Apellidos y Nombres del Cliente</label>
                                        <input type="text" class="form-control input-sm" id="txtnumeroplaca" required="">
                                      </div>
                                  </div>
                                  </div>
                                
                                <div class="row">
                                   <div class="col-xs-4">
                                      <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control input-sm" readonly="" id="lblmarca"/>
                                      </div>
                                  </div>
                                  <div class="col-xs-4">
                                      <div class="form-group">
                                        <label>Teléfono</label>
                                        <input type="text" class="form-control input-sm" readonly="" id="lblmodelo"/>
                                      </div>
                                  </div>
                                   </div>
                      
                              
                          <!-- /row -->
                          </div>
                        </div>
                    </div>
                    
<!--                    <div class="col-xs-5">
                                      <div class="form-group">
                                        <label>Recibos que seran pagados</label>
                                      </div>
                                  </div>-->
                   
                          </div>
                    </div>
                    <div class="box box-success">
                          <div class="box-body">
                              
                              <div class="row">
                                  <div class="col-xs-8">
                                      <div class="form-group">
                                        <label>Seleccione Crédito</label>
                                        <select class="form-control input-sm" id="cboCredito" name="cboCredito" required="">
                                        </select>
                                      </div>
                                  </div>
                              </div>
                              
                              <div class="row">
                                  <div class="col-xs-8">
                                      <div class="form-group">
                                        <label>Seleccione Cuota</label>
                                        <select class="form-control input-sm" id="cboCuota" name="cboCuota" required="">
                                        </select>
                                      </div>
                                  </div>
                              </div>
   
                              <div class="row">
                                  <div class="col-xs-2">
                                      <div class="form-group">
                                        <label>Importe a pagar</label>
                                        <input type="text" class="form-control input-sm" id="txtImporte" name="txtImporte" required=""/>
                                      </div>
                                  </div>
                                  
                              </div>
                          </div>
                    </div>
                    
                </section>
		</small>
            </div>
	    </form>
        </div><!-- ./wrapper -->
	<?php
	    include 'scripts.vista.php';
	?>
	
	
	<!-- AutoCompletar -->
	<script src="../util/jquery/jquery.ui.autocomplete.js"></script>
	<script src="../util/jquery/jquery.ui.js"></script>
	<script src="js/pago.autocompletar.js" type="text/javascript"></script>
	
	<!--JS-->
        <script src="js/cargar-combos-pago.js" type="text/javascript"></script>
	<script src="js/pago.js" type="text/javascript"></script>
	<!--<script src="js/util.js"></script>-->
        

    </body>
</html>



