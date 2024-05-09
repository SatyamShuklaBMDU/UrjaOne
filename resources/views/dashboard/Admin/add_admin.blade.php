@extends('include.master')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Admin</h2>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-sm-4 d-flex flex-wrap align-items-end text-head">
            <a href="{{ route('admin-page') }}" class="btn btn-primary mb-2 h6"><span class="text-white fw-bold">See All
                    Admin</span></a>
        </div>
    </div>
    <!-- row -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <form class="card-body" action="{{ route('admins.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-bold h5">Name</label>
                        <input type="text" name="name" class="form-control border-dark" id="name"
                            placeholder="Enter Name">
                        <small class="text-primary h6">(e.g., John Doe)</small>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark fw-bold h5">Email</label>
                        <input type="email" name="email" class="form-control border-dark" id="email"
                            placeholder="Enter Email">
                        <small class="text-primary h6">(e.g., example@example.com)</small>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label text-dark fw-bold h5">Phone Number</label>
                        <input type="phone" name="phone_number" class="form-control border-dark" id="phone"
                            placeholder="Enter Phone Number">
                        <small class="text-primary h6">(e.g., 1234567890)</small>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label text-dark fw-bold h5">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="" selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->role }}</option>
                            @endforeach
                        </select>
                        <small class="text-primary h6">(e.g., admin, user, dashboard)</small>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label text-dark fw-bold h5">Create Password</label>
                        <input type="password" name="password" class="form-control border-dark" id="password"
                            placeholder="Create Password">
                        <small class="text-primary h6">(minimum 8 characters)</small>
                    </div>
                    <button type="submit" class="btn btn-primary h6" data-bs-dismiss="modal">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
@endsection
