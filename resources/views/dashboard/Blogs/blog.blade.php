@extends('include.master')
@section('style')
    <style>
        .dt-search label {
            margin-left: 50rem !important;
        }

        .dt-paging {
            margin-left: 66rem !important;
            margin-bottom: 1rem !important;
        }

        .dt-button {
            background: #FD683E !important;
            padding: .7rem !important;
            color: #fff !important;
            border-radius: 1.125rem !important;
        }

        .dt-search label,
        input {
            transform: translateY(-30px);
        }

        .dt-paging.paging_full_numbers {
            float: right;
            margin-top: 5px;
        }

        .dt-button {
            background: #FD683E !important;
            padding: .7rem !important;
            color: #fff !important;
            border-radius: 1.125rem !important;
        }

        .dt-length select,
        label {
            margin-top: 6px;
        }
    </style>
@endsection
@section('content')
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">All Blog</h2>
    </div>
    <div class="justify-content-between align-items-center mb-2">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-blog') }}" method="post">
                            @csrf
                            <div>
                                <input type="date" name="startDate" id="startDate"
                                    class="form-control @error('startDate') is-invalid @enderror input-primary-active shadow-sm"
                                    value="{{ $start ?? '' }}">
                            </div>
                            <div>
                                <input type="date" name="endDate" id="endDate"
                                    class="form-control @error('endDate') is-invalid @enderror input-primary-active shadow-sm"
                                    value="{{ $end ?? '' }}">
                            </div>
                            <button class="btn btn-primary position-absolute btn-style-apply" type="submit"
                                style="right:135px; bottom: 28px;">Apply</button>
                            <a href="{{ route('get-blog-page') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 28px;"><i
                                    class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="{{ route('add-blog-page') }}" class="btn btn-primary mb-2 btn-rounded"
                    style="transform: translateY(-28px); margin-left:25rem !important;"><span class="text-white fw-bold">
                        +</span></a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th> Sr NO.</th>
                                    <th>Created Date, Time</th>
                                    <th>Blog Title</th>
                                    <th>Blog Category</th>
                                    <th>Blog Image</th>
                                    <th>Blog Discription</th>
                                    <th>Status</th>
                                    <th>View</th>
                                    <th>Likes</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $blog->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $blog->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td>{{ $blog->title }}</td>
                                        <td>{{ $blog->category }}</td>
                                        <td><a href="{{ $blog->image }}" target="_blank" rel="noopener noreferrer"><img
                                                    class="rounded-circle" width="35"
                                                    src="{{ asset($blog->image) }}"alt=""></a></td>
                                        <td>
                                            <a href="#" data-bs-toggle="tooltip"
                                                title="{{ strip_tags($blog->description) }}" data-placement="top">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($blog->description), 50) }}
                                            </a>
                                        </td>
                                        <td><a href="javascript:void(0);"><strong>{{ $blog->status }}</strong></a></td>
                                        <td class="text-dark fw-bold"><i class="fa fa-eye text-success fw-bold"></i>
                                            {{ $blog->views }}</td>
                                        <td class="text-dark fw-bold"><i
                                                class="fa fa-thumbs-up text-primary fw-bold"></i>{{ $blog->likes }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a class="btn btn-primary shadow btn-xs sharp me-1 editModal"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"
                                                    data-id="{{ $blog->id }}" data-title="{{ $blog->title }}"
                                                    data-category="{{ $blog->category }}"
                                                    data-description="{{ $blog->description }}"
                                                    data-status="{{ $blog->status }}" onclick="editBlog(this)"> <i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a data-blog-id="{{ $blog->id }}"
                                                    class="btn btn-danger shadow btn-xs sharp deleteBtn"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form action="{{ route('blogs.update') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="blogId" id="blogId" value="">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label text-dark fw-bold h5">Blog Title</label>
                            <input type="text" name="title" class="form-control border-dark" id="blogTitle"
                                placeholder="Enter Blog Title">
                        </div>
                        <div class="mb-3">
                            <label for="blogCategory" class="form-label text-dark fw-bold h5">Blog Category</label>
                            <input type="text" name="category" class="form-control border-dark" id="blogCategory"
                                placeholder="Enter Blog Category">
                        </div>
                        <div class="mb-3">
                            <label for="blogImage" class="form-label text-dark fw-bold h5">Blog Image</label>
                            <input type="file" name="image" class="form-control border-dark" id="blogImage">
                        </div>
                        <div class="mb-3">
                            <label for="ckeditor" class="form-label text-dark fw-bold h5">Blog Description</label>
                            <textarea name="description" class="form-control border-dark" id="blogDescriptionEditor" rows="3"
                                placeholder="Enter Blog Description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="blogStatus" class="form-label text-dark fw-bold h5">Blog Status</label>
                            <select name="status" class="form-select border-dark" id="blogStatus">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.editModal').on('shown.bs.modal', function() {
            $('#blogDescriptionEditor').summernote(); // Initialize Summernote for blog description
        });
    </script>
    <script>
        function editBlog(element) {
            var blogId = element.getAttribute('data-id');
            var blogTitle = element.getAttribute('data-title');
            var blogCategory = element.getAttribute('data-category');
            var blogDescription = element.getAttribute('data-description');
            var blogStatus = element.getAttribute('data-status');
            document.getElementById('blogTitle').value = blogTitle;
            document.getElementById('blogCategory').value = blogCategory;
            document.getElementById('blogId').value = blogId;

            $('#blogDescriptionEditor').summernote('code', blogDescription); // Populate Summernote editor
            document.getElementById('blogStatus').value = blogStatus;
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                dom: '<"top"Blf>rtp<"bottom"i><"clear">', // Structure the DOM elements with div wrappers
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Define which buttons to display
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                },
                lengthMenu: [10, 25, 50, 100], // Optional: specify the page length options
            });
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var faqId = this.dataset.blogId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Blog!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(faqId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(faqId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('blog-delete', ':faqId') }}".replace(':faqId', faqId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Blog');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Blog has been deleted.',
                        icon: 'success',
                        timer: 2000
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    swal.fire({
                        title: 'Error!',
                        text: 'Failed to delete Blog.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
