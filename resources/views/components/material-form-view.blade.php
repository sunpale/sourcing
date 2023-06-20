<x-layout :breadcrumbs="$form==='RM'? 'material.view':'aksesoris.view'" :glightbox="true">
    <div class="row">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="bg-soft-primary position-relative">
                        <div class="card-body p-5">
                            <div class="text-center">
                                <h3>{{$form==='RM'?'Raw Material Detail':'Aksesoris Detail'}}</h3>
                                <p class="mb-0 text-muted">Last update: <span class="fw-bold">{{$material[0]['updated_at']}}</span> by <span class="fw-bold">{{$material[0]['user']['username']}}</span></p>
                            </div>
                        </div>
                        <div class="shape">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="1440" height="60" preserveAspectRatio="none" viewBox="0 0 1440 60">
                                <g mask="url(&quot;#SvgjsMask1001&quot;)" fill="none">
                                    <path d="M 0,4 C 144,13 432,48 720,49 C 1008,50 1296,17 1440,9L1440 60L0 60z" style="fill: var(--vz-card-bg-custom);"></path>
                                </g>
                                <defs>
                                    <mask id="SvgjsMask1001">
                                        <rect width="1440" height="60" fill="#ffffff"></rect>
                                    </mask>
                                </defs>
                            </svg>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success icon-dual-success icon-xs"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            <div class="flex-grow-1">
                                <h5>Material Specification</h5>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-borderless table-striped">
                                <tr>
                                    <td class="fw-bold">Kode</td>
                                    <td>{{$material[0]['kode']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Item Name</td>
                                    <td>{{$material[0]['item_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Item Description</td>
                                    <td>{{$material[0]['item_desc']}}</td>
                                </tr>
                                @if($form==='RM')
                                <tr>
                                    <td class="fw-bold">Gramasi</td>
                                    <td>{{$material[0]['gramasi']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Lebar</td>
                                    <td>{{$material[0]['lebar']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Susut</td>
                                    <td>{{$material[0]['susut']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Finish</td>
                                    <td>{{$material[0]['finish']}}</td>
                                </tr>
                                @else
                                    <tr>
                                        <td class="fw-bold">Product Group</td>
                                        <td>{{$material[0]['product_group']['group']}}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Accessories Color</td>
                                        <td>{{$material[0]['color_aks']['color_desc']}}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="fw-bold">UOM</td>
                                    <td>{{$material[0]['measure']['measure_name']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Unit Price</td>
                                    <td>{{number_format($material[0]['unit_price'],'0',',','.')}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Image</td>
                                    <td>
                                        @if($form==='RM')
                                        <a class="image-popup" href="{{strlen($imageUrl) > 0 ? $imageUrl : asset('src/images/default.png')}}"><img src="{{strlen($imageUrl) > 0 ? $imageUrl : asset('src/images/default.png')}}" class="img-fluid img-thumbnail w-25"></a>
                                        @else
                                        <a class="image-popup" href="{{strlen($imageUrl) > 0 ? $imageUrl : asset('src/images/default.png')}}"><img src="{{strlen($imageUrl) > 0 ? $imageUrl : asset('src/images/default.png')}}" class="img-fluid img-thumbnail w-25"></a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3 mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle text-success icon-dual-success icon-xs"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                            </div>
                            <div class="flex-grow-1">
                                <h5>Additional Info</h5>
                            </div>
                        </div>
                        <div class="table-responsive mb-3">
                            <table class="table table-borderless table-striped">
                                @if($form==='RM')
                                <tr>
                                    <td class="fw-bold">Fabric</td>
                                    <td>{{$material[0]['fabric']['description']}}</td>
                                    <td class="fw-bold">Color MD</td>
                                    <td>{{$material[0]['color']['description']}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="fw-bold">Brand</td>
                                    <td>{{$material[0]['brand']['brand']}}</td>
                                    <td class="fw-bold">Supplier</td>
                                    <td>{{$material[0]['supplier']['name']}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Lead Time</td>
                                    <td>{{$material[0]['lead_time']}}</td>
                                    @if($form==='RM')
                                    <td class="fw-bold">MOQ / Greig</td>
                                    <td>{{$material[0]['moq']}}</td>
                                    @else
                                    <td class="fw-bold">MOQ</td>
                                    <td>{{$material[0]['moq']}}</td>
                                    @endif
                                </tr>
                                <tr>
                                    @if($form==='RM')
                                    <td class="fw-bold">MOQ / Color</td>
                                    <td>{{$material[0]['moq_color']}}</td>
                                    @else
                                    <td class="fw-bold">Color MD</td>
                                    <td>{{$material[0]['color']['description']}}</td>
                                    @endif
                                    <td class="fw-bold">PPN</td>
                                    <td>{{$material[0]['ppn']==1?'PPN':'Non PPN'}}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('script')
    <script>
        let lightbox=GLightbox({selector:".image-popup",title:'{{strlen($imageUrl) > 0 ? $material[0]['kode'].' - '. $material[0]['item_name']:'No Image'}}'})
    </script>
    @endsection
</x-layout>
