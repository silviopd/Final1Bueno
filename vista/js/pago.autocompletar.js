$("#txtnumeroplaca").autocomplete({
    source: "../controlador/cliente.autocompletar.controlador.php",
    minLength: 3, //Filtrar desde que colocamos 3 o mas caracteres
    focus: f_enfocar_registro,
    select: f_seleccionar_registro
    
});

function f_enfocar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtnumeroplaca").val(registro.nombre);
    event.preventDefault();
}

function f_seleccionar_registro(event, ui){
    var registro = ui.item.value;
    $("#txtnumeroplaca").val(registro.nombre);
    $("#lblmarca").val(registro.direccion);
    $("#lblmodelo").val(registro.telefono);

    cargarComboCrédito("#cboCredito", "seleccione", registro.nombre);
   
    event.preventDefault();
}

$("#cboCredito").change(function(){    
    var numero_prestamo = $("#cboCredito").val();
    cargarComboCuota("#cboCuota", "seleccione", numero_prestamo);
    //cargarComboProvincia("#cboprovincia", "todos", codigoDepartamento);
});

