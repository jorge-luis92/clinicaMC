$(document).ready(function() {

let  tableproducts =$('#productos_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: '/dataproductstables',
   order: [[ 1, "asc" ]],
   columns: [
     {data: 'id'},
     {data: 'nombre'},
     {data: 'tipo'},
     {data: 'precio'},
     {data: 'stock'},
     {data: 'inversion'},
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

$(document).on("click", ".btnDesactivar", function(){
    fila = $(this).closest("tr");
   let prod_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

   let respuesta = confirm("¿Está seguro de Desactivar el producto?");
     if (respuesta) {

  $.ajax({
      type: "get",
      url: "/prodesac/"+prod_id,
      datatype: 'json',
      success : function(respuesta) {
        tableproducts.ajax.reload(null, false);
        tableproductss.ajax.reload(null, false);
      alert(respuesta);
              },
      error : function(xhr, status) {
          alert('Disculpe, existió un problema');       },
      complete : function(xhr, status) {
               //   alert('Petición realizada');
      }
  });
}
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
    let produts = $('#recipient-name').val();
    console.log(first_name);
    let respuesta = confirm("¿Está seguro de agregar esa cantidad a Stock?");
      if (respuesta) {
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          type: "POST",
          url: "/addstock",
          datatype:"json",
          data:  {id:id_p, stock:first_name, producto:produts},
           success: function(data) {
             if($.isEmptyObject(data.error)){
                 tableproducts.ajax.reload(null, false);
                 tableproductss.ajax.reload(null, false);
                             alert(data.success);
                         }else{
                             alert(data.error);
                         }
            }
        });
      }
    $('#modalStock').modal('hide');
});

let  tableproductss =$('#productos_table_quitar').DataTable({
   processing: true,
   serverSide: true,
   ajax: '/dataproductstablesquitar',
   columns: [
     {data: 'id'},
     {data: 'nombre'},
     {data: 'stock'},
     {data: 'action'},
     {defaultContent:
       '<button class="btn btn-info btn-sm btnQuitarS" data-toggle="tooltip" title="Editar">Quitar &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 01-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg></button>'}
   ]
 });

 $(document).on("click", ".btnQuitarS", function(){
   $("#stock_quit").val("");
    $("#motivo").val("");
     fila = $(this).closest("tr");
    let produto_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
    let nombre = fila.find('td:eq(1)').text();
    $("#id_quitar").val(produto_id);
    $("#recipient-name-res").val(nombre);
     $(".modal-title").text("Quitar del Stock");
     $('#modalStockQuit').modal('show');

 });


 $('#postStockQuit').submit(function(e){

     e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

     let user_id = parseInt(fila.find('td:eq(0)').text());
     let id_p = $.trim($('#id_quitar').val());
     let first_name = $('#stock_quit').val();
      let motivo_quitar = $('#motivo').val();
      let produts = $('#recipient-name-res').val();
  //   console.log("ID: "+id_p+" cantidad a quitar: "+first_name+" Motivo a quitar: "+motivo_quitar);
     let respuesta = confirm("¿Está seguro de quitar esa cantidad del Stock?");
       if (respuesta) {
         $.ajax({
         headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
           type: "POST",
           url: "/quitstock",
           datatype:"json",
           data:  {id:id_p, stock:first_name, motivo:motivo_quitar, producto:produts},
            success: function(data) {
              if($.isEmptyObject(data.error)){
                  tableproductss.ajax.reload(null, false);
                  tableproducts.ajax.reload(null, false);
                              alert(data.success);
                          }else{
                              alert(data.error);

                          }
             }
         });
       }
     $('#modalStockQuit').modal('hide');
       //  alert("El dato se actualizó correctamente");

 });


 let  tableproducts_desa =$('#productos_table_des').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/dataproductstablesdes',
    order: [[ 1, "asc" ]],
    columns: [
      {data: 'id'},
      {data: 'nombre'},
      {data: 'tipo'},
      {defaultContent:
        '<button class="btn btn-info btn-sm btnActivar" data-toggle="tooltip" title="activar">Activar &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-up-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></button>'}
    ]
  });

  $(document).on("click", ".btnActivar", function(){
      fila = $(this).closest("tr");
     let prod_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID

     let respuesta = confirm("¿Está seguro de Activar el producto?");
       if (respuesta) {

    $.ajax({
        type: "get",
        url: "/prodac/"+prod_id,
        datatype: 'json',
        success : function(respuesta) {
          tableproducts_desa.ajax.reload(null, false);
        alert(respuesta);
                },
        error : function(xhr, status) {
            alert('Disculpe, existió un problema');       },
        complete : function(xhr, status) {
                 //   alert('Petición realizada');
        }
    });
  }
  });

  let  tableproductsss =$('#productos_table_promos').DataTable({
     processing: true,
     serverSide: true,
     ajax: '/dataproductstables_pro',
     order: [[ 3, "desc" ]],
     columns: [
       {data: 'id'},
       {data: 'nombre'},
      {data:  'precio'},
        {data: 'promocion'},
       {defaultContent:
         '<button class="btn btn-info btn-sm btnagregarpromo" data-toggle="tooltip" title="Editarpro">Descuento &nbsp;<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-cart-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">  <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z"/></svg></button>'}
     ]
   });

   $(document).on("click", ".btnagregarpromo", function(){
      $("#promocion").val("");
       fila = $(this).closest("tr");
      let produto_id = parseInt(fila.find('td:eq(0)').text()); //capturo el ID
      let nombre = fila.find('td:eq(1)').text();
      $("#recipient-name").val(nombre);
      $("#id").val(produto_id);
       $(".modal-title").text(nombre);
       $('#modalpromo').modal('show');

   });

   $('#postpromo').submit(function(e){
       e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
       let user_id = parseInt(fila.find('td:eq(0)').text());
       let id_p = $.trim($('#id').val());
       let first_name = $('#promocion').val();
       let promos = parseFloat(first_name);
       let produts = $('#recipient-name').val();
       console.log(promos);
       let respuesta = confirm("¿Está seguro de agregar la promoción?");
         if (respuesta) {
           $.ajax({
           headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
             type: "POST",
             url: "/addpromos",
             datatype:"json",
             data:  {id:id_p, stock:promos, producto:produts},
              success: function(data) {
                if($.isEmptyObject(data.error)){
                    tableproductsss.ajax.reload(null, false);
                                alert(data.success);
                            }else{
                                alert(data.error);
                            }
               }
           });
         }
       $('#modalpromo').modal('hide');
   });
   $('#modalpromo').on('shown.bs.modal', function () {
          $('#promocion').focus();
   })
});
