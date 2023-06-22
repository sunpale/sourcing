<x-material-form :form="'AKS'" :group="$group->toArray()" :warna="$warna->toArray()" :brand="$brand->toArray()" :measure="$measure->toArray()" :warna-aks="$warnaAks->toArray()" :edit-mode="true" :data-edit="$aks->toArray()" action="{{route('master-material.aksesoris.update',$aks[0]['id'])}}">

</x-material-form>
