<x-layout breadcrumbs="supplier.create" :select2="true">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Input Data Supplier</h4>
                </div>
                <div class="card-body">
                    <form method="post" id="frm-supplier" {{$attributes->merge(['action'=> route('supplier.store')])}}>
                        @csrf
                        @if($editMode)
                        @method('PATCH')
                        <x-forms.input id="name" name="name" label="Supplier Name" placeholder="Supplier Name" :value="$dataEdit['name']"></x-forms.input>
                        <div class="row">
                            <div class="col-md-12" id="col-type">
                                <x-forms.select id="type" name="type" label="Type" class="form-control-sm select2">
                                    <option disabled selected value>-Please Choose Type-</option>
                                    <option value="RM" {{old('type')||$dataEdit['type']==='RM' ? 'selected':''}}>Raw Material</option>
                                    <option value="AKS" {{old('type')||$dataEdit['type']==='AKS' ? 'selected':''}}>Aksesoris</option>
                                </x-forms.select>
                            </div>
                            <div class="col-md-6 sembunyi" id="col-group">
                                <x-forms.select id="group" name="product_group_id" label="Product Group" class="form-control-sm select2" :list-value="$productGroup" data-column="group" data-value="id" disabled :value="$dataEdit['product_group_id']">Please Choose Product Group</x-forms.select>
                            </div>
                        </div>
                        <x-forms.textarea id="address" name="address" label="Address" placeholder="Supplier Address" margin-bottom="mb-3" :value="$dataEdit['address']"></x-forms.textarea>
                        @else
                        <x-forms.input id="name" name="name" label="Supplier Name" placeholder="Supplier Name"></x-forms.input>
                        <div class="row">
                            <div class="col-md-12" id="col-type">
                                <x-forms.select id="type" name="type" label="Type" class="form-control-sm select2">
                                    <option disabled selected value>-Please Choose Type-</option>
                                    <option value="RM" {{old('type') ? 'selected':''}}>Raw Material</option>
                                    <option value="AKS" {{old('type') ? 'selected':''}}>Aksesoris</option>
                                </x-forms.select>
                            </div>
                            <div class="col-md-6 sembunyi" id="col-group">
                                <x-forms.select id="group" name="product_group_id" label="Product Group" class="form-control-sm select2" :list-value="$productGroup" data-column="group" data-value="id" disabled>Please Choose Product Group</x-forms.select>
                            </div>
                        </div>
                        <x-forms.textarea id="address" name="address" label="Address" placeholder="Supplier Address" margin-bottom="mb-3"></x-forms.textarea>
                        @endif

                        <div class="text-end">
                            <button type="submit" class="btn btn-success data-submit me-1">Save</button>
                            <a href="{!! route('supplier.index') !!}" class="btn btn-outline-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('script')
        <script>
            let name = document.getElementById('name');
            let type = document.getElementById('type');
            let group = document.getElementById('group');
            document.addEventListener('DOMContentLoaded',function (){
                name.focus();
                $('#type').select2({
                    minimumResultsForSearch : 1/0
                });
                $('#group').select2();

                type.onchange = function () {
                    if (this.value ==='RM'){
                        group.setAttribute('disabled','disabled');
                        document.getElementById('col-type').classList.remove('col-md-6');
                        document.getElementById('col-type').classList.add('col-md-12');
                        document.getElementById('col-group').classList.add('sembunyi');
                    }else{
                        document.getElementById('col-type').classList.remove('col-md-12');
                        document.getElementById('col-type').classList.add('col-md-6');
                        document.getElementById('col-group').classList.remove('sembunyi');
                        group.removeAttribute('disabled');
                    }
                };
                @error('product_group_id')
                type.dispatchEvent(new Event('change'));
                @enderror
                @if($editMode)
                type.dispatchEvent(new Event('change'));
                @endif
            });
        </script>
    @endsection
</x-layout>
