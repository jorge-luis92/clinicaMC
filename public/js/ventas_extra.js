$(document).ready(function() {
var user_id, opcion;
let agregado_a= [], probando_objects= [];
let posiciones= [];
let total=0,totales= 0;
let tot_esp=0, gan_esp=0;
let sumasdedatos= 0, sumasdeganancias=0;
  $("#totalV").html(totales);
  $("#total_especifico").html(tot_esp);
  $("#ganancia_especifico").html(tot_esp);
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
//para limpiar los campos antes de dar de Alta una Persona



$(function () {
    $(document).on('click', '.btnBorrar', function (event) {
        event.preventDefault();
        $(this).closest('tr').remove();
    });
});

$(document).on("click", "#dd", function(){
let  jaja = $(this).closest("tr");
  let user_ids = parseInt(jaja.find('td:eq(0)').text());
  let nombreprr = jaja.find('td:eq(1)').text();
      let gramusav = parseInt(jaja.find('td:eq(3)').text());
    let gramus = parseFloat(jaja.find('td:eq(4)').text());
  let pos = posiciones.indexOf(user_ids);
  let respuesta = confirm("¿Está seguro de quitar el producto?");
    if (respuesta) {
      total=total-gramus;
    //    $('#totalV').val(total);
    totales=total.toFixed(2);
          $("#totalV").html(totales);
            document.getElementById("id_producs").value=totales;
              $(this).closest('tr').remove();
              agregado_a.splice(pos,1);
              posiciones.splice(pos,1);
              probando_objects.splice(pos,1);
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
  //  $(".modal-title").text("Inserte Cantidad");
    $('#gramosa').modal('show');

});

$(document).on("click", "#btnpesos", function(){
  $("#cantidad_pes").val("");
  let id_pr = document.getElementById("tipo").value;
  $("#id_produc").val(id_pr);
  //  $(".modal-title").text("Inserte Cantidad");
  $.ajax({
   //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      type: "get",
      url: "/quitar_act/"+id_pr,
      datatype: 'json',
     // data:  {id:id},
      success : function(respuesta) {
        const prueba = JSON.parse(respuesta);
        $(".modal-title").text(prueba.nombre);
        $('#pesosa').modal('show');
              },
      error : function(xhr, status) {
          alert('Disculpe, existió un problema');       },
      complete : function(xhr, status) {
               //   alert('Petición realizada');
      }
  });

});

$(document).on("click", "#btngramoss", function(){
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
        $(".modal-title").text(prueba.nombre+" ------- Precio venta: "+prueba.precio);
        $('#gramosa').modal('show');
              },
      error : function(xhr, status) {
          alert('Disculpe, existió un problema');       },
      complete : function(xhr, status) {
               //   alert('Petición realizada');
      }
  });

});

$(document).on("change", "#tipso", function(){
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
    let cuack = parseInt(id_delp);
    let position = posiciones.indexOf(cuack);
    if (gram < 1) {
      alert("La cantidad debe ser mayor a 0");
            }
    else {

if (position < 0) {
     let id = $("#tipo").val();
  let sihay= revisarStock(id, gram);
}else {
         alert("El producto ya se encuentra insertado");
}
}
});

