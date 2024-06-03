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

        div.dt-container .dt-length {
            display: none !important;
        }

        #userTable_length {
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection
@section('content')
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">All Plans</h2>
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
                                style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('all-role') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 2px;"><i
                                    class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <a href="{{ route('add-plans') }}" class="btn btn-primary mb-2 btn-rounded"
                    style="margin-left: 27rem;"><span class="text-white fw-bold">
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
                                    <th style="text-align: center;">Plan Name</th>
                                    <th style="text-align: center;">Plan Image</th>
                                    <th style="text-align: center;">Plan Details</th>
                                    <th style="text-align: center;">Plan Amount</th>
                                    <th style="text-align: center;">Valid Upto</th>
                                    <th style="text-align: center;">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($plans as $plan)
                                    <tr data-plan-id="{{ $plan->id }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $plan->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $plan->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td><a href="javascript:void(0);"><strong>{{ $plan->name }}</strong></a></td>
                                        <td style="text-align: center;"><a href="{{ asset($plan->image) }}" target="_blank"
                                                rel="noopener noreferrer"><img style="height: 100px; width: 100px;"
                                                    src="{{ asset($plan->image) }}" class="img-thumbnail"
                                                    alt="..."></a></td>
                                        <td style="text-align: center;">{!! $plan->description !!}</td>
                                        <td style="text-align: center;">{{ $plan->price }}</td>
                                        <td style="text-align: center;">{{ $plan->duration }}</td>
                                        <td style="text-align: center;">
                                            <input class="statusSwitch" style="transform: translateY(0px);"
                                                {{ $plan->status == '1' ? 'checked' : '' }} type="checkbox">
                                        </td>
                                        <td style="text-align: center;">
                                            <div class="d-flex">
                                                <a class="btn btn-primary shadow btn-xs sharp me-1 editModal"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"
                                                    data-id="{{ $plan->id }}" data-name="{{ $plan->name }}"
                                                    data-price="{{ $plan->price }}"
                                                    data-description="{{ $plan->description }}"
                                                    data-category="{{ $plan->category }}" data-area="{{ $plan->area }}"
                                                    data-load="{{ $plan->load }}" onclick="editBlog(this)">
                                                    <i class="fas fa-pencil-alt"></i></a>
                                                <button class="btn btn-danger shadow btn-xs sharp deleteBtn"
                                                    data-plan-id="{{ $plan->id }}"><i
                                                        class="fa fa-trash "></i></button>
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
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Blog</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>
                </div>
                <form action="{{ route('update-plans') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" name="planId" id="planId" value="">
                        <div class="mb-3">
                            <label for="name" class="form-label text-dark fw-bold h5">Name</label>
                            <input type="text" name="name" class="form-control border-dark" id="name"
                                placeholder="Enter Name">
                        </div>
                        <div class="mb-3">
                            <label for="kilowatt" class="form-label text-dark fw-bold h5">Plan Load
                                <strong>(KW)</strong></label>
                            <input type="number" name="load" class="form-control border-dark" id="kilowatt"
                                placeholder="Enter Plan Load">
                        </div>
                        <div class="mb-3">
                            <label for="Area" class="form-label text-dark fw-bold h5">Plan Area</label>
                            <div class="row mx-3">
                                <div class="col-md-6 mt-1" style="border-right:1px solid black;">
                                    <input type="checkbox" value="vendor_state" id="area_vendor_state"
                                        name="area[]">&emsp;
                                    <label for="area_vendor_state" class="fw-bold">Vendor State</label>
                                </div>
                                <div class="col-md-6 mt-1">
                                    <input type="checkbox" value="pan_india" id="area_pan_india" name="area[]">&emsp;
                                    <label for="area_pan_india" class="fw-bold">Pan India</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label text-dark fw-bold h5">Plan Category</label>
                            <select name="category[]" id="category" class="form-control border-dark" multiple>
                                <option value="residential">Residential</option>
                                <option value="commercial">Commercial</option>
                                <option value="industrial">Industrial</option>
                                <option value="agricultural">Agricultural</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label text-dark fw-bold h5">image</label>
                            <input type="file" name="image" class="form-control border-dark" id="image">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label text-dark fw-bold h5">Amount</label>
                            <input type="text" name="price" class="form-control border-dark" id="price"
                                placeholder="Enter Amount">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label text-dark fw-bold h5">Description</label>
                            <textarea name="description" id="plandescriptionEditor" class="form-control border-dark" cols="30"
                                rows="10"></textarea>
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
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = new Choices('#category', {
                removeItemButton: true,
                allowHTML: true
            });
            window.editBlog = function editBlog(button) {
                var planId = button.getAttribute('data-id');
                var planName = button.getAttribute('data-name');
                var planPrice = button.getAttribute('data-price');
                var planDescription = button.getAttribute('data-description') || ''; // Handle null
                var planCategory = button.getAttribute('data-category') ? JSON.parse(button.getAttribute('data-category')) : [];
                var planArea = button.getAttribute('data-area') ? JSON.parse(button.getAttribute('data-area')) : [];
                var planLoad = button.getAttribute('data-load') || '';
                var nameInput = document.getElementById('name');
                var priceInput = document.getElementById('price');
                var planIdInput = document.getElementById('planId');
                var loadInput = document.getElementById('kilowatt');
                var descriptionEditor = CKEDITOR.instances['plandescriptionEditor'];
                if (planIdInput) planIdInput.value = planId;
                if (nameInput) nameInput.value = planName;
                if (priceInput) priceInput.value = planPrice;
                if (loadInput) loadInput.value = planLoad;
                if (descriptionEditor) {
                    descriptionEditor.setData(planDescription);
                } else {
                    CKEDITOR.replace('plandescriptionEditor', {
                        on: {
                            instanceReady: function(evt) {
                                evt.editor.setData(planDescription);
                            }
                        }
                    });
                }
                categorySelect.removeActiveItems();
                categorySelect.setChoiceByValue(planCategory);
                var areaCheckboxes = document.querySelectorAll('[name="area[]"]');
                if (areaCheckboxes) {
                    areaCheckboxes.forEach(checkbox => checkbox.checked = false);
                }
                planArea.forEach(area => {
                    let checkbox = document.getElementById('area_' + area);
                    if (checkbox) {
                        checkbox.checked = true;
                    }
                });
            }
            CKEDITOR.replace('plandescriptionEditor');
            document.querySelector('form').addEventListener('submit', function() {
                for (var instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
            });
            document.querySelectorAll('.editModal').forEach(button => {
                button.addEventListener('click', function() {
                    window.editBlog(button);
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                dom: '<"top"Blf>rtp<"bottom"i><"clear">',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                },
                lengthMenu: false,
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
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var roleId = this.dataset.planId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Plan!',
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
            var url = "{{ route('plan-delete', ':roleId') }}".replace(':roleId', roleId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Plan');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Plan has been deleted.',
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
                        text: 'Failed to delete Plan.',
                        icon: 'error'
                    });
                });
        }
    </script>
    <script>
        $('.statusSwitch').on('change', function() {
            var isChecked = $(this).prop('checked');
            var status = isChecked ? '1' : '0';
            var currentRow = $(this).closest('tr');
            var planId = currentRow.data('plan-id');
            // AJAX request to update status
            $.ajax({
                url: '{{ route('update-plan-status') }}',
                method: 'POST',
                data: {
                    status: status,
                    plan: planId,
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
@endsection
