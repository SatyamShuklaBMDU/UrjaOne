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
                <form class="card-body" action="{{ route('store-plans') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-bold h5">Name</label>
                        <input type="text" name="name" class="form-control border-dark" id="name"
                            placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="type" class="form-label text-dark fw-bold h5">Type</label>
                        <input type="text" name="type" class="form-control border-dark" id="type"
                            placeholder="Enter Type">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label text-dark fw-bold h5">Category</label>
                        <select name="category" class="form-control border-dark" id="category">
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="agricultural">Agricultural</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label text-dark fw-bold h5">Amount</label>
                        <input type="text" name="price" class="form-control border-dark" id="price"
                            placeholder="Enter Amount">
                    </div>
                    <div class="mb-3">
                        <label for="discount" class="form-label text-dark fw-bold h5">Discount</label>
                        <input type="text" name="discount" class="form-control border-dark" id="discount"
                            placeholder="Enter Discount">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-dark fw-bold h5">Description</label>
                        <textarea name="description" id="description" class="form-control border-dark" cols="30" rows="10"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="valid_upto" class="form-label text-dark fw-bold h5">Valid Upto</label>
                        <select name="duration" class="form-control border-dark" id="valid_upto">
                            <option value="1 Months">1 Months</option>
                            <option value="3 Months">3 Months</option>
                            <option value="6 Months">6 Months</option>
                            <option value="1 Year">1 Year</option>
                        </select>
                    </div>
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
