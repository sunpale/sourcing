<x-layout breadcrumbs="supplier.create" :select2="true" :cleavejs="true">
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
                                <div class="col-md-6" id="col-type">
                                    <x-forms.select id="type" name="type" label="Type" class="form-control-sm select2">
                                        <option disabled selected value>-Please Choose Type-</option>
                                        <option value="RM" {{old('type')||$dataEdit['type']==='RM' ? 'selected':''}}>Raw Material</option>
                                        <option value="AKS" {{old('type')||$dataEdit['type']==='AKS' ? 'selected':''}}>Aksesoris</option>
                                    </x-forms.select>
                                </div>
                                <div class="col-md-6" id="col-group">
                                    <x-forms.select id="group" name="product_group_id" label="Product Group" class="form-control-sm select2" :list-value="$productGroup" :value="$dataEdit['product_group_id']">Please Choose Product Group</x-forms.select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-forms.input id="pic" name="pic" label="PIC" placeholder="PIC" :value="$dataEdit['pic']"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="country" name="country" label="Country" placeholder="Country" :value="$dataEdit['country']"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="phone" name="phone" label="Phone No / HP" placeholder="Phone" type="tel" :value="$dataEdit['phone']"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="email" name="email" label="Email" placeholder="Email" :value="$dataEdit['email']"></x-forms.input>
                                </div>
                            </div>
                            <x-forms.textarea id="address" name="address" label="Address" placeholder="Supplier Address" margin-bottom="mb-3" :value="$dataEdit['address']"></x-forms.textarea>
                        @else
                            <x-forms.input id="name" name="name" label="Supplier Name" placeholder="Supplier Name"></x-forms.input>
                            <div class="row">
                                <div class="col-md-6" id="col-type">
                                    <x-forms.select id="type" name="type" label="Type" class="form-select-sm select2">
                                        <option disabled selected value>-Please Choose Type-</option>
                                        <option value="RM" {{old('type') ? 'selected':''}}>Raw Material</option>
                                        <option value="AKS" {{old('type') ? 'selected':''}}>Aksesoris</option>
                                    </x-forms.select>
                                </div>
                                <div class="col-md-6" id="col-group">
                                    <x-forms.select id="group" name="product_group_id" label="Product Group" class="form-select-sm select2" :list-value="$productGroup">Select Product Group</x-forms.select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-forms.input id="pic" name="pic" label="PIC" placeholder="PIC"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="country" name="country" label="Country" placeholder="Country"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="phone" name="phone" label="Phone No / HP" placeholder="Phone" type="tel"></x-forms.input>
                                </div>
                                <div class="col-md-6">
                                    <x-forms.input id="email" name="email" label="Email" placeholder="Email"></x-forms.input>
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
            let cleaveBlocks;
            document.addEventListener('DOMContentLoaded',function (){
                name.focus();
                $('#type').select2({
                    minimumResultsForSearch : 1/0
                });
                $('#group').select2();

                const phone = new Cleave('#phone',{
                    phone : true,
                    phoneRegionCode : 'ID'
                });

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
