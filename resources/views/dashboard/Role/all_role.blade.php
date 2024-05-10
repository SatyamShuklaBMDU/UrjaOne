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
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">All Roles</h2>
    </div>
    <div class="justify-content-between align-items-center mb-2">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-role') }}" method="post">
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
                            <a href="{{ route('all-role') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 28px;"><i
                                    class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="{{ route('add-role') }}" class="btn btn-primary mb-2 btn-rounded"
                    style="margin-left: 27rem;margin-top:-2rem;"><span class="text-white fw-bold">
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
                                                <a href="{{ route('roles.edit', encrypt($role->id)) }}"
                                                    class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger shadow btn-xs sharp deleteBtn"
                                                    data-role-id="{{ $role->id }}"><i
                                                        class="fa fa-trash "></i></button>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var roleId = this.dataset.roleId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Role!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(roleId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(roleId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('role-delete', ':roleId') }}".replace(':roleId', roleId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Role');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Role has been deleted.',
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
                        text: 'Failed to delete Role.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
