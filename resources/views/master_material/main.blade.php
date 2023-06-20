<x-layout breadcrumbs="material" :datatable="true" :sweetalert="true" :toastify="true" :freeze-ui="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Raw Material</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('master-material.raw-material.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-material" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">ID</th>
                            <th class="text-center">ID Infor</th>
                            <th class="text-center">Fabric</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Supplier</th>
                            <th class="text-center">Item Name</th>
                            <th class="text-center">Item Desc</th>
                            <th class="text-center">Komposisi</th>
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
        function tableMaterial(){
            const material = $('#tbl-material').DataTable({
                serverSide: true,
                ajax: '{{route('master-material.raw-material.data')}}',
                columns: [
                    {data: 'responsive',name:'responsive',searchable:false},
                    {data: 'rownum',name:'rownum',searchable:false}, {data: 'kode',name: 'kode'}, {data: 'kode_infor',name: 'kode_infor'}, {data: 'fabric.description',name: 'fabric.description'},{data: 'color.description',name: 'color.description'}, {data: 'brand.brand',name: 'brand.brand'}, {data: 'supplier.name',name: 'supplier.name'},{data : 'item_name',name: 'item_name'},{data : 'item_desc',name: 'item_desc'},{data : 'komposisi.komposisi',name: 'komposisi.komposisi'},{data:'measure.kode',data:'measure.kode'},{data: 'action',name: 'action'}
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
                        targets: [1,2],
                        width: '8%',
                        className: 'text-center'
                    },
                    {
                        targets: [3,4,5],
                        width: '8%'
                    },
                    {
                        targets: 6,
                        width: '8%'
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
            const tblMaterialInput = $('#tbl-material_filter input');
            tblMaterialInput.unbind();
            tblMaterialInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    material.search(this.value).draw();
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
                        url : baseUrl + '/master-material/raw-material/'+id+'/edit',
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
                        url     : baseUrl + '/master-material/raw-material/'+id,
                        method  : "post",
                        data    : {"_token" : token[0].value,"_method":'DELETE'}
                    });
                }
            }));
        }

        function view(id){
            window.location.href = baseUrl + '/master-material/raw-material/'+id
        }
        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif
            tableMaterial();
        });
    </script>
    @endsection
</x-layout>
