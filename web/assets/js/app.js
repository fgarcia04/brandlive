generaDataTables = function(idTabla,configExtras) {
    dataTables = $(idTabla).DataTable(
        {
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
                    sSortAscending: ": Ordenar manera ascendente",
                    sSortDescending: ": Ordenar manera descendente"
                }
            },
            configExtras
        });
    return dataTables;

}

jConfirm = function (message, title, confirmCallback) {
    bootbox.confirm({
        title: title,
        message: message,
        buttons: {
            confirm: {
                label: 'Si',
                className: 'btn-primary'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: confirmCallback
    });
};

sendAjax = function (method, url, params,button,callBackSuccess = null, callBackBeforeSend= null, callBackComplete = null, callBackError = null) {
    $.ajax({
        type: method,
        url: Routing.generate(url),
        data: params,
        beforeSend: function(xhr) {
            if (callBackBeforeSend && typeof (callBackBeforeSend) === "function"){
                callBackBeforeSend(xhr);
            }else{
                setAlert('', '');
                if(button){
                    spinnerButton(true, button);
                }
            }
        },
        success: function(response) {
            if (callBackSuccess && typeof (callBackSuccess) === "function"){
                callBackSuccess(response);
            }else{
                setAlert(response.message, response.class);
            }
        },
        error: function(xhr) {
            if (callBackError && typeof (callBackError) === "function"){
                callBackError(xhr);
            }else{
                var body = jQuery.parseJSON( xhr.responseText );
                setAlert(body.message, body.class);
            }
        },
        complete: function(xhr) {
            if (callBackComplete && typeof (callBackComplete) === "function"){
                callBackComplete(xhr);
            }else{
                if(button){
                    spinnerButton(false, button);
                }
            }
        },
        dataType: 'json'
    });
}

spinnerButton = function (inicia, button) {
    if(inicia){
        button.prop("disabled", true).append('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
    }else{
        button.prop("disabled", false).find("span").remove();
    }
}

setAlert = function (mensaje, tipo) {
    $('#alert').html('<div class="alert alert-'+tipo+'" role="alert">'+mensaje+'</div>');
}