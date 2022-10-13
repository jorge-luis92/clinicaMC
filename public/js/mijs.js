

$(document).ready( function () {
    $('#frutas_todas').DataTable();
} );
$(document).ready( function () {
    $('#frutas_stock').DataTable();
} );

$(document).ready( function () {
  $('#users_side').DataTable({
      processing: true,
      serverSide: true,
      ajax: '/datauserstables',
      columns: [
          {data: 'name'},
          {data: 'email'},
          {data: 'editar'},

      ]
  });
} );


$(document).ready( function () {
    $('#productos').DataTable();
} );


$(document).ready( function () {
    $('#carnes_todas').DataTable();
} );
$(document).ready( function () {
    $('#carnes_stock').DataTable();
} );
$(document).ready( function () {
    $('#semillas_read').DataTable();
} );
$(document).ready( function () {
    $('#semillas_stock').DataTable();
} );



function numeros(e){
 key = e.keyCode || e.which;
 tecla = String.fromCharCode(key).toLowerCase();
 letras = " 0123456789";
 especiales = [8,37,39,46];

 tecla_especial = false
 for(var i in especiales){
if(key == especiales[i]){
  tecla_especial = true;
  break;
     }
 }

 if(letras.indexOf(tecla)==-1 && !tecla_especial)
     return false;
}
