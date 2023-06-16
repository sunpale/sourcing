<x-layout breadcrumbs="brands" datatable=true sweetalert=true toastify=true freeze-ui=true>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Brand</h4>
                    <div class="flex-shrink-0">
                        <a href="#" class="btn btn-sm btn-info waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#input-brand">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="tbl-brand" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Brand</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                            <tr>
                                <td></td>
                                <td></td>
                                <td>{{$brand->id}}</td>
                                <td class="text-center">{{$brand->kode}}</td>
                                <td>{{$brand->brand}}</td>
                                <td>
                                    <div class="dropdown d-inline-block">
                                        <button class="btn btn-soft-primary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-equalizer-fill align-middle"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Edit Data" onclick="edit('{{$brand->id}}')" class="dropdown-item"><i class="ri-edit-fill"></i> Edit Data
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" data-bs-toggle="tooltip" data-placement="auto" title="Hapus Data" class="dropdown-item" onclick="hapus('{{$brand->id}}')"><i class="ri-close-circle-fill"></i> Hapus Data</a>
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
    <div class="modal fade" data-bs-backdrop="static" id="input-brand">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Data Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('brands.store')}}" id="frm-brand">
                        @csrf
                        <input type="hidden" name="number" id="number" value="{{old('number')??''}}">
                        <input type="hidden" name="old_kode" id="old_kode" value="{{old('old_kode')??''}}">
                        <div class="col-md-3">
                            <x-forms.input label="Kode" id="kode" name="kode" placeholder="Kode" maxlength="2" minlenght="2"></x-forms.input>
                        </div>
                        <x-forms.input label="Brand" id="brand" name="brand" margin-bottom="mb-3" placeholder="Nama Brands"></x-forms.input>
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
        const modalBrand = bootstrap.Modal.getOrCreateInstance(document.getElementById('input-brand'));
        function tableBrand(){
            const brand = $('#tbl-brand').DataTable();
            brand.on('order.dt search.dt',function (){
                brand.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).draw();
            const tblBrandInput = $('#tbl-brand_filter input')
            tblBrandInput.unbind();
            tblBrandInput.bind('keyup', function (e) {
                if (e.keyCode === 13){
                    brand.search(this.value).draw();
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
                        url     : baseUrl + '/master-data/brands/'+id,
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
                        url         : baseUrl + '/master-data/brands/'+id+'/edit',
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
                            modalBrand.show();
                            document.getElementById('kode').focus();
                            document.getElementById('number').value = response.id;
                            document.getElementById('brand').value = response.brand;
                            document.getElementById('kode').value = response.kode;
                            document.getElementById('old_kode').value = response.kode;
                            document.getElementById('frm-brand').setAttribute('action','/master-data/brands/'+id);
                            let methodEl = document.createElement('input');
                            methodEl.type = 'hidden';
                            methodEl.name = '_method';
                            methodEl.value = 'PATCH';
                            document.getElementById('frm-brand').appendChild(methodEl);
                        }
                    })
                }
            });
        }
        document.addEventListener('DOMContentLoaded',function (){
            const kode = document.getElementById('kode');
            @if(Session::has('errors') )
            modalBrand.show();
            @endif

            @if(Session::has('success'))
            notifikasi('success','{{session('success')}}')
            @endif

            @if(old('number'))
            document.getElementById('frm-brand').setAttribute('action','/master-data/brands/'+{{old('number')}});
            let methodEl = document.createElement('input');
            methodEl.type = 'hidden';
            methodEl.name = '_method';
            methodEl.value = 'PATCH';
            document.getElementById('frm-brand').appendChild(methodEl);
            @endif

            tableBrand();
            document.getElementById('input-brand').addEventListener('shown.bs.modal',function (){
                kode.focus();
            });
            kode.onchange = function (){
                if(this.value.length < 2){
                    this.value = 0+this.value;
                }
            }
        });
    </script>
    @endsection
</x-layout>
