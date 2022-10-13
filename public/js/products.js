$(document).ready(function() {

let  tableproducts =$('#productos_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: '/dataproductstables',
   columns: [
     {data: 'id'},
     {data: 'nombre'},
     {data: 'tipo'},
     {data: 'precio'},
     {data: 'stock'},
     {data: 'action'},
     {defaultContent:
       '<button class="btn btn-info btn-sm btnAgregarS" data-toggle="tooltip" title="Editar">Agregar &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></button>'}
   ]
 });

$(document).on("click", ".btnEditarP", function(){
    fila = $(this).closest("tr");
   let prod_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
  $.ajax({
      type: "get",
      url: "/datospr/"+prod_id,
      datatype: 'json',
      success : function(respuesta) {
        const prueba = JSON.parse(respuesta);
        let id_pro= prueba.id;
          $("#nombrep").val(prueba.nombre);
          $("#tipop").val(prueba.tipo);
          $("#precio_mayp").val(prueba.precio_may);
          $("#preciop").val(prueba.precio);
          $("#unidadp").val(prueba.unidad);
          $("#unidad_ventap").val(prueba.unidad_venta);
            $('#modalprodedit').modal('show');
              },
      error : function(xhr, status) {
          alert('Disculpe, existió un problema');       },
      complete : function(xhr, status) {
               //   alert('Petición realizada');
      }
  });
});

$('#editpr').submit(function(e){

    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    let id_pro = parseInt(fila.find('td:eq(0)').text());

    nombrep = $.trim($('#nombrep').val());
    tipop = $.trim($('#tipop').val());
    precio_mayp = $.trim($('#precio_mayp').val());
    preciop = $.trim($('#preciop').val());
    unidadp = $.trim($('#unidadp').val());
    unidad_ventap = $.trim($('#unidad_ventap').val());
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: "POST",
          url: "/producto_edit",
          datatype:"json",
          data:  {id:id_pro, nombre:nombrep, tipo:tipop, precio_may:precio_mayp, precio:preciop, unidad:unidadp, unidad_venta:unidad_ventap},
          success: function(data) {
            tableproducts.ajax.reload(null, false);
           }
        });
    $('#modalprodedit').modal('hide');
        alert("Datos actualizados correctamente");
});

$(document).on("click", ".btnNuevoP", function(){

//    $(".modal-title").text("Alta de Usuario");
const valor ="";
document.getElementById("nombre").value=valor;
document.getElementById("tipo").value=valor;
document.getElementById("precio_may").value=valor;
document.getElementById("precio").value=valor;
document.getElementById("unidad").value=valor;
document.getElementById("unidad_venta").value=valor;
    $('#modalNuevoProd').modal('show');

});

$('#formProN').submit(function(e){
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página


    let nombre = document.getElementById("nombre").value;
    let tipo = document.getElementById("tipo").value;
    let precio_may = document.getElementById("precio_may").value;
    let precio = document.getElementById("precio").value;
    let unidad = document.getElementById("unidad").value;
    let unidad_venta = document.getElementById("unidad_venta").value;
    $.ajax({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      type: "POST",
      url: "/registro_producto",
      datatype:"json",
      data:  {nombre:nombre, tipo:tipo, precio_may:precio_may, precio:precio, unidad:unidad, unidad_venta:unidad_venta },
      success: function(data) {
        if($.isEmptyObject(data.error)){
            tableproducts.ajax.reload(null, false);
                        alert(data.success);
                    }else{
                        alert(data.error);
                        printErrorMsg(data.error);
                    }
       }
    });
$('#modalNuevoProd').modal('hide');
});


$(document).on("click", ".btnAgregarS", function(){
  $("#stock").val("");
    fila = $(this).closest("tr");
   let produto_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
   let nombre = fila.find('td:eq(1)').text();
   $("#id").val(produto_id);
   $("#recipient-name").val(nombre);
    $(".modal-title").text("Agregar a Stock");
    $('#modalStock').modal('show');

});

$('#postStock').submit(function(e){

    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

    let user_id = parseInt(fila.find('td:eq(0)').text());
    let id_p = $.trim($('#id').val());
    let first_name = $('#stock').val();
    console.log(first_name);
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: "POST",
          url: "/addstock",
          datatype:"json",
          data:  {id:id_p, stock:first_name},
           success: function(data) {
             if($.isEmptyObject(data.error)){
                 tableproducts.ajax.reload(null, false);
                             alert(data.success);
                         }else{
                             alert(data.error);

                         }
            }
        });
    $('#modalStock').modal('hide');
      //  alert("El dato se actualizó correctamente");
});

});
