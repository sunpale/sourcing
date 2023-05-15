<x-material-form :form="'AKS'" :group="$group->toArray()" :warna="$warnaAks->toArray()" :brand="$brand->toArray()" :measure="$measure->toArray()" :warna-aks="$warnaAks->toArray()" :edit-mode="true" :data-edit="$aks->toArray()" action="{{route('master-aks.aksesoris.update',$aks[0]['id'])}}">

</x-material-form>
