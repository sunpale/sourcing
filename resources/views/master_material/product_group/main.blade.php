<x-layout breadcrumbs="product-group" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Product Group</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-group">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-group" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Group Name</th>
                            <th class="text-center">Remarks</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($group as $groups)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$groups->id}}</td>
                                <td>{{$groups->type}}</td>
                                <td class="text-center">{{$groups->kode}}</td>
                                <td>{{$groups->group}}</td>
                                <td>{{$groups->remarks}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$groups->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$groups->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-group">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('master-material.product-group.store')}}" id="frm-group">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <input type="hidden" name="old_kode" id="old_kode" value="{{old('old_kode')??''}}">
                        <x-forms.input label="Code" id="kode" name="kode" placeholder="Code" maxlength="2"></x-forms.input>
                        <x-forms.select label="Type" id="type" name="type">
                            <option disabled selected value>-Select Type</option>
                            <option value="Raw Material" {{old('type')==='Raw Material' ? 'Selected':''}}>Raw Material</option>
                            <option value="Aksesoris" {{old('type')==='Aksesoris' ? 'Selected':''}}>Aksesoris</option>
                        </x-forms.select>
                        <x-forms.input label="Group Name" id="group" name="group" placeholder="Group name"></x-forms.input>
                        <x-forms.textarea label="Remarks" id="remarks" name="remarks" placeholder="Remarks"></x-forms.textarea>
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
        const modalGroup = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-group'));
        const Code = document.querySelector('#kode');
        function tableGroup(){
            const group = $('#tbl-group').DataTable();
            group.on('order.dt search.dt',function (){
                group.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblGroupInput = $('#tbl-group_filter input')
            tblGroupInput.unbind();
            tblGroupInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    group.search(this.value).draw();
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
                        url     : baseUrl + '/master-material/product-group/'+id,
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
                        url         : baseUrl + '/master-material/product-group/'+id+'/edit',
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
                            modalGroup.show();
                            Code.focus();
                            document.getElementById('number').value = response.id;
                            Code.value = response.kode;
                            document.getElementById('group').value = response.group;
                            document.getElementById('type').value = response.type;
                            document.getElementById('remarks').value = response.remarks;
                            document.getElementById('old_kode').value = response.kode;
                            document.getElementById('frm-group').setAttribute('action','/master-material/product-group/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-group').appendChild(methodEl);
                        }
                    })
                }
            });
        }
        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('errors') )
            modalGroup.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-group').setAttribute('action','/master-material/product-group/'+ {{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-group').appendChild(methodEl);
            @endif

            tableGroup();

            document.getElementById('input-group').addEventListener('shown.bs.modal',function (){
                Code.focus();
            })

            Code.oninput = function () {
                this.value = this.value.toUpperCase();
            }
        });
    </script>
    @endsection
</x-layout>
