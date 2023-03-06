<x-layout breadcrumbs="pantone" datatable=true toastify=true sweetalert=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Warna Pantone</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-pantone">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-pantone" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Pantone Code</th>
                            <th class="text-center">Pantone Name</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataPantone as $pantone)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$pantone->id}}</td>
                                <td class="text-center">{{$pantone->kode}}</td>
                                <td>{{$pantone->pantone}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$pantone->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$pantone->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-pantone">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('master-warna.pantone.store')}}" id="frm-pantone">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <input type="hidden" name="old_kode" id="old_kode" value="{{old('old_kode')??''}}">
                        <x-forms.input label="Code" id="kode" name="kode" maxlength="12" placeholder="Pantone Code"></x-forms.input>
                        <x-forms.input label="Pantone" id="pantone" name="pantone" margin-bottom="mb-3" placeholder="Pantone Name"></x-forms.input>
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
        const modalPantone = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-pantone'));
        const kode = document.getElementById('kode');
        function tablePantone(){
            const pantone = $('#tbl-pantone').DataTable();
            pantone.on('order.dt search.dt',function (){
                pantone.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblPantoneInput = $('#tbl-pantone_filter input')
            tblPantoneInput.unbind();
            tblPantoneInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    pantone.search(this.value).draw();
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
                        url     : baseUrl + '/master-warna/pantone/'+id,
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
                        url         : baseUrl + '/master-warna/pantone/'+id+'/edit',
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
                            modalPantone.show();
                            kode.focus();
                            document.getElementById('number').value = response.id;
                            document.getElementById('pantone').value = response.pantone;
                            document.getElementById('kode').value = response.kode;
                            document.getElementById('old_kode').value = response.kode;
                            document.getElementById('frm-pantone').setAttribute('action','/master-warna/pantone/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-pantone').appendChild(methodEl);
                        }
                    })
                }
            });
        }
        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('errors') )
            modalPantone.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-pantone').setAttribute('action','/master-warna/pantone/'+{{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-pantone').appendChild(methodEl);
            @endif

            tablePantone();
            document.getElementById('input-pantone').addEventListener('shown.bs.modal',function (){
                document.getElementById('kode').focus();
            });
        });
    </script>
    @endsection
</x-layout>
