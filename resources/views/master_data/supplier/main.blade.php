<x-layout breadcrumbs="supplier" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Supplier</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('supplier.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-supplier" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Product Group ID</th>
                            <th class="text-center">Product Group</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">Address</th>
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
        function tableSupplier(){
            const supplier = $('#tbl-supplier').DataTable({
                serverSide: true,
                ajax: '{{route('supplier.data',1)}}',
                columns: [
                    {data: 'responsive',name:'responsive',searchable:false},
                    {data: 'rownum',name:'rownum',searchable:false}, {data: 'id',name: 'id',searchable:false}, {data: 'kode',name: 'kode'}, {data: 'type',name: 'type'},{data: 'product_group_id',name: 'product_group_id',searchable:false}, {data: 'product_group.group',name: 'ProductGroup.group'}, {data: 'name',name: 'name'},{data : 'address',name: 'address',searchable:false},{data: 'action',name: 'action'}
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
                        targets: [2,5],
                        visible: false
                    },
                    {
                        targets: [3,4],
                        width: '6%',
                        className: 'text-center'
                    },
                    {
                        targets: 6,
                        width: '10%'
                    },
                    {
                        targets: 7,
                        width: '25%'
                    }
                ],
                drawCallback: function () {
                    $('[data-bs-toggle="tooltip"]').tooltip();
                }
            });
            const tblSupplierInput = $('#tbl-supplier_filter input');
            tblSupplierInput.unbind();
            tblSupplierInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    supplier.search(this.value).draw();
                }
            });
        }

        function edit(id){
            Swal.fire({
                title: "{!! config('constants.CONFIRM_TITLE_EDIT') !!}",
                text: "{!! config('constants.WARNING_MESSAGE') !!}",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes"
            }).then(function (result) {
                if(result.value){
                    url_redirect({
                        url : baseUrl + '/master-data/supplier/'+id+'/edit',
                        method  : "get"
                    });
                }
            });
        }

        function hapus(id){
            let token=document.getElementsByName('_token');
            Swal.fire({
                title: "{{config('constants.CONFIRM_TITLE_DELETE')}}",
                text: "{{config('constants.WARNING_MESSAGE')}}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"
            }).then((function (result) {
                if(result.value){
                    url_redirect({
                        url     : baseUrl + '/master-data/supplier/'+id,
                        method  : "post",
                        data    : {"_token" : token[0].value,"_method":'DELETE'}
                    });
                }
            }));
        }

        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif
           tableSupplier();
        });
    </script>
    @endsection
</x-layout>
