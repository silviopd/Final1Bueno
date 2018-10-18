$("#btnagregar").click(function(){
    document.location.href = "pago.vista.php";
});

$("#btnfiltrar").click(function(){
    listar();
});

function listar(){
    var fecha1 = $("#txtfecha1").val();
    var fecha2 = $("#txtfecha2").val();
    var tipo   = $("#rbtipo:checked").val();
    
    $.post
    (
        "../controlador/pago.listado.controlador.php",
        {
            p_fecha1: fecha1,
            p_fecha2: fecha2,
            p_tipo: tipo
        }
    ).done(function(resultado){
        var datosJSON = resultado;
        
        if (datosJSON.estado===200){
            var html = "";

            html += '<small>';
            html += '<table id="tabla-listado" class="table table-bordered table-striped">';
            html += '<thead>';
            html += '<tr style="background-color: #ededed; height:25px;">';
            
            html += '<th style="text-align: center">OPCIONES</th>';
            html += '<th>N.PAGO</th>';
            html += '<th>N.PRESTAMO</th>';
            html += '<th>N.CUOTA</th>';
            html += '<th>FECHA PAGO</th>';
            html += '<th>CLIENTE</th>';
            html += '<th>PRODUCTO</th>';
            html += '<th>IMPORTE PRÉSTAMO</th>';
            html += '<th>IMPORTE PAGADO</th>';
            html += '<th>ESTADO</th>';
            
            html += '</tr>';
            html += '</thead>';
            html += '<tbody>';

            //Detalle
            $.each(datosJSON.datos, function(i,item) {
                if(item.estado === "ACTIVO"){
                    html += '<tr>';
                    html += '<td align="center">';
                    html += '<button type="button" class="btn btn-danger btn-xs" onclick="anular(' + item.nro_pago + ')"><i class="fa fa-close"></i></button>';
                    html += '</td>';   
                }else{
                    html += '<tr style="text-decoration:line-through; color:red">';
                    html += '<td align="center">';
                    html += '</td>'; 
                }
            
                html += '<td align="center">'+item.nro_pago+'</td>';
                html += '<td>'+item.nro_pres+'</td>';
                html += '<td>'+item.nro_cuota+'</td>';
                html += '<td>'+item.fe_pago+'</td>';
                html += '<td>'+item.cliente+'</td>';
                html += '<td>'+item.producto+'</td>';
                html += '<td>'+item.impor+'</td>';
                html += '<td>'+item.impor_pag+'</td>';
                html += '<td>'+item.estado+'</td>';
                html += '</tr>';
            });

            html += '</tbody>';
            html += '</table>';
            html += '</small>';
            
            $("#listado").html(html);
            
            $('#tabla-listado').dataTable({
                "aaSorting": [[1, "desc"]],
                "sScrollX": "100%",
                "sScrollXInner": "150%",
                "bScrollCollapse": true,
                "bPaginate": true,
            });
            
            
            
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
        
    }).fail(function(error){
        var datosJSON = $.parseJSON( error.responseText );
        swal("Error", datosJSON.mensaje , "error"); 
    });
    
}

$(document).ready(function(){
    listar(); 
});

function anular(numeroPago){
   swal({
            title: "Confirme",
            text: "¿Esta seguro de anular la venta seleccionada?",

            showCancelButton: true,
            confirmButtonColor: '#d93f1f',
            confirmButtonText: 'Si',
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: true,
            imageUrl: "../imagenes/eliminar.png"
	},
        function(isConfirm){ 

            if (isConfirm){ //el usuario hizo clic en el boton SI                 
    
                /*CAPTURAR TODOS LOS DATOS NECESARIOS PARA GRABAR EN EL VENTA_DETALLE*/
                
                $.post(
                    "../controlador/pago.anular.controlador.php",
                    {
                        p_numero_pago: numeroPago
                    }
                  ).done(function(resultado){                    
		      var datosJSON = resultado;

                      if (datosJSON.estado===200){
			  //swal("Exito", datosJSON.mensaje, "success");
                          //document.location.href = "venta.listado.vista.php";
                    
                            listar();
                            swal("Exito", datosJSON.mensaje , "success");
                          
                      }else{
                          swal("Mensaje del sistema", resultado , "warning");
                      }

                  }).fail(function(error){
			var datosJSON = $.parseJSON( error.responseText );
			swal("Error", datosJSON.mensaje , "error");
                  }) ;
                
            }
	});   

   
}
