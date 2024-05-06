@extends('include.master')
@section('style')
    <style>
        .bg-success {
            background-color: #47a75ec9 !important;
            color: #fff !important;
        }

        .bg-danger {
            background-color: hsl(60, 66%, 48%) !important;
            color: #fff !important;
        }

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
    </style>
@endsection
@section('content')
    <div class="mt-5 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">User Feedback</h2>

    </div>

    <div class="justify-content-between align-items-center mb-5">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-customer-feedback') }}" method="post">
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
                            <a href="{{ route('customer-feedback') }}" class="btn btn-primary position-absolute"
                                style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
                        </form>
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
                                    <th>Sr NO.</th>
                                    <th>Created Date, <br> Time</th>
                                    <th>CIN No</th>
                                    <th>Mobile No</th>
                                    <th>User Name</th>
                                    <th>Feedback <br> Image</th>
                                    <th>Feedback Message</th>
                                    <th>Replied Date, <br> Time</th>
                                    <th>Reply</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userFeedback as $uf)
                                <tr data-feedback-id="{{ $uf->id }}">
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">
                                        {{ $uf->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                        {{ $uf->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                    </td>
                                    <td style="text-align: center;">{{ $uf->customer->cin_no }}</td>
                                    <td style="text-align: center;">{{ $uf->customer->phone_number }}</td>
                                    <td style="text-align: center;">{{ $uf->customer->name }}</td>
                                    <td style="text-align: center;"><a href="{{ asset($uf->image) }}" target="_blank"
                                            rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                                src="{{ asset($uf->image) }}" alt="No"></a></td>
                                    <td style="text-align: center;"><a href="javascript:void(0);"><strong>{{ $uf->message }}</strong></a></td>
                                    <td style="text-align: center;">
                                        @if ($uf->reply_datetime)
                                            {{ $uf->reply_datetime->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $uf->reply_datetime->timezone('Asia/Kolkata')->format('h:i A') }}
                                        @endif
                                    </td>
                                    <td style="text-align: center;" class="reply-message"><a
                                            href="javascript:void(0);"><strong>{{ $uf->reply ?? '--' }}</strong></a>
                                    </td>
                                    {{-- <td>
                                        <select name="status" id="status" class="custom-select bg-success">
                                            <option value="confirm" {{ $uf->status == 'confirm' ? 'selected' : '' }}
                                                class="text-success">Confirm</option>
                                            <option value="follow" {{ $uf->status == 'follow' ? 'selected' : '' }}
                                                class="text-warning">Follow</option>
                                        </select>
                                    </td> --}}
                                    <td>
                                        <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-1x sharp me-1 reply-btn"
                                                data-feedback-id="{{ $uf->id }}" data-bs-toggle="modal"
                                                data-bs-target="#basicModal">Reply
                                            </a>
                                            <a href="#"
                                                class="btn btn-primary shadow btn-1x sharp me-1 edit-reply-btn"
                                                data-bs-toggle="modal" data-bs-target="#editReplyModal"
                                                data-feedback-id="{{ $uf->id }}"><i class="fas fa-edit"></i></a>
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
    {{-- Modal Content --}}
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <div class="modal-body">
                    <form id="replyForm">
                        <input type="hidden" id="feedbackId" name="feedbackId">
                        <div class="mb-3">
                            <label for="blogTitle" class="form-label text-dark fw-bold h5">Compose Response</label>
                            <input type="text" class="form-control border-dark" id="replyMessage"
                                placeholder="Enter Compose Response" value="">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="sendReply">Send</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editReplyModal" tabindex="-1" aria-labelledby="editReplyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReplyModalLabel">Edit Reply</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editReplyForm">
                        <div class="mb-3">
                            <label for="editReplyMessage" class="form-label">Edit Reply Message</label>
                            <input type="text" class="form-control" id="editReplyMessage" name="editReplyMessage">
                            <input type="hidden" id="feedbackId" name="feedbackId">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEditReply">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                dom: 'Bfrtip', // Add buttons to the DOM
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
            $('.reply-btn').click(function() {
                var feedbackId = $(this).data('feedback-id');
                $('#feedbackId').val(feedbackId);
            });

            $('#sendReply').click(function() {
                var replyMessage = $('#replyMessage').val();
                var feedbackId = $('#feedbackId').val();

                $.ajax({
                    url: "{{ route('customerreplyTofeedback') }}",
                    type: "POST",
                    data: {
                        feedbackId: feedbackId,
                        replyMessage: replyMessage,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $('#basicModal').modal('hide');
                        swal.fire({
                            title: 'Send!',
                            text: 'Feedback Replied Send.',
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
            $('.edit-reply-btn').click(function() {
                var feedbackId = $(this).data('feedback-id');
                var replyMessage = $(this).closest('tr').find('.reply-message').text();
                $('#editReplyMessage').val(replyMessage);
                $('#feedbackId').val(feedbackId);
            });
            $('#saveEditReply').click(function() {
                var editedReplyMessage = $('#editReplyMessage').val();
                var feedbackId = $('#feedbackId').val();
                $.ajax({
                    url: "{{ route('updateCustomerReply') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        feedbackId: feedbackId,
                        editedReplyMessage: editedReplyMessage
                    },
                    success: function(response) {
                        $('#editReplyModal').modal('hide');
                        swal.fire({
                            title: 'Send!',
                            text: 'Feedback Replied Send.',
                            icon: 'success',
                            timer: 2000
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
