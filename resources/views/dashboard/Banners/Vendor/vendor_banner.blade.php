@extends('include.master')
@section('style')
    <style>
        .dt-search label {
            margin-left: 50rem !important;
        }

        .dt-paging {
            margin-bottom: 1rem !important;
        }

        .dt-paging.paging_full_numbers {
            float: right;
        }

        .dt-button {
            background: #FD683E !important;
            padding: .7rem !important;
            color: #fff !important;
            border-radius: 1.125rem !important;
        }
    </style>
@endsection
@section('content')
    <div class="mt-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">{{ $name }} Banner </h2>
    </div>
    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <input type="date" id="startDate" class="form-control input-primary-active shadow-sm">
                        <input type="date" id="endDate" class="form-control input-primary-active shadow-sm">
                        <button class="btn btn-primary position-absolute btn-style-apply" onclick="filterByDate()"
                            style=" right:135px;
                               bottom: 2px;">Apply</button>
                        <button class="btn btn-primary position-absolute " onclick="clearFilter()"
                            style=" right:46px;bottom: 2px;"><i class="fas fa-sync" aria-hidden="true"></i></button>
                    </div>
                </div>
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
                                    <th style="text-align: center;">Sr NO.</th>
                                    <th style="text-align: center;">Created Date, <br> Time</th>
                                    <th style="text-align: center;">Update Date, <br> Time</th>
                                    <th style="text-align: center;">Banner Image</th>
                                    <th style="text-align: center;">Banner For</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr data-banner-id="{{$user->id}}">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td style="text-align: center;"><a href="{{ asset($user->banner) }}" target="_blank"
                                                rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                                    src="{{ asset($user->banner) }}" alt=""></a></td>
                                        <td style="text-align: center;">{{ $user->for }}</td>
                                        <td>
                                            <select class="form-select border-dark fw-bold statusSwitch"
                                                style="width:100px;">
                                                <option value="1" {{ $user->status == '1' ? 'selected' : '' }}
                                                    class="bg-success text-light">Active</option>
                                                <option value="0" {{ $user->status == '0' ? 'selected' : '' }}
                                                    class="bg-danger text-light">Deactive</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                    data-bs-toggle="modal"
                                                    onclick="editBanner({{ $user->id }}, '{{ $user->for }}')"
                                                    data-bs-target="#basicModal"><i class="fas fa-pencil-alt"></i></a>
                                                <a data-banner-id="{{ $user->id }}"
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
    <div class="modal fade" id="editBannerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('vendor.banners.edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="bannerId" value="" id="VendorBannerId">
                            <label for="editTitle" class="form-label text-dark fw-bold h5">For</label>
                            <select class="form-select border-dark" id="editTitle" name="for">
                                <option value="" selected disabled>Choose Title</option>
                                <option value="Home">Home</option>
                                <option value="About">About</option>
                                {{-- <option value="Blog">Blog</option> --}}
                            </select>
                            <small class="text-primary h6">(e.g., Banner)</small>
                        </div>
                        <div class="mb-3">
                            <label for="editBannerImage" class="form-label text-dark fw-bold h5">Banner Image</label>
                            <input type="file" class="form-control border-dark" name="image" id="editBannerImage"
                                accept="image/*">
                            <small class="text-primary h6">(Upload a new image for the Banner)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary h6">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function editBanner(id, title) {
            $('#VendorBannerId').val(id);
            $('#editTitle').val(title);
            $('#editBannerModal').modal('show');
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Define which buttons to display
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var faqId = this.dataset.bannerId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Banner!',
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
            var url = "{{ route('vendor-banner-delete', ':faqId') }}".replace(':faqId', faqId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Banner');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Banner has been deleted.',
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
                        text: 'Failed to delete Banner.',
                        icon: 'error'
                    });
                });
        }
    </script>
    <script>
        $('.statusSwitch').on('change', function() {
            var selectElement = $(this).closest('tr').find('select'); // Find the select element in the current row
            var status = selectElement.val(); // Get the selected value (1 or 0)
            var bannerId = $(this).closest('tr').data('banner-id'); // Get the data-banner-id attribute value
            $.ajax({
                url: '{{ route('update-banner-vendor') }}',
                method: 'POST',
                data: {
                    status: status,
                    banner: bannerId, // Pass the banner ID
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    console.log('Status updated successfully.');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Status updated successfully!',
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error updating status:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occurred while updating the status!',
                    });
                }
            });
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
@endsection
