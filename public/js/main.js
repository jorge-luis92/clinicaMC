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
    $("#type").val(tipo);
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

  //  var respuesta = confirm("¿Está seguro de borrar el registro "+user_id+"?");
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

$(document).on("click", "#btngramos", function(){
  $("#cantidad_gram").val("");
  let id_pr = document.getElementById("tipo").value;
  $("#id_produc").val(id_pr);

    $(".modal-title").text("Inserte Cantidad");
    $('#gramosa').modal('show');

});

$(document).on("change", "#tipo", function(){
  $("#cantidad_gram").val("");
  let id_pr = document.getElementById("tipo").value;
  $("#id_produc").val(id_pr);

  $.ajax({
   //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      type: "get",
      url: "/quitar_act/"+id_pr,
      datatype: 'json',
     // data:  {id:id},
      success : function(respuesta) {
        const prueba = JSON.parse(respuesta);

        $(".modal-title").text(prueba.nombre);
        $('#gramosa').modal('show');
              },
      error : function(xhr, status) {
          alert('Disculpe, existió un problema');       },
      complete : function(xhr, status) {
               //   alert('Petición realizada');
      }
  });


});

$('#formGram').submit(function(e){
$('#gramosa').modal('hide');
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    id_delp = $.trim($('#id_produc').val());
    gram = $.trim($('#cantidad_gram').val());
    let id = $("#tipo").val();
    let sihay= revisarStock(id, gram);
});
     function revisarStock(id, gram) {
            let valor= id;
            let gramitos= gram;
         $.ajax({
                type: "get",
                url: "/revisarSt/"+valor,
                datatype: 'json',
                success : function(respuesta) {
                  const prueba = JSON.parse(respuesta);
                  let val = prueba.stock;
                   if (val > 0) {
                   $.ajax({
                    //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                       type: "get",
                       url: "/quitar_act/"+id,
                       datatype: 'json',
                       success : function(respuesta) {
                         const prueba = JSON.parse(respuesta);
                             let fila = `<tr>
                                <td scope="row">${prueba.id}</td>
                                <td scope="row">${prueba.nombre}</td>
                                  <td scope="row">$&nbsp;${prueba.precio}&nbsp;${prueba.unidad}</td>
                                                <td scope="row"><input value=${gramitos}> &nbsp; ${prueba.unidad_venta} </td>
                                  <td scope="row"><button id="dd" class="btn-danger"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-backspace-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"/>
                                  </svg>
                                  </button>
                                  </td>
                                        </tr>`;

                                            $("#productos_insertados").append(fila);

                       },
                       error : function(xhr, status) {
                           alert('Disculpe, existió un problema');       },
                       complete : function(xhr, status) {
                                //   alert('Petición realizada');
                       }
                   });
                 } else {

                   alert("Producto agotado");

                 }
                },
                error : function(xhr, status) {
                    alert('Disculpe, existió un problema');       },
                complete : function(xhr, status) {
                         //   alert('Petición realizada');

                }
            });

          }
          function printErrorMsg (msg) {
                 $(".print-error-msg").find("ul").html('');
                 $(".print-error-msg").css('display','block');
                 $.each( msg, function( key, value ) {
                     $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                 });
               }
});
