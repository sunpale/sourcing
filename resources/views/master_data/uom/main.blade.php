<x-layout breadcrumbs="uom" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Unit of Measure</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-uom">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-uom" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Description</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($measure as $uom)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$uom->id}}</td>
                                <td class="text-center">{{$uom->kode}}</td>
                                <td>{{$uom->measure_name}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$uom->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$uom->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-uom">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('measure.store')}}" id="frm-uom">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <input type="hidden" name="old_kode" id="old_kode" value="{{old('old_kode')??''}}">
                        <x-forms.input label="Code" id="kode" name="kode" maxlength="3" placeholder="Code"></x-forms.input>
                        <x-forms.input label="Description" id="measure_name" name="measure_name" margin-bottom="mb-3" placeholder="Description"></x-forms.input>
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
        const modalUom = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-uom'));
        const kode = document.getElementById('kode');
        function tableUom(){
            const measure = $('#tbl-uom').DataTable();
            measure.on('order.dt search.dt',function (){
                measure.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblUomInput = $('#tbl-uom_filter input')
            tblUomInput.unbind();
            tblUomInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    measure.search(this.value).draw();
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
                        url     : baseUrl + '/master-data/measure/'+id,
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
                        url         : baseUrl + '/master-data/measure/'+id+'/edit',
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
                            modalUom.show();
                            kode.focus();
                            document.getElementById('number').value = response.id;
                            document.getElementById('measure_name').value = response.measure_name;
                            document.getElementById('kode').value = response.kode;
                            document.getElementById('old_kode').value = response.kode;
                            document.getElementById('frm-uom').setAttribute('action','/master-data/measure/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-uom').appendChild(methodEl);
                        }
                    })
                }
            });
        }

        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('errors') )
            modalUom.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-uom').setAttribute('action','/master-data/measure/'+ {{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-uom').appendChild(methodEl);
            @endif

            tableUom();
            document.getElementById('input-uom').addEventListener('shown.bs.modal',function (){
                kode.focus();
            });
            kode.oninput = function (){
                this.value = this.value.toUpperCase();
            }
        });
    </script>
    @endsection
</x-layout>
