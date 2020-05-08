var table_clients;
$(document).ready(function () {
    generateTable();
});

generateTable = function(){
    configExtras = {
        columnDefs: [
            {  orderable: false, targets: 4 }
        ],
        responsive: true,
        autoWidth: true,
        processing: true
    };
    table_clients = generaDataTables("#list-clientes", configExtras);
}

$('.remove-client').click(function() {
    var tr = $(this).parent().parent();
    var client = table_clients.row(tr).data();
    var button = $(this);
    jConfirm("Confirma eliminar el cliente "+client[0]+" "+client[1]+" ?", "Eliminar Cliente", function (response) {
        if(response){
            sendAjax('DELETE', 'delete-client', {id:tr.attr('data-id')},button,
                function(response){
                    setAlert(response.message, response.class);
                    table_clients.row(tr).remove().draw();
                });
        }
    });
});