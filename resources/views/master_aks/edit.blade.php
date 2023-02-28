<x-material-form :form="'AKS'" :group="$dataGroup->toArray()" :warna="$dataWarna->toArray()" :brand="$dataBrand->toArray()" :measure="$dataMeasure->toArray()" :warna-aks="$dataWarnaAks->toArray()" :edit-mode="true" :data-edit="$dataAks->toArray()" action="{{route('aksesoris.update',$dataAks[0]['kode'])}}">

</x-material-form>
