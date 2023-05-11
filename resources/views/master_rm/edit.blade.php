<x-material-form :form="'RM'" :fabric="$fabric->toArray()" :warna="$warna->toArray()" :brand="$brand->toArray()" :pantone="$pantone->toArray()" :komposisi="$komposisi->toArray()" :measure="$measure->toArray()" :edit-mode="true" :data-edit="$material->toArray()" action="{{route('master-rm.raw-material.update',$material[0]['id'])}}">

</x-material-form>
