<x-material-form :form="'RM'" :fabric="$dataFabric->toArray()" :warna="$dataWarna->toArray()" :brand="$dataBrand->toArray()" :pantone="$dataPantone->toArray()" :komposisi="$dataKomposisi->toArray()" :measure="$dataMeasure->toArray()" :edit-mode="true" :data-edit="$dataRm->toArray()" action="{{route('raw-material.update',$dataRm[0]['kode'])}}">

</x-material-form>
