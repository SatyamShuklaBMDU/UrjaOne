@extends('include.master')
@section('content')
    <div class="row mt-2">
        <div class="col-md-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-2 me-auto">Add Blog</h2>

        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <button type="button" class="btn btn-primary mb-2 btn-rounded h6"><a href="{{ route('get-blog-page') }}"
                    class="text-white fw-bold">See All Blogs</a></button>

        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <form action="{{ route('blogs.store') }}" enctype="multipart/form-data" method="post" class="card-body">
                    @csrf
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="blogTitle" class="form-label text-dark fw-bold h5">Blog Title</label>
                        <input type="text" name="title" class="form-control border-dark" id="blogTitle"
                            placeholder="Enter Blog Title">
                        <small class="text-primary h6">(max 20 characters)</small>
                    </div>
                    <div class="">
                        <label for="blogImage" class="form-label text-dark fw-bold h5">Blog Image</label>
                        <input type="file" name="image" class="form-control border-dark" id="blogImage">
                        <small class="text-primary h6">(jpg, png, gif)</small>
                    </div>
                    <div class="mb-3">
                        <label for="blogImage" class="form-label text-dark fw-bold h5">Blog Discription</label>
                        <textarea id="summernote" name="description"></textarea>
                        <small class="text-primary h6">(max 500 characters)</small>
                    </div>
                    <div class="mb-3">
                        <label for="blogStatus" class="form-label text-dark fw-bold h5">Blog Status</label>
                        <select name="status" class="form-select border-dark" id="blogStatus">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection
