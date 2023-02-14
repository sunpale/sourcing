<x-layout breadcrumbs="warna-aks" :datatable="true" :sweetalert="true" :toastify="true" :freeze-ui="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Warna Aksesoris</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-warna-aks">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-warna-aks" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataWarna as $warna)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$warna->id}}</td>
                                <td class="text-center">{{$warna->kode}}</td>
                                <td>{{$warna->color_desc}}</td>
                                <td>{{$warna->remarks}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$warna['id']}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$warna->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-warna-aks">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('warna-aksesoris.store')}}" id="frm-warna-aks">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <x-forms.input label="Color Name" id="color_desc" name="color_desc" placeholder="Color Name"></x-forms.input>
                        <x-forms.textarea label="Remarks" id="remarks" name="remarks" placeholder="Remarks" margin-bottom="mb-3"></x-forms.textarea>
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
        const modalWarnaAks = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-warna-aks'));
        function tableWarnaAks(){
            const warnaAks = $('#tbl-warna-aks').DataTable();
            warnaAks.on('order.dt search.dt',function (){
                warnaAks.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblFabricInput = $('#tbl-warna-aks_filter input')
            tblFabricInput.unbind();
            tblFabricInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    warnaAks.search(this.value).draw();
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
                        url     : baseUrl + '/master-warna/warna-aksesoris/'+id,
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
                        url         : baseUrl + '/master-warna/warna-aksesoris/'+id+'/edit',
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
                            modalWarnaAks.show();
                            document.getElementById('color_desc').focus();
                            document.getElementById('number').value = response.id;
                            document.getElementById('color_desc').value = response.color_desc;
                            document.getElementById('remarks').value = response.remarks;
                            document.getElementById('frm-warna-aks').setAttribute('action','/master-warna/warna-aksesoris/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-warna-aks').appendChild(methodEl);
                        }
                    })
                }
            });
        }
        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('errors') )
            modalWarnaAks.show();
            @endif
            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-warna-aks').setAttribute('action','/master-warna/warna-aksesoris/'+ {{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-warna-aks').appendChild(methodEl);
            @endif

            tableWarnaAks();
            document.getElementById('input-warna-aks').addEventListener('shown.bs.modal',function (){
                document.getElementById('color_desc').focus();
            });
        });
    </script>
    @endsection
</x-layout>
