<x-layout breadcrumbs="fabric" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Jenis Fabric</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-fabric">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-fabric" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataFabric as $fabric)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$fabric->id}}</td>
                                <td>{{$fabric->kode}}</td>
                                <td>{{$fabric->description}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$fabric['id']}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$fabric['id']}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-fabric">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('master-material.fabric.store')}}" id="frm-fabric">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <input type="hidden" name="old_kode" id="old_kode" value="{{old('old_kode')??''}}">
                        <div class="col-md-3">
                            <x-forms.input label="Prefix Code" id="prefix" name="prefix" placeholder="Prefix Code" maxlength="1"></x-forms.input>
                        </div>
                        <x-forms.input label="Code" id="kode" name="kode" placeholder="Code" readonly></x-forms.input>
                        <x-forms.input label="Description" id="description" name="description" placeholder="Description" margin-bottom="mb-3"></x-forms.input>
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
        const modalFabric = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-fabric'));
        function tableFabric(){
            const fabric = $('#tbl-fabric').DataTable();
            fabric.on('order.dt search.dt',function (){
                fabric.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblFabricInput = $('#tbl-fabric_filter input')
            tblFabricInput.unbind();
            tblFabricInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    fabric.search(this.value).draw();
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
                        url     : baseUrl + '/master-material/fabric/'+id,
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
                        url         : baseUrl + '/master-material/fabric/'+id+'/edit',
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
                            modalFabric.show();
                            document.getElementById('prefix').focus();
                            document.getElementById('prefix').value = response.kode.substring(0,1);
                            document.getElementById('number').value = response.id;
                            document.getElementById('description').value = response.description;
                            document.getElementById('kode').value = response.kode;
                            document.getElementById('old_kode').value = response.kode;
                            document.getElementById('frm-fabric').setAttribute('action','/master-material/fabric/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-fabric').appendChild(methodEl);
                        }
                    })
                }
            });
        }

        document.addEventListener('DOMContentLoaded',function (){
            const description = document.getElementById('description');
            const prefix = document.getElementById('prefix');
            const fabric = document.getElementById('frm-fabric');
            @if(Session::has('errors') )
            modalFabric.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-fabric').setAttribute('action','/master-material/fabric/'+ {{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-fabric').appendChild(methodEl);
            @endif

            tableFabric();
            document.getElementById('input-fabric').addEventListener('shown.bs.modal',function (){
               prefix.focus();
            });

            prefix.oninput = function (){
                this.value = this.value.toUpperCase();
                if (this.value === document.getElementById('old_kode').value.substring(0,1)){
                    document.getElementById('kode').value = document.getElementById('old_kode').value;
                }else {
                    $.ajax({
                        url         : '{{route('master-material.fabric.generate-code')}}',
                        type        : 'get',
                        data        : 'prefix=' + this.value,
                        dataType    : 'json',
                        success     : function (response) {
                            document.getElementById('kode').value = response.code;
                            description.value = '';
                            description.focus();
                        }
                    });
                }
            }

            fabric.onsubmit = function (event) {
                event.preventDefault();
                if (description.value.charAt(0).localeCompare(prefix.value,undefined,{sensitivity:'accent'})!==0){
                    Swal.fire({
                        title: "Nama awal deskripsi harus sama dengan prefix code",
                        icon: "error"
                    })
                }else {
                    fabric.submit();
                }
            }
        })
    </script>
    @endsection
</x-layout>
