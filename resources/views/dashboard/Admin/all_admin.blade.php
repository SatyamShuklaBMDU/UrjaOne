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
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">All Admin</h2>
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
                <a href="{{ route('add-admin') }}" class="btn btn-primary mb-2 btn-rounded"><span
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
                                    {{-- <th style="text-align: center;">Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td style="text-align: center;">
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td><a href="javascript:void(0);"><strong>{{$user->roles->role}}</strong></a></td>
                                        {{-- <td>
                                            <input class="statusSwitch" {{ $user-}} style="transform: translateY(0px);" type="checkbox">
                                        </td> --}}
                                        <td>
                                            <div class="d-flex">
                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"><i
                                                        class="fas fa-pencil-alt"></i></a>
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
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="">
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold h5">Name</label>
                            <input type="text" class="form-control border-dark" id="name" placeholder="Enter Name">
                            <small class="text-primary h6">(e.g., John Doe)</small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label text-dark fw-bold h5">Email</label>
                            <input type="email" class="form-control border-dark" id="email" placeholder="Enter Email">
                            <small class="text-primary h6">(e.g., example@example.com)</small>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label text-dark fw-bold h5">Role</label>
                            <input type="text" class="form-control border-dark" id="roles" placeholder="Enter Role">
                            <small class="text-primary h6">(e.g., admin, user, dashboard)</small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label text-dark fw-bold h5">Create Password</label>
                            <input type="password" class="form-control border-dark" id="password"
                                placeholder="Create Password">
                            <small class="text-primary h6">(minimum 8 characters)</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold h4">Assign Modules</label><br>
                            <!-- Your checkboxes for module assignment here -->
                            <div class="form-check-inline">
                                <input class="form-check-input border-primary fw-bold" type="checkbox" value=""
                                    id="enquiry">
                                <label class="form-check-label text-dark fw-bold h6" for="enquiry">
                                    Enquiry
                                </label>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
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
@endsection
