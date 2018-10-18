
function cargarComboCrédito(p_nombreCombo, p_tipo, p_nombre){
    $.post
    (
	"../controlador/prestamo.cargar.combo.controlador.php",
    {
        p_nombre :p_nombre
    }
    ).done(function(resultado){
	var datosJSON = $.parseJSON( JSON.stringify(resultado) );
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione un Crédito</option>';
            }else{
                html += '<option value="0">Todos los Créditos</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.numero_prestamo+'">'+item.descripcion_credito+'</option>';
            });
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
    
    
   
}

function cargarComboCuota(p_nombreCombo, p_tipo, p_numero_prestamo){
    $.post
    (
	"../controlador/cuota.cargar.combo.controlador.php",
        {
            p_numero_prestamo :p_numero_prestamo
        }
    ).done(function(resultado){
	var datosJSON = resultado;
	
        if (datosJSON.estado===200){
            var html = "";
            if (p_tipo==="seleccione"){
                html += '<option value="">Seleccione una Cuota</option>';
            }else{
                html += '<option value="0">Todas las Cuotas</option>';
            }

            $.each(datosJSON.datos, function(i,item) {
                html += '<option value="'+item.numero_cuota+'">'+item.descripcion_cuota+'</option>';
            });
            
            $(p_nombreCombo).html(html);
	}else{
            swal("Mensaje del sistema", resultado , "warning");
        }
    }).fail(function(error){
	var datosJSON = $.parseJSON( error.responseText );
	swal("Error", datosJSON.mensaje , "error");
    });
}