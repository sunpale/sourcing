<x-supplier-form :product-group="$dataGroup->toArray()" action="{{route('supplier.update',$supplier->id)}}" :edit-mode="true" :data-edit="$supplier->toArray()">
</x-supplier-form>
