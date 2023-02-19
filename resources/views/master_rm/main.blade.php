<x-layout breadcrumbs="material">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Data Supplier</h4>
                    <div class="flex-shrink-0">
                        <a href="{!! route('raw-material.create') !!}" class="btn btn-sm btn-info waves-effect waves-light">
                            <i class="fal fa-file-plus"></i> Add new
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @csrf
                    <table id="tbl-supplier" class="table table-sm table-bordered table-hover dt-responsive nowrap table-striped align-middle w-100 fw">
                        <thead>
                        <tr>
                            <th></th>
                            <th class="text-center">No</th>
                            <th class="text-center">id</th>
                            <th class="text-center">Kode</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Product Group ID</th>
                            <th class="text-center">Product Group</th>
                            <th class="text-center">Supplier Name</th>
                            <th class="text-center">Address</th>
                            <th class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-layout>