$('#formPesos').submit(function(e){
$('#pesosa').modal('hide');
    e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
    id_delp = $.trim($('#id_produc').val());
    pesos = $.trim($('#cantidad_pes').val());

    console.log("entro en pesosa?:   "+ pesos);
    let cuack = parseInt(id_delp);
    let dalepeso= parseFloat(pesos);
    let position = posiciones.indexOf(cuack);

    ///------------------------------------------------
    if(dalepeso < 1){
      alert("La cantidad debe ser mayor a 0");
    }
    else {


    $.ajax({
         type: "get",
         url: "/datopro/"+cuack,
         datatype: 'json',
         success : function(respuesta) {
           const prueba = JSON.parse(respuesta);
           let alma=0, almados=0;
           let vals = prueba.unidad_venta;
           //console.log("imprime unidad de venta:  "+vals);
           let pres = parseInt(prueba.precio);
            //console.log("imprime precio:  "+pres);
           if(vals == "Gramos"){
            alma=(1000/pres)*dalepeso;
             alma=alma.toFixed(2);
          //   console.log("gramos a vender:   "+alma);
           }else {
               alma=(dalepeso/prueba.precio);
          // almados=almados.toFixed(2);
        //      console.log("piezas o bolsas a vender:   "+alma);
           }
      //console.log("imprime ambos resultados, tanto id: "+ cuack+ "como gramos o piezas: "+ alma );
    if (position < 0) {
       let id = $("#tipo").val();
    let sihay= revisarStock(cuack, alma);
    }else {
           alert("El producto ya se encuentra insertado");
    }
         }
         });
       }
});

     function revisarStock(id, gram) {
            let valor= id;
            let gramitos= parseInt(gram);
           $.ajax({
                type: "get",
                url: "/revisarSt/"+valor,
                datatype: 'json',
                success : function(respuesta) {
                  const prueba = JSON.parse(respuesta);
                  let val = parseInt(prueba.stock);
                 if (val >= gramitos) {
                   $.ajax({
                    //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                       type: "get",
                       url: "/quitar_act/"+id,
                       datatype: 'json',
                      // data:  {id:id},
                       success : function(respuesta) {
                         const prueba = JSON.parse(respuesta);
                         let totaltemp=0, totalstemp=0, gana=0, gananciaspues= 0, otrogano=0;
                         let cuvs= prueba.unidad_venta;
                         let cant_a_venders = parseInt(gramitos);
                         if(cuvs == "Gramos"){
                            totaltemp=totaltemp+((cant_a_venders/1000)*prueba.precio);
                          gana = gana+((cant_a_venders/1000)*prueba.precio_may)+((cant_a_venders/1000)*1);
                          gananciaspues = gana - ((cant_a_venders/1000)*prueba.precio_may) ;
                          otrogano=gana.toFixed(2);
                           totalstemp=totaltemp.toFixed(2);
                           $("#totalV").html(totalstemp);
                         }else {
                           totaltemp=totaltemp+(cant_a_venders*prueba.precio);
                             gana = gana+(cant_a_venders*prueba.precio_may)+1;
                            gananciaspues = 1;
                             otrogano=gana.toFixed(2);
                           totalstemp=totaltemp.toFixed(2);
                               $("#totalV").html(totalstemp);
                         }
                        let fila = `<tr>
                                <td id= "id_p"scope="row">${prueba.id}</td>
                                <td id="nombrepro" scope="row">${prueba.nombre}</td>
                                  <td id="preciov" scope="row">$&nbsp;${prueba.precio_may}&nbsp;${prueba.unidad}</td>
                                  <td id="gramitos"  scope="row">${gramitos} ${prueba.unidad_venta} </td>
                                  <td id="tipodegr"  scope="row">${otrogano} </td>
                                  <td scope="row"><button id="dd" class="btn-danger"> <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-backspace-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2V3zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8 5.829 5.854z"/>
                                  </svg>
                                  </button>
                                  </td>
                                        </tr>`;

                                            $("#productos_insertados").append(fila);
                                            let nuevopro=[prueba.id, prueba.nombre, prueba.precio, gramitos];
                                            let myProduct = { id: prueba.id, nombre: prueba.nombre, tipo: prueba.tipo, totaltempo: otrogano, gramos: gramitos, ganancias: gananciaspues};
                                            probando_objects.push(myProduct);
                                            agregado_a.push(nuevopro);
                                            posiciones.push(prueba.id);
                                            let cuv= prueba.unidad_venta;
                                            let cant_a_vender = parseInt(gramitos);
                                            if(cuv == "Gramos"){
                                             total=total+((cant_a_vender/1000)*prueba.precio_may)+((cant_a_venders/1000)*1);
                                              totales=total.toFixed(2);
                                              $("#totalV").html(totales);
                                          document.getElementById("id_producs").value=totales;
                                            }else {
                                                  total=total+(cant_a_vender*prueba.precio_may)+1;

                                            totales=total.toFixed(2);
                                                  $("#totalV").html(totales);
                                                document.getElementById("id_producs").value=totales;
                                            }

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

               $(document).ready( function () {
                tableproductsto =$('#productos_table_todos').DataTable({
                 processing: true,
                 serverSide: true,
                 ajax: '/dataproductstables',
                 columns: [
                   {data: 'nombre'},
                   {data: 'unidad_venta'},
                   {data: 'tipo'},
                   {data: 'precio'},
                    {data: 'stock'},
                 ]
               });
             });


             $(document).on("click", "#ejecutarVenta", function(){
if($.isEmptyObject(probando_objects)){
alert("No hay nada que vender");
}else {
  let respuesta = confirm("¿Está seguro de concretar la venta?");
    if (respuesta) {
  let totaldev = document.getElementById("id_producs").value;
  $.ajax({
  headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type: "POST",
    url: "/realizarventa",
    datatype:"json",
    data:  {data:probando_objects, precio: totaldev},
    success: function(data) {
      window.location.assign("ventas");
//      alert("Venta concretada");
document.getElementById('alrt').innerHTML='<b>¡La venta se ha realizado correctamente!';
setTimeout(function() {document.getElementById('alrt').innerHTML='';},2000);


}
});
}
}
});

let rv= $(document).ready( function () {
 tablausers =$('#registro_ventas_dia').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/dataregventas',

    columns: [
      {data: 'created_at'},
     {data: 'produto'},
    //  {data: 'cantidad_vendida'},
    { data: function (data, type, dataToSet) {
       return data.cantidad_vendida + " " + data.unidad_venta;
     }},
  //  {data: 'total'},
    { data: function (data, type, dataToSet) {
       return  "$ " + data.total;
     }},
    { data: function (data, type, dataToSet) {
       return  "$ " + data.precio_pub;
     }},
    {data: 'precio_may'},
    {data: 'ganancias'},
      ]
  });
});


 $('#seranmisventas').DataTable({
    processing: true,
    serverSide: true,
    ajax: '/ventasmias',
    columns: [
      {data: 'created_at'},
      {data: 'produto'},
      {data: 'cantidad_vendida'},
    {data: 'total'},
    {data: 'precio_pub'},
    {data: 'precio_may'},
    {data: 'ganancias'},
      ]

  });

  $('#busqueda_registros_especificos').submit(function(e){
        e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
sumasdedatos=0;
sumasdeganancias=0;
let id= 3;
let fecha = document.getElementById("fecha_inicio").value;
let tipo_pr = document.getElementById("tipo_busqueda_pr").value;
$.ajax({
 //   headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    type: "get",
    url: "/busqueda_especifica/"+fecha+"/"+tipo_pr,
    datatype: 'json',
    success : function(respuesta) {
 $("#reg_esp_fecha tr").remove();
sumasdeganancias = parseFloat(sumasdeganancias);
sumasdedatos = parseFloat(sumasdedatos);
respuesta.data.forEach(item => {
sumasdedatos+= parseFloat(item["total"]);
sumasdeganancias+=  parseFloat(item["ganancias"]);
let fila = `<tr>
          <td id= "id_p"scope="row">${item["created_at"]}</td>
          <td id="nombrepro" scope="row">${item["produto"]}</td>
           <td id="preciov" scope="row">${item["cantidad_vendida"]} ${item["unidad_venta"]}</td>
          <td id= "id_p"scope="row">$&nbsp;${item["total"]}</td>
          <td id="nombrepro" scope="row">$&nbsp;${item["precio_pub"]}</td>
          <td id="preciov" scope="row">$&nbsp;${item["precio_may"]}</td>
          <td id="preciov" scope="row">$&nbsp;${item["ganancias"]}</td>
                </tr>`;
                    $("#reg_esp_fecha").append(fila);
})

sumasdedatos=sumasdedatos.toFixed(2);
sumasdeganancias=sumasdeganancias.toFixed(2);
$("#total_especifico").html(sumasdedatos);
$("#ganancia_especifico").html(sumasdeganancias);
  },
    error : function(xhr, status) {
        alert('Disculpe, existió un problema');
      }
});
    });

    $('#gramosa').on('shown.bs.modal', function () {
           $('#cantidad_gram').focus();
    })

    $('#pesosa').on('shown.bs.modal', function () {
           $('#cantidad_pes').focus();
    })

    $('#download_pdf_reg').submit(function(e){
          e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página

  let fecha = document.getElementById("fecha_inicio").value;
  let tipo_pr = document.getElementById("tipo_busqueda_pr").value;
  if(fecha == '' || tipo_pr == ''){
    alert("Seleccione fecha y/o tipo de busqueda");
  }
  else{
 //window.location.href='pdf_registros/'+fecha +'/'+ tipo_pr;
 window.open('pdf_registros/'+fecha +'/'+ tipo_pr, '_blank');


}
      });
      $("#cantidad_gram").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            // Do something
        }
    });

});
