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
                <form class="card-body" action="{{ route('store-plans') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark fw-bold h5">Plan Name</label>
                        <input type="text" name="name" class="form-control border-dark" id="name"
                            placeholder="Enter Name">
                    </div>
                    <div class="mb-3">
                        <label for="kilowatt" class="form-label text-dark fw-bold h5">Plan Load
                            <strong>(KW)</strong></label>
                        <input type="number" name="load" class="form-control border-dark" id="kilowatt"
                            placeholder="Enter Plan Load">
                    </div>
                    <div class="mb-3">
                        <label for="Area" class="form-label text-dark fw-bold h5">Plan Area</label>
                        <div class="row mx-3">
                            <div class="col-md-6 mt-1" style="border-right:1px solid black;"><input type="checkbox"
                                    value="vendor_state" id="state" name="area">&emsp;<label for="state"
                                    class="fw-bold">Vendor State</label></div>
                            <div class="col-md-6 mt-1"><input type="checkbox" value="pan_india" id="pan"
                                    name="area">&emsp;<label for="pan" class="fw-bold">Pan India</label></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label text-dark fw-bold h5">Plan Category</label>
                        <select name="category[]" id="category" class="form-control border-dark" multiple>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="industrial">Industrial</option>
                            <option value="agricultural">Agricultural</option>
                        </select>
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
        $(document).ready(function() {
            $('#category').select2();
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('description', {
                toolbar: [{
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript',
                            '-', 'RemoveFormat'
                        ]
                    },
                    {
                        name: 'paragraph',
                        items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                            'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight',
                            'JustifyBlock', '-', 'BidiLtr', 'BidiRtl'
                        ]
                    },
                    {
                        name: 'links',
                        items: ['Link', 'Unlink', 'Anchor']
                    },
                    {
                        name: 'styles',
                        items: ['Styles', 'Format', 'Font', 'FontSize']
                    },
                    {
                        name: 'colors',
                        items: ['TextColor', 'BGColor']
                    },
                    {
                        name: 'tools',
                        items: ['Maximize', 'ShowBlocks']
                    },
                    {
                        name: 'document',
                        items: ['Source']
                    }
                ]
            });
        });
    </script>
@endsection
