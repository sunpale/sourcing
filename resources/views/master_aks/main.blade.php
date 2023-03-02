<x-layout breadcrumbs="material" :datatable="true" :sweetalert="true" :toastify="true" :freeze-ui="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Aksesoris</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('aksesoris.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-aksesoris" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">ID Infor</th>
                            <th class="text-center">Product Group</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Supplier</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Item Desc</th>
                            <th class="text-center">UOM</th>
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
            function tableAksesoris(){
                const aksesoris = $('#tbl-aksesoris').DataTable({
                    serverSide: true,
                    ajax: '{{route('aksesoris.data')}}',
                    columns: [
                        {data: 'responsive',name:'responsive',searchable:false},
                        {data: 'rownum',name:'rownum',searchable:false}, {data: 'kode',name: 'kode'}, {data: 'kode_infor',name: 'kode_infor'}, {data: 'product_group.group',name: 'ProductGroup.group'},{data: 'color_aks.color_desc',name: 'ColorAks.color_desc'}, {data: 'brand.brand',name: 'brand.brand'}, {data: 'supplier.name',name: 'supplier.name'},{data : 'item_name',name: 'item_name'},{data : 'item_desc',name: 'item_desc'},{data:'measure.kode',data:'measure.kode'},{data: 'action',name: 'action'}
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
                            targets: [1,-1,-2],
                            width: '3%',
                            className: 'text-center p-1'
                        },
                        {
                            targets: [2,3],
                            width: '8%',
                            className: 'text-center'
                        },
                        {
                            targets: [4,5,6,7],
                            width: '8%'
                        },
                        {
                            targets: 8,
                            width: '10%'
                        },
                        {
                            targets: 9,
                            width: '25%'
                        }
                    ],
                    drawCallback: function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }
                });
                const tblAksesorisInput = $('#tbl-aksesoris_filter input');
                tblAksesorisInput.unbind();
                tblAksesorisInput.bind('keyup', function (e) {
                    if (e.keyCode === 13){
                        aksesoris.search(this.value).draw();
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
                            url : baseUrl + '/master-aksesoris/aksesoris/'+id+'/edit',
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
                            url     : baseUrl + '/master-aksesoris/aksesoris/'+id,
                            method  : "post",
                            data    : {"_token" : token[0].value,"_method":'DELETE'}
                        });
                    }
                }));
            }

            function view(id){
                window.location.href = baseUrl + '/master-aksesoris/aksesoris/'+id
            }

            document.addEventListener('DOMContentLoaded',function (){
                @if(Session::has('success'))
                notifikasi('success','{{session('success')}}')
                @endif
                tableAksesoris();
            });
        </script>
    @endsection
</x-layout>
