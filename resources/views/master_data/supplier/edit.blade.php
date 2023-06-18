<x-supplier-form :product-group="$group->toArray()" action="{{route('supplier.update',$supplier->id)}}" :edit-mode="true" :data-edit="$supplier->toArray()">
</x-supplier-form>
