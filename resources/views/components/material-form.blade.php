<x-layout :breadcrumbs="$form==='RM'? 'material.create':'aksesoris.create'" :select2="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{$form==='RM'?'Input Data Raw Material':'Input Data Akesoris'}}</h4>
                    <div class="flex-shrink-0">
                        <span class="text-end ml-auto fw-bold">Kode : </span>
                        <span class="text-end kode-text mx-2 fw-bold">{{old('number') ? old('number'): config('constants.'.$form).'000 0000 0000'}}</span>
                    </div>
                </div>
                <div class="card-body">
                    <form method="POST" id="frm-<?=$form?>" {{$attributes->merge(['action'=> route('raw-material.store')])}} enctype="multipart/form-data">
                        @csrf
                        @if($editMode)
                        @method('PATCH')
                        @endif
                        <input type="hidden" id="number" name="number">
                        <div class="row">
                            @if($form==='RM')
                            <div class="col-md-4">
                                <x-forms.select id="fabric" name="fabric_id" label="Fabric Code" class="form-select-sm select2 select-default" :list-value="$fabric" :value="$editMode ? $dataEdit[0]['fabric_id']:''">Select Fabric</x-forms.select>
                            </div>
                            <div class="col-md-4">
                                <x-forms.select id="color" name="color_id" label="Color Code" class="form-select-sm select2 select-default" :list-value="$warna" :value="$editMode ? $dataEdit[0]['color_id']:''">Select Color</x-forms.select>
                            </div>
                            @else
                            <div class="col-md-4">
                                <x-forms.select id="group" name="product_group_id" label="Product Group" class="form-select-sm select2 select-default" :list-value="$group" :value="$editMode ? $dataEdit[0]['product_group_id']:''">Select Product Group</x-forms.select>
                            </div>
                            <div class="col-md-4">
                                <x-forms.select id="color_aks" name="color_aks_id" label="Color Accessories Code" class="form-select-sm select2 select-default" :list-value="$warnaAks" :value="$editMode ? $dataEdit[0]['color_aks_id']:''">Select Color AKS</x-forms.select>
                            </div>
                            @endif

                            <div class="col-md-4">
                                <x-forms.select id="brand" name="brand_id" label="Brand Code" class="form-select-sm select2 select-default" :list-value="$brand" :value="$editMode ? $dataEdit[0]['brand_id']:''">Select Brand</x-forms.select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label" for="supplier">Supplier</label>
                                <select class="form-select form-select-sm select2 @error('supplier_id') is-invalid @enderror" id="supplier" name="supplier_id">
                                    <option disabled selected value>Select Supplier</option>
                                </select>
                                @error('supplier_id')
                                <div class="invalid-feedback">
                                    {{$errors->messages()['supplier_id'][0]}}
                                </div>
                                @enderror
                            </div>
                            @if($form==='RM')
                            <div class="col-md-6">
                                <x-forms.select id="pantone" name="pantone_id" label="Pantone Code" class="form-select-sm select2 select-default" :list-value="$pantone" :value="$editMode ? $dataEdit[0]['pantone_id']:''">Select Pantone Color</x-forms.select>
                            </div>
                            <div class="col-md-6">
                                <x-forms.select id="komposisi" name="komposisi_id" label="Composition" class="form-select-sm select2 select-default" :list-value="$komposisi" :value="$editMode ? $dataEdit[0]['komposisi_id']:''">Select Composition</x-forms.select>
                            </div>
                            @endif
                            <x-forms.input id="item_name" name="item_name" label="Item Name" placeholder="Item Name" :value="$editMode ? $dataEdit[0]['item_name']:''"></x-forms.input>
                            <x-forms.textarea id="item_desc" name="item_desc" label="Item Description" placeholder="Item Description" margin-bottom="mb-4" :value="$editMode ? $dataEdit[0]['item_desc']:''"></x-forms.textarea>

                            @if($form==='RM')
                            <div class="col-md-4">
                                <x-forms.input id="gramasi" name="gramasi" label="Gramasi (GSM)" placeholder="Gramasi" :value="$editMode ? $dataEdit[0]['gramasi']:''"></x-forms.input>
                            </div>
                            <div class="col md-4">
                                <x-forms.input id="lebar" name="lebar" label="Lebar (Inch)" placeholder="Lebar" :value="$editMode ? $dataEdit[0]['lebar']:''"></x-forms.input>
                            </div>
                            <div class="col-md-4">
                                <x-forms.input type="number" id="susut" name="susut" label="Susut (%)" placeholder="Susut" :value="$editMode ? $dataEdit[0]['susut']:''"></x-forms.input>
                            </div>
                            <div class="col-md-6">
                                <x-forms.input id="finish" name="finish" label="Finish" placeholder="Finish" :value="$editMode ? $dataEdit[0]['finish']:''"></x-forms.input>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <x-forms.input id="lead_time" type="number" name="lead_time" label="Production Lead Time" placeholder="Lead Time" :value="$editMode ? $dataEdit[0]['lead_time']:''"></x-forms.input>
                            </div>
                            @if($form==='RM')
                            <div class="col-md-6">
                                <x-forms.input id="moq" name="moq" type="number" label="MOQ / Greige" placeholder="MOQ / Greige" :value="$editMode ? $dataEdit[0]['moq']:''"></x-forms.input>
                            </div>
                            <div class="col-md-6">
                                <x-forms.input id="moq_color" type="number" name="moq_color" label="MOQ / Col" placeholder="MOQ / Col" :value="$editMode ? $dataEdit[0]['moq_color']:''"></x-forms.input>
                            </div>
                            @else
                            <div class="col-md-6">
                                <x-forms.input id="moq" name="moq" type="number" label="MOQ" placeholder="MOQ" :value="$editMode ? $dataEdit[0]['moq']:''"></x-forms.input>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <x-forms.select id="measure" name="measure_id" label="Unit of Measure" class="form-select-sm select2 select-default" :list-value="$measure" :value="$editMode ? $dataEdit[0]['measure_id']:''">Select UOM</x-forms.select>
                            </div>
                            <div class="col-md-6">
                                <x-forms.select id="ppn" name="ppn" label="PPN" class="form-select-sm select2 select-default">
                                    <option disabled selected value>-Select PPN-</option>
                                    @if($editMode)
                                    <option value="1" {{old('ppn')==1||$dataEdit[0]['ppn']==1 ? 'selected':''}}>PPN</option>
                                    <option value="2" {{old('ppn')==2||$dataEdit[0]['ppn']==2 ? 'selected':''}}>Non PPN</option>
                                    @else
                                    <option value="1" {{old('ppn')==1 ? 'selected':''}}>PPN</option>
                                    <option value="2" {{old('ppn')==2 ? 'selected':''}}>Non PPN</option>
                                    @endif
                                </x-forms.select>
                            </div>
                            @if($form==='RM')
                            <x-forms.input type="file" name="img_file" id="img_file" label="Photo" class="form-control-sm"></x-forms.input>
                            @endif
                            @if($form==='AKS')
                            <div class="col-md-6">
                                <x-forms.select id="color" name="color_id" label="Color MD" class="form-select-sm select2 select-default" :list-value="$warna" :value="$editMode ? $dataEdit[0]['color_id']:''">Select Color MD</x-forms.select>
                            </div>
                            <div class="col-md-6">
                                <x-forms.input type="file" name="img_file" id="img_file" label="Photo" class="form-control-sm"></x-forms.input>
                            </div>
                            @endif
                            <div class="text-end mt-5">
                                <button type="submit" class="btn btn-success data-submit me-1">Save</button>
                                <a href="{!! $form==='RM' ? route('raw-material.index') : route('aksesoris.index') !!}" class="btn btn-outline-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        let formLoad = false;
        const brandEl = document.querySelector('#brand');
        const supplierEl = document.querySelector('#supplier');
        @if($form==='RM')
        const fabricEl = document.querySelector('#fabric');
        const colorEl = document.querySelector('#color');
        const pantoneEl = document.querySelector('#pantone');
        const komposisiEL = document.querySelector('#komposisi');
        @else
        const groupEl = document.querySelector('#group');
        const colorAksEl = document.querySelector('#color_aks');
        @endif

        function generateCode(){
            if (!formLoad){
                let brand = brandEl.options[brandEl.selectedIndex].textContent.split(' - ');
                /*let supplier = supplierEl.options[supplierEl.selectedIndex].textContent.split(' - ');*/
                let prefixCode = '';
                @if($form==='RM')
                let fabric = fabricEl.options[fabricEl.selectedIndex].textContent.split(' - ');
                let color = colorEl.options[colorEl.selectedIndex].textContent.split(' - ');
                prefixCode = '{{config('constants.'.$form)}}'+fabric[0]+color[0]+brand[0];
                @else
                let group = groupEl.options[groupEl.selectedIndex].textContent.split(' - ');
                let colorAks = colorAksEl.options[colorAksEl.selectedIndex].textContent.split(' - ');
                prefixCode = '{{config('constants.'.$form)}}'+group[0]+colorAks[0]+brand[0];
                @endif
                $.ajax({
                    url         : '{{route('raw-material.generate-code')}}',
                    type        : 'get',
                    data        : 'prefixCode='+prefixCode,
                    dataType    : 'json',
                    success     : function (response) {
                        document.getElementById('number').value = response.kode;
                        document.querySelector('.kode-text').innerHTML = response.kode;
                    }
                });
            }

        }

        function validateKode(){
            let kode = document.querySelector('.kode-text').innerHTML;
            @if($form==='RM')
            if (kode!=='1000 0000 0000'){
                generateCode();
            }
            @else
            if (kode!=='2000 0000 0000'){
                generateCode();
            }
            @endif

        }

        function getSupplier(){
            $('#supplier').select2({
                ajax : {
                    url         : '{{route('suppliers.data-supplier')}}',
                    dataType    : 'json',
                    type        : 'get',
                    delay       : 250,
                    data        : function (params) {
                        return {
                            search      : params.term,
                            page        : params.page || 1,
                            type        : '{{$form}}'
                        }
                    },
                    processResults : function (data, params) {
                        params.page = params.page ||1;
                        return {
                            results     : data.items,
                            pagination  : {
                                more    : (params.page * 25) < data.total_count
                            }
                        }
                    },
                    cache : true
                },
                /*minimumInputLength : 1,*/
                placeholder : "Supplier",
                templateResult : format,
                templateSelection :formatSelection,
                containerCssClass: "wrap"
            });
        }

        const compressImage = async (file, { quality = 1, type = file.type }) => {
            // Get as image data
            const imageBitmap = await createImageBitmap(file);

            // Draw to canvas
            const canvas = document.createElement('canvas');
            canvas.width = imageBitmap.width;
            canvas.height = imageBitmap.height;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(imageBitmap, 0, 0);

            // Turn into Blob
            const blob = await new Promise((resolve) =>
                canvas.toBlob(resolve, type, quality)
            );

            // Turn Blob into File
            return new File([blob], file.name, {
                type: blob.type,
            });
        };

        document.addEventListener('DOMContentLoaded',function (){
            $('.select-default').select2();
            getSupplier();

            @if($form==='RM')
            fabricEl.onchange = function (){
                validateKode();
            }

            colorEl.onchange = function (){
                validateKode();
            }
            @else
            groupEl.onchange = function (){
                validateKode();
            }
            colorAksEl.onchange = function () {
                validateKode();
            }
            @endif

            brandEl.onchange = function (){
                generateCode();
            }

            // Get the selected file from the file input
            const input = document.querySelector('#img_file');
            input.addEventListener('change', async (e) => {
                // Get the files
                const { files } = e.target;

                // No files selected
                if (!files.length) return;

                // We'll store the files in this data transfer object
                const dataTransfer = new DataTransfer();

                // For every file in the files list
                for (const file of files) {
                    // We don't have to compress files that aren't images
                    if (!file.type.startsWith('image')) {
                        // Ignore this file, but do add it to our result
                        dataTransfer.items.add(file);
                        continue;
                    }

                    // We compress the file by 50%
                    const compressedFile = await compressImage(file, {
                        quality: 0.5,
                        type: 'image/jpeg',
                    });

                    // Save back the compressed file instead of the original file
                    dataTransfer.items.add(compressedFile);
                }

                // Set value of the file input to our new files list
                e.target.files = dataTransfer.files;
            });

            @if($editMode)
            formLoad = true;
            const optionSupplier=new Option('{{$dataEdit[0]['supplier']['kode'].' - '.$dataEdit[0]['supplier']['name']}}','{{$dataEdit[0]['supplier_id']}}',true,true);
            document.getElementById('supplier').appendChild(optionSupplier);
            document.getElementById('supplier').dispatchEvent(new Event('change'));
            document.getElementById('number').value = '{{$dataEdit[0]['kode']}}';
            document.querySelector('.kode-text').innerHTML = '{{$dataEdit[0]['kode']}}';
            formLoad=false;
            @endif
        })
    </script>
    @endsection
</x-layout>
