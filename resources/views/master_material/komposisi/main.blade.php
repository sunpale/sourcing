<x-layout breadcrumbs="komposisi" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Komposisi</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-komposisi">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-komposisi" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Komposisi</th>
                            <th class="text-center">Keterangan</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dataKomposisi as $komposisi)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$komposisi->id}}</td>
                                <td>{{$komposisi->komposisi}}</td>
                                <td>{{$komposisi->keterangan}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu" class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$komposisi->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$komposisi->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-komposisi">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('master-material.komposisi.store')}}" id="frm-komposisi">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <x-forms.input label="Komposisi" id="komposisi" name="komposisi" placeholder="Komposisi"></x-forms.input>
                        <x-forms.textarea label="Keterangan" id="keterangan" name="keterangan" placeholder="Keterangan" margin-bottom="mb-3"></x-forms.textarea>
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
        const modalKomposisi = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-komposisi'));
        function tableKomposisi(){
            const komposisi = $('#tbl-komposisi').DataTable();
            komposisi.on('order.dt search.dt',function (){
                komposisi.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblKomposisiInput = $('#tbl-komposisi_filter input')
            tblKomposisiInput.unbind();
            tblKomposisiInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    komposisi.search(this.value).draw();
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
                        url     : baseUrl + '/master-material/komposisi/'+id,
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
                        url         : baseUrl + '/master-material/komposisi/'+id+'/edit',
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
                            modalKomposisi.show();
                            document.getElementById('komposisi').focus();
                            document.getElementById('number').value = response.id;
                            document.getElementById('komposisi').value = response.komposisi;
                            document.getElementById('keterangan').value = response.keterangan;
                            document.getElementById('frm-komposisi').setAttribute('action','/master-material/komposisi/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-komposisi').appendChild(methodEl);
                        }
                    })
                }
            });
        }

        document.addEventListener('DOMContentLoaded',function (){
            @if(Session::has('errors'))
            modalKomposisi.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-komposisi').setAttribute('action','/master-material/komposisi/'+{{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-komposisi').appendChild(methodEl);
            @endif

            tableKomposisi();

            document.getElementById('input-komposisi').addEventListener('shown.bs.modal',function (){
                document.getElementById('komposisi').focus();
            });
        });
    </script>
    @endsection
</x-layout>
