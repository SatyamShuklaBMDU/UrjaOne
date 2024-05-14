@extends('include.master')
@section('style')
    <style>
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

        #notificationModal input {
            transform: translateY(0px);
        }

        #editNotificationModal input {
            transform: translateY(0px);
        }

        div.dt-container .dt-length {
            display: none !important;
        }

        #userTable_length {
            margin-top: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">Notification </h2>
    </div>
    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-notification') }}" method="post">
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
                                style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('show-notification') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 2px;"><i
                                    class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <button type="button" style="margin-left: 25rem;" class="btn btn-primary mb-2"
                    data-bs-toggle="modal" data-bs-target="#notificationModal">+</button>
            </div>
        </div>
    </div>
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
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Sr NO.</th>
                                    <th style="text-align: center;">Created <br> Date, Time</th>
                                    <th style="text-align: center;">Title</th>
                                    <th style="text-align: center;">Messgae </th>
                                    <th style="text-align: center;">Image</th>
                                    <th style="text-align: center;">Recipient</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $notification->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $notification->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td style="text-align: center;">{{ $notification->title }}</td>
                                        <td style="text-align: center;">{{ $notification->description }}</td>
                                        <td style="text-align: center;"><a href="{{ asset($notification->image) }}"
                                                target="_blank" rel="noopener noreferrer"><img class="rounded-circle"
                                                    width="35" src="{{ asset($notification->image) }}"
                                                    alt=""></a>
                                        </td>
                                        <td style="text-align: center;">{{ $notification->for }}</td>
                                        <td style="text-align: center;">
                                            <div class="d-flex">
                                                <a class="btn btn-primary shadow btn-xs sharp me-1 edit-notification"
                                                    data-id="{{ $notification->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#editNotificationModal"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a data-notify-id="{{ $notification->id }}"
                                                    class="btn btn-danger shadow btn-xs sharp deleteBtn"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="dataTables_length" id="example3_length">
                            <label for="example3_length">Show
                                <select name="example3_length" aria-controls="example3" class="form-select form-select-sm">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                entries
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="notificationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('notifications.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="for" class="form-label text-dark fw-bold h5">Select Options</label>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="bothOption" value="both">
                                <label class="form-check-label" for="bothOption">Both</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="userOption" value="user">
                                <label class="form-check-label" for="userOption">User</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="vendorOption" value="vendor">
                                <label class="form-check-label" for="vendorOption">Vendor</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notificationTitle" class="form-label text-dark fw-bold h5">Notification
                                Title</label>
                            <input type="text" name="title" class="form-control border-dark" id="notificationTitle"
                                placeholder="Enter Notification Title">
                        </div>
                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label text-dark fw-bold h5">Notification
                                Message</label>
                            <textarea class="form-control border-dark" name="message" id="notificationMessage" rows="3"
                                placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notificationImage" class="form-label text-dark fw-bold h5">Image</label>
                            <input type="file" name="image" class="form-control border-dark"
                                id="notificationImage">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--edit notification-->
    <div class="modal fade" id="editNotificationModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('notifications.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="notifyId">
                        <div class="mb-3">
                            <label for="notificationType" class="form-label text-dark fw-bold h5">Select Options</label>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="bothOption" value="both" data-for="both">
                                <label class="form-check-label" for="bothOption">Both</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="userOption" value="user" data-for="user">
                                <label class="form-check-label" for="userOption">User</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" style="transform: translateY(0px);" type="radio"
                                    name="for" id="vendorOption" value="vendor" data-for="vendor">
                                <label class="form-check-label" for="vendorOption">Vendor</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notificationTitle" class="form-label text-dark fw-bold h5">Notification
                                Title</label>
                            <input type="text" class="form-control border-dark" id="editNotificationTitle"
                                name="title" placeholder="Enter Notification Title">
                        </div>
                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label text-dark fw-bold h5">Notification
                                Message</label>
                            <textarea class="form-control border-dark" id="editNotificationMessage" rows="3" name="message"
                                placeholder="Enter Notification Message"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editNotificationImage" class="form-label text-dark fw-bold h5">Image</label>
                            <input type="file" class="form-control border-dark" id="editNotificationImage"
                                name="image">
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
                lengthMenu: false, // Optional: specify the page length options
            });
            $('#example3_length select').change(function() {
                var length = $(this).val();
                $('#example3').DataTable().page.len(length).draw();
            });
        });
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
    <script>
        $(document).ready(function() {
            $('.edit-notification').click(function() {
                var notification_id = $(this).data('id');
                var url = '{{ route('notifications.edit', ':id') }}';
                url = url.replace(':id', notification_id);
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#notifyId').val(response.id);
                        $('#editNotificationTitle').val(response.title);
                        $('#editNotificationMessage').val(response.description);
                        $('input[name="for"]').each(function() {
                            if ($(this).data('for') === response.for) {
                                $(this).prop('checked', true);
                            }
                        });
                        $('#editNotificationModal').modal('show');
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var userId = this.dataset.notifyId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Notification!',
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

        function deleteFAQ(notifyId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('notifications.destroy', ':notifyId') }}".replace(':notifyId', notifyId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Notification');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Notification has been deleted.',
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
                        text: 'Failed to delete Notification.',
                        icon: 'error'
                    });
                });
        }
    </script>
@endsection
