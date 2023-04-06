<x-layout breadcrumbs="article.create" :select2="true" :cleavejs="true">
    <form method="post" id="frm-article" action="{{ route('bom.articles.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Input Data Article</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="hidden" name="number" id="number">
                                <x-forms.input id="kode" name="kode" label="Article Code" placeholder="Article Code"></x-forms.input>
                            </div>
                            <div class="col-lg-6">
                                <x-forms.input id="modul" name="modul" label="Modul" placeholder="Modul"></x-forms.input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <x-forms.select id="brand" name="brand_id" label="Brand" class="form-select-sm select2" :list-value="$brand->toArray()">Select Brand</x-forms.select>
                            </div>
                            <div class="col-lg-6">
                                <x-forms.select id="color" name="pantone_id" label="Color" class="form-select-sm select2" :list-value="$pantone->toArray()">Select Pantone Color</x-forms.select>
                            </div>
                        </div>
                        <x-forms.input name="name" id="name" label="Article Name" placeholder="Article Name"></x-forms.input>
                        <x-forms.input name="designer" id="designer" label="Designer" placeholder="Designer"></x-forms.input>
                        <x-forms.input type="file" accept="image/png,image/jpeg" name="img_file" id="img_file" label="Upload Photo" margin-bottom="mb-4"></x-forms.input>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success data-submit me-1">Save</button>
                            <a href="{!! route('bom.articles.index') !!}" class="btn btn-outline-danger">Cancel</a>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Article Image</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4 mt-2">
                            <img class="img-thumbnail h-75 w-75 img-preview" src="{{asset('src/images/default.png')}}" height="12px">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @section('script')
        <script>
            const compressImage = async (file, { quality = 1, type = file.type }) => {
                // Get as image data
                const imageBitmap = await createImageBitmap(file);

                // Draw to canvas
                const canvas = document.createElement('canvas');
                canvas.width = imageBitmap.width;
                canvas.height = imageBitmap.height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(imageBitmap, 0, 0);

                // Turn into Blob
                const blob = await new Promise((resolve) =>
                    canvas.toBlob(resolve, type, quality)
                );

                // Turn Blob into File
                return new File([blob], file.name, {
                    type: blob.type,
                });
            };

            document.addEventListener('DOMContentLoaded',function (){
                $('select').select2();
                var kode = new Cleave('#kode', {
                    blocks: [1,6,2],
                    delimiter : '.',
                    uppercase : true
                });
                document.querySelector("#img_file").addEventListener("change", function () {
                    let image = document.querySelector('#img_file');
                    let preview = document.querySelector('.img-preview');

                    let fileImage = new FileReader();
                    fileImage.readAsDataURL(image.files[0]);
                    fileImage.onload = function (e) {
                        preview.src = e.target.result;
                    }
                });

                // Get the selected file from the file input
                const input = document.querySelector('#img_file');
                input.addEventListener('change', async (e) => {
                    // Get the files
                    const { files } = e.target;

                    // No files selected
                    if (!files.length) return;

                    // We'll store the files in this data transfer object
                    const dataTransfer = new DataTransfer();

                    // For every file in the files list
                    for (const file of files) {
                        // We don't have to compress files that aren't images
                        if (!file.type.startsWith('image')) {
                            // Ignore this file, but do add it to our result
                            dataTransfer.items.add(file);
                            continue;
                        }

                        // We compress the file by 50%
                        const compressedFile = await compressImage(file, {
                            quality: 0.5,
                            type: 'image/jpeg',
                        });

                        // Save back the compressed file instead of the original file
                        dataTransfer.items.add(compressedFile);
                    }

                    // Set value of the file input to our new files list
                    e.target.files = dataTransfer.files;
                });
            });
        </script>
    @endsection
</x-layout>
