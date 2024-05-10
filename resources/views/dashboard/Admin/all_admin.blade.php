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

        .statusSwitch {
            --s: 20px;
            /* adjust this to control the size*/

            height: calc(var(--s) + var(--s)/5);
            width: auto;
            /* some browsers need this */
            aspect-ratio: 2.25;
            border-radius: var(--s);
            margin: calc(var(--s)/2);
            display: grid;
            cursor: pointer;
            background-color: #ff7a7a;
            box-sizing: content-box;
            overflow: hidden;
            transition: .3s .1s;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .statusSwitch:before {
            content: "";
            padding: calc(var(--s)/10);
            --_g: radial-gradient(circle closest-side at calc(100% - var(--s)/2) 50%, #000 96%, #0000);
            background:
                var(--_g) 0 /var(--_p, var(--s)) 100% no-repeat content-box,
                var(--_g) var(--_p, 0)/var(--s) 100% no-repeat content-box,
                #fff;
            mix-blend-mode: darken;
            filter: blur(calc(var(--s)/12)) contrast(11);
            transition: .4s, background-position .4s .1s,
                padding cubic-bezier(0, calc(var(--_i, -1)*200), 1, calc(var(--_i, -1)*200)) .25s .1s;
        }

        .statusSwitch:checked {
            background-color: #85ff7a;
        }

        .statusSwitch:checked:before {
            padding: calc(var(--s)/10 + .05px) calc(var(--s)/10);
            --_p: 100%;
            --_i: 1;
        }
    </style>
@endsection
@section('content')
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">All Admin</h2>
    </div>
    <div class="justify-content-between align-items-center mb-2">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-admin') }}" method="post">
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
                            <a href="{{ route('admin-page') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 28px;"><i
                                    class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="{{ route('add-admin') }}" class="btn btn-primary mb-2 btn-rounded" style="margin-left: 27rem;margin-top:-2rem;"><span
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
                                    <th style="text-align: center;">Name</th>
                                    <th style="text-align: center;">Email</th>
                                    <th style="text-align: center;">Roles</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <select class="form-select ChangeRole" data-user-id="{{ $user->id }}"
                                                aria-label="Default select example">
                                                <option selected>Choose Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                                        {{ $role->role }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        {{-- <td>
                                            <input class="statusSwitch" {{ $user-}} style="transform: translateY(0px);" type="checkbox">
                                        </td> --}}
                                        <td>
                                            <div class="d-flex">
                                                <a href="#"
                                                    class="btn btn-primary shadow btn-xs sharp me-1 edit-admin"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"
                                                    data-id="{{ $user->id }}"><i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger shadow btn-xs sharp deleteBtn"
                                                    data-user-id="{{ $user->id }}"><i
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
    <!-- Modal -->
    <div class="modal fade" id="editAdminModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('update-admins') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="id" value="" id="admin_id">
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold h5">Name</label>
                            <input type="text" class="form-control border-dark" id="name" name="name"
                                placeholder="Enter Name">
                            <small class="text-primary h6">(e.g., John Doe)</small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark fw-bold h5">Email</label>
                            <input type="email" class="form-control border-dark" id="email" name="email"
                                placeholder="Enter Email">
                            <small class="text-primary h6">(e.g., example@example.com)</small>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="form-label text-dark fw-bold h5">Phone Number</label>
                            <input type="number" class="form-control border-dark" id="number" name="number"
                                placeholder="Enter Phone Number">
                            <small class="text-primary h6">(e.g., example@example.com)</small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark fw-bold h5">Create Password</label>
                            <input type="password" class="form-control border-dark" id="password" name="password"
                                placeholder="Create Password">
                            <small class="text-primary h6">(minimum 8 characters)</small>
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ChangeRole').forEach(select => {
                select.addEventListener('change', function() {
                    const userId = this.dataset.userId;
                    const roleId = this.value;
                    fetch('{{ url('change-role') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is correctly passed
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                role_id: roleId
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'User role has been updated successfully.'
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!'
                            });
                        });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-admin').click(function() {
                var admin_id = $(this).data('id');
                var url = '{{ route('admins.edit', ':id') }}';
                url = url.replace(':id', admin_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#admin_id').val(response.id);
                        $('#name').val(response.name);
                        $('#email').val(response.email);
                        $('#number').val(response.phone_number);
                        $('#editAdminModal').modal('show');
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
                    var userId = this.dataset.userId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this User!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(userId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(userId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('user-delete', ':userId') }}".replace(':userId', userId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete FAQ');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The User has been deleted.',
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
                        text: 'Failed to delete FAQ.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
