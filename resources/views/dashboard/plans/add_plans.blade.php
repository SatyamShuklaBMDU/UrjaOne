@extends('include.master')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Plans</h2>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-sm-4 d-flex flex-wrap align-items-end text-head">
            <a href="{{ route('plans-page') }}" class="btn btn-primary mb-2 h6"><span class="text-white fw-bold">See All
                    Plans</span></a>
        </div>
    </div>
    <!-- row -->
    @if ($errors->any())
        <div>
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
                <form class="card-body" action="{{ route('store-plans') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-bold h5">Plan Name</label>
                        <input type="text" name="name" class="form-control border-dark" id="name"
                            placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label text-dark fw-bold h5">Plan Image</label>
                        <input type="file" name="image" class="form-control border-dark" id="image">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-dark fw-bold h5">Plan Details</label>
                        <textarea name="description" id="description" class="form-control border-dark" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label text-dark fw-bold h5">Plan Amount</label>
                        <input type="text" name="price" class="form-control border-dark" id="price"
                            placeholder="Enter Amount">
                    </div>
                    {{-- <div class="mb-3">
                        <label for="status" class="form-label text-dark fw-bold h5">Status</label>
                        <select name="status" id="status" class="form-control border-dark">
                            <option value="1">Active</option>
                            <option value="0">Deactive</option>
                        </select>
                    </div> --}}
                    <button type="submit" class="btn btn-primary h6">Submit</button>
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
    <script>
        $(document).ready(function() {
            $('#description').summernote();
        });
    </script>
@endsection
