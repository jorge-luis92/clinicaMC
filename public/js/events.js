$(document).ready(function() {

let  eventstables =$('#eventos_table').DataTable({
   processing: true,
   serverSide: true,
   ajax: '/dataeventstables',
   order: [[ 0, "desc" ]],
   columns: [
     {data: 'created_at'},
     {data: 'nombre_persona'},
     {data: 'producto'},
     {data: 'tipo_evento'},
     {data: 'cantidad'},
     {data: 'motivo'},
           ]
 });

});
