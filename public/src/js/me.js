function url_redirect(options){
    let form = document.createElement('form');
    form.action = options.url;
    form.method = options.method;
    for(let data in options.data){
        let element = document.createElement('input');
        element.type = 'hidden';
        element.name = data;
        element.value = options.data[data];
        form.appendChild(element);
    }
    document.body.appendChild(form);
    form.submit();
}

function notif(type,pesan ,title,timeout=2500) {
    toastr.options = {
        closeButton         : false,
        debug               : false,
        newestOnTop         : true,
        progressBar         : true,
        positionClass       : 'toast-top-right',
        preventDuplicates   : true,
        onclick             : null,
        showDuration        : 300,
        hideDuration        : 100,
        timeOut             : timeout,
        extendedTimeOut     : 1000,
        showEasing          : "swing",
        hideEasing          : "linear",
        showMethod          : "fadeIn",
        hideMethod          : "fadeOut",
        tapToDismiss        : false
    }
    toastr[type](pesan,title);/*type= success,error,warning,info*/
}

function notifikasi(type,pesan,gravity='top',position='right',duration=3000,close=false,style='style'){
    Toastify({
        className : 'bg-'+type,
        gravity : gravity,
        position : position,
        text: pesan,
        duration: duration,
        close : close,
        style : style
    }).showToast();
}

function import_data(url,token,judul,format) {
    $('#tmpModal').load(baseUrl + '/import',{'url' : url,'_token' : token,'judul':judul,'format' : 'format/'+format},function (response,data) {
        let responseData=response.split('+');
        document.getElementById('tmpModal').innerHTML = responseData[0];
        let modalImportEl = document.getElementById('import-data');
        let modalImport = new bootstrap.Modal('#import-data',{backdrop : 'static',keyboard:false})
        modalImport.show();
        modalImportEl.addEventListener('hide.bs.modal',function (){
            document.getElementsByName('_token')[0].value = responseData[1];
        });

        $('.import-data').on('hide.bs.modal', function() {
            $('input[name=_token]').val(responseData[1])
        });
    });
}

/*select2 styling paginatioin*/
function format (repo) {
    if (repo.loading) {
        return repo.text;
    }

    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__title'></div>" +
        "</div>"
    );
    $container.find(".select2-result-repository__title").text(repo.text);

    return $container;
}

function formatSelection (repo) {
    return repo.text.split(':')[0];
}
/*End*/

/*Convert Month*/
function convert_month(bulan){
    if(bulan==1){
        return 'Januari';
    }else if(bulan==2){
        return 'Februari';
    }else if(bulan==3){
        return 'Maret';
    }else if(bulan==4){
        return 'April';
    }else if(bulan==5){
        return 'Mei';
    }else if(bulan==6){
        return 'Juni';
    }else if(bulan==7){
        return 'Juli';
    }else if(bulan==8){
        return 'Agustus';
    }else if(bulan==9){
        return 'September';
    }else if(bulan==10){
        return 'Oktober';
    }else if(bulan==11){
        return 'November';
    }else {
        return 'Desember';
    }
}
/*End Convert Month*/

//region print report
function cetak(url){
    let strWindowFeatures = "location=no,resizable=no,fullscreen=yes,scrollbars=yes,status=yes";
    return  window.open(url, "_blank", strWindowFeatures);
}
//endregion
