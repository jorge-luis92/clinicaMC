$(document).ready(function() {
var user_id, opcion;

tablaUsuarios = $('#tablaUsuarios').DataTable({
        "bProcessing": true,
        "bDeferRender": true,
        "bServerSide": true,
        "sAjaxSource": "serverside/serversideUsuarios.php",
        "columnDefs": [ {
            "targets": -1,
            "defaultContent": "<div class='wrapper text-center'><div class='btn-group'><button class='btn btn-info btn-sm btnEditar' data-toggle='tooltip' title='Editar'><i class='material-icons'>edit</i></button><button class='btn btn-danger btn-sm btnBorrar' data-toggle='tooltip' title='Eliminar'><span class='material-icons'>delete</span></button></div></div>"
        } ],
});
let v= $(document).ready( function () {
 tablausers =$('#users').DataTable({
    processing: true,
    serverSide: true,
    "language": {
                     "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                 },
    ajax: '/datauserstables',
    columns: [
      {data: 'id',  visible: true},
      {data: 'name'},
    {data: 'email'},
    {data: 'type'},
    {defaultContent:
    '<button class="btn btn-info btn-sm btnEditar" data-toggle="tooltip" title="Editar">Editar</button>'
  }
      ]
  });
});
let fila; //captura la fila, para editar o eliminar
//submit para el Alta y Actualización
$('#formUsuarios').submit(function(e){

    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    let user_id = parseInt(fila.find('td:eq(0)').text());
    username = $.trim($('#username').val());
    first_name = $.trim($('#first_name').val());
    tipo = $.trim($('#types').val());
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: "POST",
          url: "/datosaeditar",
          datatype:"json",
          data:  {id:user_id, user:username, email:first_name, type:tipo},
          success: function(data) {
            tablausers.ajax.reload(null, false);
           }
        });
    $('#modalCRUD').modal('hide');
        alert("El dato se actualizó correctamente");
});

//para limpiar los campos antes de dar de Alta una Persona

$(document).on("click", ".btnNuevo", function(){

    $(".modal-title").text("Alta de Usuario");
    $('#modalNuevo').modal('show');

});

$(document).on("click", "#btngramoss", function(){

    $(".modal-title").text("Inserte Cantidad");
    $('#gramosa').modal('show');

});

$('#formNuevo').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let type = document.getElementById("tipo").value;
    let pass = document.getElementById("password").value;
    let pass2 = document.getElementById("password-confirm").value;
    $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      type: "POST",
      url: "/registro_users",
      datatype:"json",
      data:  {name:name, email:email, password:pass, type:type, password_confirmation:pass2 },
      success: function(data) {
        if($.isEmptyObject(data.error)){
            tablausers.ajax.reload(null, false);
                        alert(data.success);
                    }else{
                        alert(data.error);
                        printErrorMsg(data.error);
                    }
       }
    });

$('#modalNuevo').modal('hide');
  //  alert("Datos registrados correctamente");
});

//Editar
$(document).on("click", ".btnEditar", function(){
    fila = $(this).closest("tr");
   let user_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
    let username = fila.find('td:eq(1)').text();
    let first_name = fila.find('td:eq(2)').text();
    let tipo = fila.find('td:eq(3)').text();
    $("#username").val(username);
    $("#types").val(tipo);
    $(".modal-title").text("Editar Usuario");
    $('#modalCRUD').modal('show');

});


$('#users').on('click', 'input[type="button"]', function() {

    $(this).closest('tr').remove();

})
//Borrar

$(function () {
    $(document).on('click', '.btnBorrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
});

$(document).on("click", "#dd", function(){
let  jaja = $(this).closest("tr");
  let user_ids = parseInt(jaja.find('td:eq(0)').text());
  let respuesta = confirm("¿Está seguro de quitar el producto?");
    if (respuesta) {
              $(this).closest('tr').remove();
           }
 });

// $(document).on("click", "#agregar_productos", function(){
   //e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
  // let  fila = $(this).closest("tr");
   //let id = parseInt(fila.find('td:eq(0)').text());

  // let id = $("#tipo").val();

//let sihay= revisarStock(id);
//});



          function printErrorMsg (msg) {
                 $(".print-error-msg").find("ul").html('');
                 $(".print-error-msg").css('display','block');
                 $.each( msg, function( key, value ) {
                     $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                 });
               }
});
