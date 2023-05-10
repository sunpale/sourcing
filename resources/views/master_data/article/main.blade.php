<x-layout breadcrumbs="article" :datatable="true" :glightbox="true" :sweetalert="true" :toastify="true" :freeze-ui="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Article</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('articles.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-article" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Modul</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Color</th>
                            <th class="text-center">Designer</th>
                            <th class="text-center">Image</th>
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
            function tableArticle(){
                const article = $('#tbl-article').DataTable({
                    serverSide: true,
                    ajax: '{{route('articles.data')}}',
                    columns: [
                        {data: 'responsive',name:'responsive',searchable:false},
                        {data: 'rownum',name:'rownum',searchable:false}, {data: 'kode',name: 'kode'}, {data: 'brand.brand',name: 'brand.brand'},{data: 'modul',name: 'modul'}, {data: 'name',name: 'name'}, {data: 'pantone.pantone',name: 'pantone.pantone'},{data : 'designer',name: 'designer'},{data : 'image',name: 'image',searchable: false},{data: 'action',name: 'action', searchable: false}
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
                            targets: [2],
                            width: '6%',
                            className: 'text-center'
                        },
                        {
                            targets: [3,4,6,7],
                            width: '8%',
                            className: 'text-center'
                        },
                        {
                            targets: 5,
                            width: '10%'
                        },
                        {
                            targets: 8,
                            width: '5%',
                            className: 'text-center'
                        }
                    ],
                    drawCallback: function () {
                        $('[data-bs-toggle="tooltip"]').tooltip();
                        $('#tbl-article tbody tr td a').each(function (){
                            let id = $(this).attr('id');
                            let ids = id.split('_');
                            if(ids[0]==='image-popup'){
                                let lightbox=GLightbox({selector:"#"+id})
                            }
                        });
                    },
                    rowCallback: function (){

                    }
                });
                const tblArticleInput = $('#tbl-article_filter input');
                tblArticleInput.unbind();
                tblArticleInput.bind('keyup', function (e) {
                    if (e.keyCode === 13){
                        article.search(this.value).draw();
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
                            url : baseUrl + '/master-data/articles/'+id+'/edit',
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
                            url     : baseUrl + '/master-data/articles/'+id,
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
                tableArticle();
            });
        </script>
    @endsection
</x-layout>
