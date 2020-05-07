var table_clients;
$(document).ready(function () {
    table_clients = $('#list-clientes').DataTable({
        columnDefs: [
            {  orderable: false, targets: 4 }
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ registros",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando _START_ al _END_",
            sInfoEmpty: "Mostrando 0 de  0",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sInfoPostFix: "",
            sSearch: "Buscar:",
            sUrl: "",
            sInfoThousands: ",",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior"
            },
            oAria: {
                sSortAscending: ": Ordenar columna de manera ascendente",
                sSortDescending: ": Ordenar columna de manera descendente"
            }
        },
        responsive: true,
        autoWidth: true,
        processing: true
    })
});


$('.remove-client').click(function() {
    var tr = $(this).parent().parent();
    var client = table_clients.row(tr).data();
    var button = $(this);
    jConfirm("Confirma eliminar el cliente "+client[0]+" "+client[1]+" ?", "Eliminar Cliente", function (response) {
        if(response){
            sendAjax('DELETE', 'delete-client', {id:tr.attr('data-id')},
                function(response){
                    table_clients.row(tr).remove().draw();
                },function() {
                    spinnerButton(true, button);
                }, function () {
                    spinnerButton(false, button);
                });
        }
    });
});