!function () {
    "use strict";
    if($.fn.dataTable){
        $.extend($.fn.dataTable.defaults,{
            displayLength: 15,
            lengthMenu: [15,25,50,75,100],
            ordering    : false,
            processing  : true,
            responsive  : {
                details : {
                    display :$.fn.dataTable.Responsive.display.modal({
                        header : function (row){
                            return 'Detail Data';
                        }
                    }),
                    type    : 'column',
                    renderer: function (api,rowIdx,columns){
                        let data = $.map(columns,function (col,i){
                            return col.title !=='' && col.title !== 'id' && col.title !== 'No.' ?
                                '<tr data-dt-row="'+rowIdx+'" data-dt-column="'+col.columnIndex+'">'+
                                '<td>'+col.title+':'+'</td>'+
                                '<td>'+col.data+'</td></tr>':'';
                        }).join('');
                        return data ? $('<table class="table">').append('<tbody>'+data+'</tbody>'):false;
                    }
                }
            },
            language    : {
                paginate:{
                    previous    : '<',
                    next        : '>'
                }
            },
            columnDefs  :[
                {
                    // For Responsive
                    className: 'control text-center',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    width: '5%',
                },
                {
                    targets: [1,-1],
                    width: '3%',
                    className: 'text-center'
                },
                {
                    targets: 2,
                    visible : false
                }
            ]
        });
    }
}();