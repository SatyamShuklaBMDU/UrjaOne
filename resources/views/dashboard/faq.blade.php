    @extends('include.master')
    @section('style')
        <style>
            div#example3_filter {
                display: none !important;
            }

            .switch-on {
                margin: -7px !important;
                left: -16px !important;
            }

            .switch-off {
                margin: -7px !important;
                left: 58% !important;
            }

            .switch {
                width: 80px !important;
                height: 30px !important;
            }
        </style>
    @endsection
    @section('content')
        <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">All FAQs</h2>
        </div>
        <div class="justify-content-between align-items-center mb-4">
            <div class="row">
                <div class="col-md-7">
                    <div class=" align-items-center">
                        <div id="datePickerContainer">
                            <form action="{{ route('filter-faq') }}" method="post">
                                @csrf
                                <div>
                                    <input type="date" name="startDate" id="startDate" class="form-control @error('startDate') is-invalid @enderror input-primary-active shadow-sm" value="{{ $start ?? '' }}">
                                </div>
                                <div>
                                    <input type="date" name="endDate" id="endDate" class="form-control @error('endDate') is-invalid @enderror input-primary-active shadow-sm" value="{{ $end ?? '' }}">
                                </div>
                                <button class="btn btn-primary position-absolute btn-style-apply" type="submit" style="right:135px; bottom: 2px;">Apply</button>
                                <a href="{{ route('faq-index') }}" class="btn btn-primary position-absolute "style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-1">
                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#basicModal2" style="width: 40px;height: 40px;text-align: center;font-size: 23px;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height:normal;">+</a>
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
                                        <th>Update Date, Time</th>
                                        <th>FAQ Title</th>
                                        <th>FAQ Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($faqs as $faq)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $faq->created_at->timezone('Asia/Kolkata')->format('d F Y, h:i A') }}
                                            </td>
                                            <td>{{ $faq->updated_at->timezone('Asia/Kolkata')->format('d F Y, h:i A') }}
                                            </td>
                                            <td>{{ $faq->title }}</td>
                                            <td>{{ $faq->description }}</td>
                                            <td>
                                                <input type="checkbox" class="statusSwitch"
                                                    {{ $faq->status == '1' ? 'checked' : '' }} data-toggle="switchbutton"
                                                    data-onlabel="Show" data-offlabel="Hide" data-onstyle="success"
                                                    data-offstyle="danger" data-faq-id="{{ $faq->id }}">
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                        data-bs-toggle="modal" data-bs-target="#basicModal"><i
                                                            data-faq-id="{{ $faq->id }}"
                                                            class="fas fa-pencil-alt editBtn"></i></a>
                                                    <button class="btn btn-danger shadow btn-xs sharp deleteBtn"
                                                        data-faq-id="{{ $faq->id }}"><i
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
        <div class="modal fade" id="basicModal2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h2">Add FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form class="" id="addFAQForm">
                            <div class="mb-3">
                                <label for="faqTitle" class="form-label text-dark fw-bold h5">FAQ Title</label>
                                <input type="text" class="form-control border-dark" id="faqTitle"
                                    placeholder="Enter FAQ Title">
                                <small class="text-primary h6">(e.g., How to use our product)</small>
                            </div>
                            <div class="mb-3">
                                <label for="faqDescription" class="form-label text-dark fw-bold h5">FAQ Description</label>
                                <textarea class="form-control border-dark" id="faqDescription" rows="3" placeholder="Enter FAQ Description"></textarea>
                                <small class="text-primary h6">(Provide a brief description of the FAQ)</small>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="saveFAQBtn" class="btn btn-primary h6">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title h2">Edit FAQ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editFAQForm">
                            <input type="hidden" id="editFaqId" name="editFaqId">
                            <div class="mb-3">
                                <label for="editFaqTitle" class="form-label text-dark fw-bold h5">FAQ Title</label>
                                <input type="text" class="form-control border-dark" id="editFaqTitle"
                                    placeholder="Enter FAQ Title">
                                <small class="text-primary h6">(e.g., How to use our product)</small>
                            </div>
                            <div class="mb-3">
                                <label for="editFaqDescription" class="form-label text-dark fw-bold h5">FAQ
                                    Description</label>
                                <textarea class="form-control border-dark" id="editFaqDescription" rows="3"
                                    placeholder="Enter FAQ Description"></textarea>
                                <small class="text-primary h6">(Provide a brief description of the FAQ)</small>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="updateFAQBtn" class="btn btn-primary h6">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('script')
        <script>
            document.getElementById("saveFAQBtn").addEventListener("click", function() {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var title = document.getElementById("faqTitle").value;
                var description = document.getElementById("faqDescription").value;
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('faqs-store') }}", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.setRequestHeader("X-CSRF-Token", csrfToken);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        $('#basicModal2').modal('hide');
                        location.reload();
                    }
                };
                var data = JSON.stringify({
                    title: title,
                    description: description,

                });
                xhr.send(data);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.statusSwitch').forEach(function(switchButton) {
                    switchButton.addEventListener('change', function() {
                        var status = this.checked ? 1 : 0; // 1 for active, 0 for inactive
                        var faqId = this.dataset.faqId;
                        updateStatus(faqId, status);
                    });
                });
            });

            function updateStatus(faqId, status) {
                var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var url = "{{ route('update-faq-status') }}";
                var data = {
                    _token: token,
                    faq_id: faqId,
                    status: status
                };

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-Token': token
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Status updated successfully'
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred'
                        });
                    });
            }
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Edit button click event
                document.querySelectorAll('.editBtn').forEach(function(editButton) {
                    editButton.addEventListener('click', function() {
                        var faqId = this.dataset.faqId;
                        fetchFaqDetails(faqId);
                    });
                });
            });

            function fetchFaqDetails(faqId) {
                var url = "{{ route('faq-details', ':faqId') }}".replace(':faqId', faqId);
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editFaqId').value = data.id;
                        document.getElementById('editFaqTitle').value = data.title;
                        document.getElementById('editFaqDescription').value = data.description;
                        $('#editModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>
        <script>
            document.getElementById("updateFAQBtn").addEventListener("click", function() {
                var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                var faqId = document.getElementById("editFaqId").value;
                var title = document.getElementById("editFaqTitle").value;
                var description = document.getElementById("editFaqDescription").value;

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "{{ route('update-faq') }}", true);
                xhr.setRequestHeader("Content-Type", "application/json");
                xhr.setRequestHeader("X-CSRF-Token", csrfToken);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        $('#editModal').modal('hide');
                        location.reload();
                    }
                };
                var data = JSON.stringify({
                    faq_id: faqId,
                    title: title,
                    description: description
                });
                xhr.send(data);
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                    deleteButton.addEventListener('click', function() {
                        var faqId = this.dataset.faqId;
                        swal.fire({
                            title: 'Are you sure?',
                            text: 'You will not be able to recover this FAQ!',
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
                var url = "{{ route('faq-delete', ':faqId') }}".replace(':faqId', faqId);
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
                            text: 'The FAQ has been deleted.',
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
