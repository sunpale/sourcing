<x-layout breadcrumbs="main">
    @if($errors->any())
        {!! implode('', $errors->all('<div>:message</div>')) !!}
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Register User Baru</h4>
                </div>
                <div class="card-body">
                    <form id="frm-register" method="post" action="{{route('register')}}">
                        @csrf
                        <x-forms.input id="nama" name="nama" label="Fullname" placeholder="Insert your fullname"></x-forms.input>
                        <x-forms.input id="username" name="username" label="Username" placeholder="Insert your username"></x-forms.input>
                        {{--<x-forms.input id="email" name="email" label="E-mail" placeholder="Insert email"></x-forms.input>--}}
                        <div class="mb-2">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" for="password_confirmation">Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-success data-submit me-1">Register</button>
                            <button type="reset" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>
