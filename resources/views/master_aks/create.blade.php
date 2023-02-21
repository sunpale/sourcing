<x-material-form :form="'AKS'" :group="$dataGroup->toArray()" :warna="$dataWarna->toArray()" :brand="$dataBrand->toArray()" :measure="$dataMeasure->toArray()" :warna-aks="$dataWarnaAks->toArray()" action="{{route('aksesoris.store')}}" enctype="multipart/form-data">

</x-material-form>
