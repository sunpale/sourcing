<x-layout breadcrumbs="bom.create" :select2="true" :jsvalidation="true">
    <form method="post" action="{{route('bom.store')}}" id="frmBom">
        @csrf
        <div class="row">
            <div class="col-lg-3">
                <div class="card mb-3">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="card-title mb-0 flex-grow-1 text-start">Article Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            {{--<label class="form-label" for="supplier">Article</label>--}}
                            <select class="form-select @error('article_id') is-invalid @enderror" id="article" name="article_id" onchange="getDetailArticle()">
                                <option disabled selected value>Select Supplier</option>
                            </select>
                            @error('article_id')
                            <div class="invalid-feedback">
                                {{$errors->messages()['article_id'][0]}}
                            </div>
                            @enderror
                        </div>
                        <div class="table-card sembunyi" id="article-info">
                            <table class="table mb-0">
                                <tbody>
                                <tr>
                                    <td class="fw-medium">Article ID</td>
                                    <td id="article-id"></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Brand</td>
                                    <td id="article-brand">Profile Page Satructure</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Modul</td>
                                    <td id="article-modul">Velzon - Admin Dashboard</td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Color</td>
                                    <td id="article-color"></td>
                                </tr>
                                <tr>
                                    <td class="fw-medium">Designer</td>
                                    <td id="article-designer"></td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="card-title mb-0 flex-grow-1 text-start">Article Image</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <div class="text-center">
                                <div class="profile-user position-relative d-inline-block mx-auto  mb-4">
                                    <img src="{{asset('src/images/default.png')}}" class="avatar-xxl img-thumbnail user-profile-image" id="article-image" alt="user-profile-image">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!---end col-->
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="card-title mb-0 flex-grow-1 text-start">Body Section</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                <thead class="align-middle">
                                <tr class="table-active">
                                    <th scope="col" class="text-center" style="width: 1%;">#</th>
                                    <th scope="col" class="text-center w-14">
                                        Size
                                    </th>
                                    <th scope="col" class="text-center w-8point7">
                                        Rasio
                                    </th>
                                    <th scope="col" class="w-25">Group</th>
                                    <th scope="col" class="text-center w-40">Items</th>
                                    <th scope="col" class="text-center w-10">
                                        Cons
                                    </th>
                                    <th scope="col" class="text-center w-5"></th>
                                </tr>
                                </thead>
                                <tbody id="body">
                                <tr id="body-row-1" class="items">
                                    <th scope="row" class="body-id text-center">1</th>
                                    <td class="text-start">
                                        <x-forms.select class="form-select-sm" id="body-size1" name="body_size[1]" :list-value="$size->toArray()">Size</x-forms.select>
                                    </td>
                                    <td>
                                        <x-forms.input class="form-control-sm text-center" id="body-ratio1" name="body_ratio[1]" :value="0"></x-forms.input>
                                    </td>
                                    <td>
                                        <x-forms.select class="form-select-sm" id="body-group1" name="body_group[1]" :list-value="$productGroup->whereIn('group',['Body','Rib'])->pluck('group','id')->toArray()">Select Group</x-forms.select>
                                    </td>
                                    <td>
                                        <x-forms.select class="form-select-sm items-select" id="body-item1" name="body_item[1]"></x-forms.select>
                                        {{--<strong><a href="javascript:void(0)" id="image1">View Image</a></strong>--}}
                                    </td>
                                    <td><x-forms.input class="form-control-sm" id="body-cons1" name="body_cons[1]"></x-forms.input></td>
                                    <td class="body-removal">
                                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="btndelete1"><i class="ri-delete-bin-2-line"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody>
                                <tr id="newForm" style="display: none;"><td class="d-none" colspan="5"><p>Add New Form</p></td></tr>
                                <tr>
                                    <td colspan="5">
                                        <a href="javascript:new_body_row()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h6 class="card-title mb-0 flex-grow-1 text-start">Accessories Section</h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="invoice-table table table-borderless table-nowrap mb-0">
                                <thead class="align-middle">
                                <tr class="table-active">
                                    <th scope="col" class="text-center" style="width: 1%;">#</th>
                                    <th scope="col" class="text-center w-14">
                                        Size
                                    </th>
                                    <th scope="col" class="text-center w-8point7">
                                        Rasio
                                    </th>
                                    <th scope="col" class="w-25">Group</th>
                                    <th scope="col" class="text-center w-40">Items</th>
                                    <th scope="col" class="text-center w-10">
                                        Cons
                                    </th>
                                    <th scope="col" class="text-center w-5"></th>
                                </tr>
                                </thead>
                                <tbody id="aks">
                                <tr id="aks-row-1" class="items">
                                    <th scope="row" class="aks-id text-center">1</th>
                                    <td class="text-start">
                                        <x-forms.select class="form-select-sm" id="aks-size1" name="aks_size[1]" :list-value="$size->toArray()">Size</x-forms.select>
                                    </td>
                                    <td>
                                        <x-forms.input class="form-control-sm text-center" id="aks-ratio1" name="aks_ratio[1]" :value="0"></x-forms.input>
                                    </td>
                                    <td>
                                        <x-forms.select class="form-select-sm" id="aks-group1" name="aks_group[1]" :list-value="$productGroup->whereNotIn('group',['Body','Rib'])->pluck('group','id')->toArray()">Select Group</x-forms.select>
                                    </td>
                                    <td>
                                        <x-forms.select class="form-select-sm items-select" id="aks-item1" name="aks_item[1]"></x-forms.select>
                                        {{--<strong><a href="javascript:void(0)" id="image1">View Image</a></strong>--}}
                                    </td>
                                    <td><x-forms.input class="form-control-sm" id="aks-cons1" name="aks_cons[1]"></x-forms.input></td>
                                    <td class="aks-removal">
                                        <a href="javascript:void(0)" class="btn btn-xs btn-danger" id="btndelete1"><i class="ri-delete-bin-2-line"></i> </a>
                                    </td>
                                </tr>
                                </tbody>
                                <tbody>
                                <tr id="newForm" style="display: none;"><td class="d-none" colspan="5"><p>Add New Form</p></td></tr>
                                <tr>
                                    <td colspan="5">
                                        <a href="javascript:new_aks_row()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <!--end table-->
                        </div>
                    </div>
                </div>
                <!--end card-->
                <div class="text-end">
                    <button type="submit" class="btn btn-success data-submit me-1">Save</button>
                    <a href="{!! route('bom.index') !!}" class="btn btn-outline-danger">Cancel</a>
                </div>
            </div>
            <!--end col-->
        </div>
    </form>
    @section('script')
        {!! JsValidator::formRequest('App\Http\Requests\BomRequest') !!}
        <script>
            var count_body=1,count_aks = 1;
            const BodySizeNode = document.getElementById('body-size1');
            const BodySizeClone = BodySizeNode.cloneNode(true);
            const BodyRatioNode = document.getElementById('body-ratio1');
            const BodyRatioClone = BodyRatioNode.cloneNode(true);
            const BodyGroupNode = document.getElementById('body-group1');
            const BodyGroupClone = BodyGroupNode.cloneNode(true);
            const BodyItemNode = document.getElementById('body-item1');
            const BodyItemClone = BodyItemNode.cloneNode(true);
            const BodyConsNode = document.getElementById('body-cons1');
            const BodyConsClone = BodyConsNode.cloneNode(true);
            const AksSizeNode = document.getElementById('aks-size1');
            const AksSizeClone = AksSizeNode.cloneNode(true);
            const AksGroupNode = document.getElementById('aks-group1');
            const AksGroupClone = AksGroupNode.cloneNode(true);
            const AksItemNode = document.getElementById('aks-item1');
            const AksItemClone = AksItemNode.cloneNode(true);
            const AksConsNode = document.getElementById('aks-cons1');
            const AksConsClone = AksConsNode.cloneNode(true);
            const AksRatioNode = document.getElementById('aks-ratio1');
            const AksRatioClone = AksRatioNode.cloneNode(true);


            function getArticles(){
                $('#article').select2({
                    ajax : {
                        url         : '{{route('articles.data-articles')}}',
                        dataType    : 'json',
                        type        : 'get',
                        delay       : 250,
                        data        : function (params) {
                            return {
                                search      : params.term,
                                page        : params.page || 1,
                            }
                        },
                        processResults : function (data, params) {
                            params.page = params.page ||1;
                            return {
                                results     : data.items,
                                pagination  : {
                                    more    : (params.page * 25) < data.total_count
                                }
                            }
                        },
                        cache : true
                    },
                    /*minimumInputLength : 1,*/
                    placeholder : "Material",
                    templateResult : format,
                    templateSelection :formatSelection,
                    containerCssClass: "wrap"
                });
            }

            function getDetailArticle(){
                let articleId = document.getElementById('article');
                fetch(baseUrl + '/master-data/articles/find-article/'+articleId.value,{
                    headers: {
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('#article-info').classList.remove('sembunyi');
                        document.getElementById('article-id').innerHTML = data.result[0].kode;
                        document.getElementById('article-brand').innerHTML = data.result[0].brand['brand'];
                        document.getElementById('article-modul').innerHTML = data.result[0].modul;
                        document.getElementById('article-color').innerHTML = data.result[0].pantone['pantone'];
                        document.getElementById('article-designer').innerHTML = data.result[0].designer;
                        document.getElementById('article-image').src = data.image;
                    })
                    .catch(error => console.error(error));
            }

            function getMaterials(row,section){
                $('#'+section+'-item'+row).select2({
                    ajax : {
                        url         : '{{route('master-rm.raw-material.data-materials')}}',
                        dataType    : 'json',
                        type        : 'get',
                        delay       : 250,
                        data        : function (params) {
                            return {
                                search      : params.term,
                                page        : params.page || 1,
                            }
                        },
                        processResults : function (data, params) {
                            params.page = params.page ||1;
                            return {
                                results     : data.items,
                                pagination  : {
                                    more    : (params.page * 25) < data.total_count
                                }
                            }
                        },
                        cache : true
                    },
                    /*minimumInputLength : 1,*/
                    placeholder : "Materials",
                    templateResult : format,
                    templateSelection :formatSelection,
                    containerCssClass: "wrap"
                });
            }

            function SetBodyAttributeElement(number){
                BodySizeClone.setAttribute('id','body-size'+number);
                BodySizeClone.setAttribute('name','body_size['+number+']');
                BodyRatioClone.setAttribute('id','body-ratio'+number);
                BodyRatioClone.setAttribute('name','body_ratio['+number+']');
                BodyGroupClone.setAttribute('id','body-group'+number);
                BodyGroupClone.setAttribute('name','body_group['+number+']');
                BodyItemClone.setAttribute('id','body-item'+number);
                BodyItemClone.setAttribute('name','body_item['+number+']');
                BodyConsClone.setAttribute('id','body-cons'+number);
                BodyConsClone.setAttribute('name','body_cons['+number+']');
            }

            function SetAksAttributeElement(number){
                AksSizeClone.setAttribute('id','aks-size'+number);
                AksSizeClone.setAttribute('name','aks_size['+number+']');
                AksGroupClone.setAttribute('id','aks-group'+number);
                AksGroupClone.setAttribute('name','aks_group['+number+']');
                AksItemClone.setAttribute('id','aks-item'+number);
                AksItemClone.setAttribute('name','aks_item['+number+']');
                AksConsClone.setAttribute('id','aks-cons'+number);
                AksConsClone.setAttribute('name','aks_cons['+number+']');
                AksRatioClone.setAttribute('id','aks-ratio'+number);
                AksRatioClone.setAttribute('name','aks_ratio['+number+']');
            }

            function init_select(row,section){
                $('#'+section+'-size'+row).select2();
                $('#'+section+'-group'+row).select2();
            }
            function new_body_row() {
                count_body++;
                SetBodyAttributeElement(count_body);
                let e = Object.assign(document.createElement('tr'),{id:'body-row-'+count_body,className:'items'});
                e.innerHTML = ('<tr><th scope="row" class="body-id text-center">' + count_body + '</th><td class="text-start">' + BodySizeClone.outerHTML + '</td><td>' + BodyRatioClone.outerHTML + '</td><td>' + BodyGroupClone.outerHTML + '</td><td>' + BodyItemClone.outerHTML + '</td><td>' + BodyConsClone.outerHTML + '</td><td class="body-removal"><a href="javascript:void(0)" class="btn btn-xs btn-danger" id="btndelete'+count_body+'"><i class="ri-delete-bin-2-line"></i></a></td>');
                document.getElementById('body').appendChild(e);
                getMaterials(count_body,'body');
                init_select(count_body,'body');
                remove('body');
            }
            function new_aks_row() {
                count_aks++;
                SetAksAttributeElement(count_aks);
                let e = Object.assign(document.createElement('tr'),{id:'aks-row-'+count_aks,className:'items'});
                e.innerHTML = ('<tr><th scope="row" class="aks-id text-center">' + count_aks + '</th><td class="text-start">' + AksSizeClone.outerHTML + '</td><td>' + AksRatioClone.outerHTML + '</td><td>' +AksGroupClone.outerHTML + '</td><td>' + AksItemClone.outerHTML + '</td><td>' + AksConsClone.outerHTML + '</td><td class="aks-removal"><a href="javascript:void(0)" class="btn btn-xs btn-danger" id="btndelete'+count_body+'"><i class="ri-delete-bin-2-line"></i></a></td>');
                document.getElementById('aks').appendChild(e);
                getMaterials(count_aks,'aks')
                init_select(count_aks,'aks');
                remove('aks');
            }

            function remove(section) {
                Array.from(document.querySelectorAll("."+section+"-removal a")).forEach(function (e) {
                    e.addEventListener("click", function (e) {
                        removeItem(e);
                        resetRow(section);
                    })
                });
            }

            function removeItem(e) {
                e.target.closest("tr").remove()
            }

            function resetRow(section) {
                if(section==='body'){
                    Array.from(document.getElementById("body").querySelectorAll("tr")).forEach(function (e,t){
                        t += 1;
                        e.querySelector('.body-id').innerHTML = t;
                        count_body = t;
                        let row = e.getAttribute('id').split('-')[2];
                        document.getElementById(e.getAttribute('id')).setAttribute('id','body-row-'+t);
                        document.getElementById('body-size'+row).setAttribute('name','body_size['+t+']');
                        document.getElementById('body-size'+row).setAttribute('id','body-size'+t);
                        document.getElementById('body-ratio'+row).setAttribute('name','body_ratio['+t+']');
                        document.getElementById('body-ratio'+row).setAttribute('id','body-ratio'+t);
                        document.getElementById('body-group'+row).setAttribute('name','body_group['+t+']');
                        document.getElementById('body-group'+row).setAttribute('id','body-group'+t);
                        document.getElementById('body-item'+row).setAttribute('name','body_item['+t+']');
                        document.getElementById('body-item'+row).setAttribute('id','body-item'+t);
                        document.getElementById('body-cons'+row).setAttribute('name','body_cons['+t+']');
                        document.getElementById('body-cons'+row).setAttribute('id','body-cons'+t);
                    });
                    count_body = count_body===1?0:count_body;
                }else if(section==='aks'){
                    Array.from(document.getElementById("aks").querySelectorAll("tr")).forEach(function (e,t){
                        t += 1;
                        e.querySelector('.aks-id').innerHTML = t;
                        count_aks = t;
                        let row = e.getAttribute('id').split('-')[2];
                        document.getElementById(e.getAttribute('id')).setAttribute('id','aks-row-'+t);
                        document.getElementById('aks-size'+row).setAttribute('name','aks_size['+t+']');
                        document.getElementById('aks-size'+row).setAttribute('id','aks-size'+t);
                        document.getElementById('aks-ratio'+row).setAttribute('name','aks_ratio['+t+']');
                        document.getElementById('aks-ratio'+row).setAttribute('id','aks-ratio'+t);
                        document.getElementById('aks-group'+row).setAttribute('name','aks_group['+t+']');
                        document.getElementById('aks-group'+row).setAttribute('id','aks-group'+t);
                        document.getElementById('aks-item'+row).setAttribute('name','aks_item['+t+']');
                        document.getElementById('aks-item'+row).setAttribute('id','aks-item'+t);
                        document.getElementById('aks-cons'+row).setAttribute('name','aks_cons['+t+']');
                        document.getElementById('aks-cons'+row).setAttribute('id','aks-cons'+t);
                    });
                    count_aks = count_aks===1?0:count_aks;
                }
            }

            document.addEventListener('DOMContentLoaded',function (){
                document.querySelector('html').setAttribute('data-sidebar-size','sm');
                getArticles();
                getMaterials(1,'body');
                getMaterials(1,'aks')
                init_select(1,'body');
                init_select(1,'aks');
                remove('body');
                remove('aks');
            })
        </script>
    @endsection
</x-layout>
