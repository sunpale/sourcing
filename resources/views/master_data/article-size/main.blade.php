<x-layout breadcrumbs="size" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Article Size</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-size">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-size" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Size</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($size as $sizes)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$sizes->id}}</td>
                                <td class="text-center">{{$sizes->size}}</td>
                                <td>{{$sizes->remarks}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$sizes->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$sizes->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to add new record -->
    <div class="modal fade" data-bs-backdrop="static" id="input-size">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Entry Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('article-size.store')}}" id="frm-size">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <x-forms.input label="Size" id="size" name="size" placeholder="Article Size"></x-forms.input>
                        <x-forms.textarea label="Remarks" id="remarks" name="remarks" margin-bottom="mb-3" placeholder="Remarks"></x-forms.textarea>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success data-submit me-1">Save</button>
                            <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            const modalSize = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-size'));
            function tableSize(){
                const size = $('#tbl-size').DataTable();
                size.on('order.dt search.dt',function (){
                    size.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                        cell.innerHTML = i+1;
                    } );
                }).draw();
                const tblSizeInput = $('#tbl-size_filter input')
                tblSizeInput.unbind();
                tblSizeInput.bind('keyup', function (e) {
                    if (e.keyCode === 13){
                        size.search(this.value).draw();
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
                            url     : baseUrl + '/master-data/article-size/'+id,
                            method  : "post",
                            data    : {"_token" : token[0].value,"_method":'DELETE'}
                        });
                    }
                }));
            }

            function edit(id){
                Swal.fire({
                    title: "{{config('constants.CONFIRM_TITLE_EDIT')}}",
                    text: "{{config('constants.WARNING_MESSAGE')}}",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Yes"
                }).then(function (result) {
                    if(result.value){
                        $.ajax({
                            url         : baseUrl + '/master-data/article-size/'+id+'/edit',
                            type        : 'get',
                            dataType    : 'json',
                            beforeSend  : function(){
                                FreezeUI();
                            },

                            success     : function (response) {
                                UnFreezeUI();
                                let selector = document.querySelector('.dtr-bs-modal');
                                if(selector !== null){
                                    const modalTable = bootstrap.Modal.getOrCreateInstance(document.querySelector('.dtr-bs-modal'));
                                    if(modalTable) modalTable.hide();
                                }
                                modalSize.show();
                                document.getElementById('size').focus();
                                document.getElementById('number').value = response.id;
                                document.getElementById('size').value = response.size;
                                document.getElementById('remarks').value = response.remarks;
                                document.getElementById('frm-size').setAttribute('action','/master-data/article-size/'+id);
                                let methodEl = document.createElement('input');
                                methodEl.type = 'hidden';
                                methodEl.name = '_method';
                                methodEl.value = 'PATCH';
                                document.getElementById('frm-size').appendChild(methodEl);
                            }
                        })
                    }
                });
            }

            document.addEventListener('DOMContentLoaded',function (){
                tableSize();
                @if(Session::has('errors') )
                modalSize.show();
                @endif

                @if(Session::has('success'))
                notifikasi('success','{{session('success')}}')
                @endif

                document.getElementById('input-size').addEventListener('shown.bs.modal',function (){
                    document.getElementById('size').focus();
                });

                @if(old('number'))
                document.getElementById('frm-size').setAttribute('action','/master-data/article-size/'+{{old('number')}});
                let methodEl = document.createElement('input');
                methodEl.type = 'hidden';
                methodEl.name = '_method';
                methodEl.value = 'PATCH';
                document.getElementById('frm-size').appendChild(methodEl);
                @endif
            });
        </script>
    @endsection
</x-layout>
