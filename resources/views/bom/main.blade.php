<x-layout breadcrumbs="bom" :datatable="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Article</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('bom.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-bom" class="table table-sm table-bordered dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Article</th>
                            <th class="text-center">Items</th>
                            <th class="text-center">Revision</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        function formatNumber(num) {
            return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.')
        }

        function tableBom(){
            const bom = $('#tbl-bom').DataTable({
                serverSide: true,
                ajax: '{{route('bom.data')}}',
                columns: [
                    {data: 'responsive',name:'responsive',searchable:false},
                    {data: 'rownum',name:'rownum',searchable:false},{data: 'id',name: 'id'}, {data: 'kode',name: 'kode'}, {data: 'article.kode',name: 'article.kode'},{data: 'item',name: 'item'}, {data: 'revision',name: 'revision'}, {data: 'status',name: 'status'},{data: 'action',name: 'action', searchable: false}
                ],
                columnDefs: [
                    {
                        // For Responsive
                        className: 'control',
                        orderable: false,
                        responsivePriority: 2,
                        targets: 0
                    },
                    {
                        targets: [1,-1],
                        width: '3%',
                        className: 'text-center p-1'
                    },
                    {
                        targets: 2,
                        visible : false
                    },
                    {
                        targets: [3,4],
                        width: '20%',
                        className: 'text-center'
                    },
                    {
                        targets: [5,6,7],
                        width: '8%',
                        className: 'text-center'
                    }
                ],
                drawCallback: function () {
                    $('#tbl-bom tbody tr td a#btnlist').on('click',function (e){
                        e.preventDefault();
                        let tr = $(this).closest('tr');
                        let row = bom.row(tr);
                        let baris = $(this).closest('tr').get(0);
                        let bomId = bom.cell(baris,2).nodes().to$().text()

                        if (tr.hasClass('shown')){
                            row.child.hide();
                            tr.removeClass('shown');
                        }else {
                            fetch(baseUrl + '/bom/find-detail/'+bomId,{
                                headers: {
                                    'Content-Type': 'application/json'
                                }
                            })
                                .then(response => response.json())
                                .then(data => {
                                    let ratio,remarks;
                                    let childTable = '<div class="row p-3"><div class=col-md-12><table id="tbl-bom-detail" class="table table-sm table-bordered table-hover table-striped align-middle table-nowrap mb-0 w-100 caption-top">' +
                                        '<caption class="p-0"> Bom Item</caption>' +
                                        '<thead class="table-light">' +
                                        '<tr>' +
                                        '<th class="text-center">No</th>' +
                                        '<th class="text-center">Size</th>'+
                                        '<th class="text-center">Ratio</th>'+
                                        '<th class="text-center">Item</th>'+
                                        '<th class="text-center">Item Description</th>'+
                                        '<th class="text-center">Cons</th>'+
                                        '<th class="text-center">Price</th>'+
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    let rowNum=0
                                    let priceMaterial;
                                    let cons;
                                    for (let i=0;i<data.material.length;i++){
                                        rowNum+=1;
                                        ratio = data.material[i].ratio==='0' ? '':data.material[i].ratio;
                                        priceMaterial = data.material[i].material['unit_price'].replace('.00','');
                                        cons = data.material[i].cons.replace('.0000','');
                                        cons = cons.substring(0,1) ==='.' ? 0+''+cons : cons;
                                        childTable +=
                                            '<tr>' +
                                            '<td class="text-center">'+rowNum+'</td>' +
                                            '<td class="text-center">'+data.material[i].size['size']+'</td>' +
                                            '<td class="text-center">'+ratio+'</td>' +
                                            '<td class="text-center">'+data.material[i].product_group['group']+'</td>' +
                                            '<td class="text-center">'+data.material[i].material['item_name']+'</td>' +
                                            '<td class="text-center">'+ cons.replace('.',',') +'</td>'+
                                            '<td class="text-end">'+formatNumber(priceMaterial)+'</td></tr>';
                                    }
                                    childTable +=  '</tbody><tfoot class="table-light">' +
                                        '<tr>' +
                                        '<td colspan="6" class="text-center fw-bold">Total</td><td class="text-end fw-bold">'+data.sumMaterial.replace(',00','')+'</td>' +
                                        '</tr></tfoot></table></div></div>';
                                    childTable += '<div class="row p-3"><div class=col-md-12><table id="tbl-bom-jasa" class="table table-sm table-bordered table-hover table-striped align-middle table-nowrap mb-0 w-100 caption-top">' +
                                        '<caption class="p-0"> Jasa</caption>' +
                                        '<thead class="table-light">' +
                                        '<tr>' +
                                        '<th class="text-center">No</th>' +
                                        '<th class="text-center">Jasa</th>'+
                                        '<th class="text-center">Remarks</th>'+
                                        '<th class="text-center">cons</th>'+
                                        '<th class="text-center">price</th>'+
                                        '</tr>' +
                                        '</thead>' +
                                        '<tbody>';
                                    let rowJasa=0
                                    let priceJasa;
                                    for (let i=0;i<data.jasa.length;i++){
                                        rowJasa+=1;
                                        remarks = data.jasa[i].remarks=== null ? '':data.jasa[i].remarks;
                                        priceJasa = data.jasa[i].price.replace('.00','');
                                        childTable +=
                                            '<tr>' +
                                            '<td class="text-center">'+rowJasa+'</td>' +
                                            '<td class="text-center">'+data.jasa[i].service['name']+'</td>' +
                                            '<td class="text-center">'+remarks+'</td>' +
                                            '<td class="text-center">'+data.jasa[i].cons+'</td>' +
                                            '<td class="text-end">'+formatNumber(priceJasa.replace('.',','))+'</td></tr>';
                                    }
                                    childTable +=  '</tbody><tfoot class="table-light">' +
                                        '<tr>' +
                                        '<td colspan="4" class="text-center fw-bold">Total</td><td class="text-end fw-bold">'+data.sumJasa.replace(',00','')+'</td>' +
                                        '</tr></tfoot></table></div></div>';

                                    row.child(childTable).show();
                                    tr.addClass('shown');
                                })
                                .catch(error => console.error(error));
                        }
                    });
                }
            });
            const tblBomInput = $('#tbl-bom_filter input');
            tblBomInput.unbind();
            tblBomInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    bom.search(this.value).draw();
                }
            });
        }
        document.addEventListener('DOMContentLoaded',function (){
            tableBom();
        });
    </script>
    @endsection
</x-layout>
