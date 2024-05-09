@extends('include.master')
@section('style')
    <style>
        .bg-success {
            background-color: #47a75ec9;
            color: #fff !important;
        }

        .bg-danger {
            background-color: rgba(198, 45, 45, 0.918);
            color: #fff !important;
        }

        .ai-icon:hover i {
            color: #fff !important;
        }

        .ai-icon:focus i {
            color: #fff !important;
        }

        .profile-menu.active .icon {
            color: #ffffff;
            /* Change to the desired color */
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: black !important;
        }

        .dt-search label {
            margin-left: 50rem !important;
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
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">All Roles</h2>
    </div>
    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <input type="date" id="startDate" class="form-control input-primary-active shadow-sm border-dark">
                        <input type="date" id="endDate"
                            class="form-control input-primary-active shadow-sm border-dark">
                        <button class="btn btn-primary position-absolute btn-rounded" onclick="filterByDate()"
                            style="right:135px;bottom: 28px;">Apply</button>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="{{ route('add-role') }}" class="btn btn-primary mb-2 btn-rounded"><span
                        class="text-white fw-bold"> +</span></a>
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
                                    <th style="text-align: center;">Role</th>
                                    <th style="text-align: center;">Assign Modules</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $role->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $role->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td><a href="javascript:void(0);"><strong>{{ $role->role }}</strong></a></td>
                                        @php
                                            $permissionsArray = json_decode($role->permission);
                                            $permissionsFormatted = implode(
                                                ', ',
                                                array_map(function ($permission) {
                                                    return ucfirst($permission);
                                                }, $permissionsArray),
                                            );
                                        @endphp
                                        <td>{{ $permissionsFormatted }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1 edit-role"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"
                                                    data-id="{{ $role->id }}"><i class="fas fa-pencil-alt"></i></a>
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
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
    <div class="modal fade" id="editRoleModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form class="" action="{{ route('update-roles') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit_role_id" name="role_id">
                        <div class="mb-3">
                            <label for="role" class="form-label text-dark fw-bold h5">Role</label>
                            <input type="text" name="role" class="form-control border-dark" id="edit_role_name"
                                placeholder="Enter Role">
                            <small class="text-primary h6">(e.g., Manager)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold h4">Assign Modules</label><br>
                            <!-- Your checkboxes for module assignment here -->
                            <div class="form-check d-flex">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="all"
                                    name="permissions[]" id="selectAllModules">
                                <label class="form-check-label text-dark fw-bold h6" for="selectAllModules">
                                    All
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Profile"
                                    name="permissions[]" id="profile">
                                <label class="form-check-label text-dark fw-bold h6" for="profile">
                                    Profile
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Enquiry"
                                    name="permissions[]" id="enquiry">
                                <label class="form-check-label text-dark fw-bold h6" for="enquiry">
                                    Enquiry
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Quotation"
                                    name="permissions[]" id="quotations">
                                <label class="form-check-label text-dark fw-bold h6" for="quotations">
                                    Quotations
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Feedback"
                                    name="permissions[]" id="feedback">
                                <label class="form-check-label text-dark fw-bold h6" for="feedback">
                                    Feedback
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Complaints"
                                    name="permissions[]" id="complaints">
                                <label class="form-check-label text-dark fw-bold h6" for="complaints">
                                    Complaints
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label text-dark fw-bold h6" for="faqs">
                                    FAQs
                                </label>
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Faqs"
                                    name="permissions[]" id="faqs">
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox"
                                    value="Notification" name="permissions[]" id="notification">
                                <label class="form-check-label text-dark fw-bold h6" for="notification">
                                    Notification
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Blogs"
                                    name="permissions[]" id="blogs">
                                <label class="form-check-label text-dark fw-bold h6" for="blogs">
                                    Blogs
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Banner"
                                    name="permissions[]" id="bannerManage">
                                <label class="form-check-label text-dark fw-bold h6" for="bannerManage">
                                    Banner Manage
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Plans"
                                    name="permissions[]" id="plans">
                                <label class="form-check-label text-dark fw-bold h6" for="plans">
                                    Subscription Plans
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value="Payment"
                                    name="permissions[]" id="paymentHistory">
                                <label class="form-check-label text-dark fw-bold h6" for="paymentHistory">
                                    Payment History
                                </label>
                            </div>
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
        $(document).ready(function() {
            $('.edit-role').click(function() {
                var role_id = $(this).data('id');
                var url = '{{ route('roles.edit', ':id') }}';
                url = url.replace(':id', role_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#edit_role_id').val(response.id);
                        $('#edit_role_name').val(response.role);
                        $('input[name="permissions[]"]').prop('checked', false);

                        // Check checkboxes based on permissions received
                        var permissions = JSON.parse(response.permission);
                        permissions.forEach(function(permission) {
                            $('input[value="' + permission + '"]').prop('checked',
                                true);
                        });
                        $('#editRoleModal').modal('show');
                    }
                });
            });
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
@endsection
