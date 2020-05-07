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

sendAjax = function (method, url, params,callBackSuccess = null, callBackBeforeSend= null, callBackComplete = null, callBackError = null) {
    $.ajax({
        type: method,
        url: Routing.generate(url),
        data: params,
        beforeSend: function(xhr) {
            if (callBackBeforeSend && typeof (callBackBeforeSend) === "function"){
                callBackBeforeSend(xhr);
            }
        },
        success: function(response) {
            if (callBackSuccess && typeof (callBackSuccess) === "function"){
                callBackSuccess(response);
            }
        },
        error: function(xhr) {
            if (callBackError && typeof (callBackError) === "function"){
                callBackError(xhr);
            }
        },
        complete: function(xhr) {
            if (callBackComplete && typeof (callBackComplete) === "function"){
                callBackComplete(xhr);
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