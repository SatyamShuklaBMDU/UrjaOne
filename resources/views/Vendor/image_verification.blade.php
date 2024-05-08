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

        select {
            margin: 10px;
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing,
        div.dt-container .dt-paging {
            color: black !important;
        }
    </style>
@endsection
@section('content')
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 mt-4 me-auto">KYC Verification</h2>

    </div>

    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            {{-- <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-vendor') }}" method="post">
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
                            <button class="btn btn-primary position-absolute btn-style-apply" type="submit" style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('vendor-profile') }}" class="btn btn-primary position-absolute " style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div> --}}
            {{-- <div class="col-md-5 d-flex justify-content-end">
                <div class="customer-search mb-sm-0 mb-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here......">
                        <span class="input-group-text"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 card">
            <div class="table-responsive">
                <table class="table display mb-4 dataTablesCard order-table card-table text-black" id="example7">
                    <thead>
                        <tr>
                            <th style="text-align: center;">S No.</th>
                            <th style="text-align: center;">CIN No</th>
                            <th style="text-align: center;">Name</th>
                            <th style="text-align: center;">Title</th>
                            <th style="text-align: center;">Image</th>
                            <th style="text-align: center;">Number</th>
                            <th style="text-align: center;">Action</th>
                            <th style="text-align: center;">Remark</th>
                        </tr>
                    </thead>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td style="text-align: center;">{{ $loop->iteration }}</td>
                            <td style="text-align: center;">{{ $vendor->VendorDetail->cin_no }}</td>
                            <td style="text-align: center;">{{ $vendor->VendorDetail->name }}</td>
                            <td style="text-align: center;">{{ $vendor->title }}</td>
                            <td style="text-align: center;"><a href="{{ asset($vendor->image) }}" target="_blank"
                                    rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                        src="{{ asset($vendor->image) }}" alt></a></td>
                            <td style="text-align: center;">{{ $vendor->number }}</td>
                            <td>
                                <select class="verification" data-vendor-id="{{ $vendor->id }}">
                                    <option class="text-dark">Please select</option>
                                    <option class="bg-danger text-light" {{ $vendor->status == '-1' ? 'selected' : '' }}
                                        value="-1">Not Valid</option>
                                    <option class="bg-success text-light" {{ $vendor->status == '1' ? 'selected' : '' }}
                                        value="1">Valid</option>
                                </select>
                            </td>
                            <td style="text-align: center">{{ $vendor->remark ?? '--' }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="notValidModal" tabindex="-1" aria-labelledby="notValidModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notValidModalLabel">Reason for Invalidity</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="invalidReasonForm">
                        <div class="mb-3">
                            <label for="reason" class="form-label">Reason why this is not valid:</label>
                            <input type="hidden" name="imageId" id="imageId">
                            <textarea class="form-control" name="remark" id="reason" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitReason">Submit Reason</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example7').DataTable({
                searching: true,
                paging: true,
                select: true,
                info: true,
                lengthChange: false,
                language: {
                    "lengthMenu": "<span class='menu-spacing'>_MENU_</span> Per Page",
                    paginate: {
                        previous: '<i class="fas fa-angle-double-left"></i>',
                        next: '<i class="fas fa-angle-double-right"></i>'
                    }
                }
            });
            function setSelectedColor(selectElement) {
                var selectedOption = $(selectElement).find('option:selected');
                var bgColor = selectedOption.css('background-color');
                var textColor = selectedOption.css('color');
                selectedOption.css('background-color', bgColor);
                selectedOption.css('color', textColor);
            }
            $('.verification').each(function() {
                setSelectedColor(this);
            });
            $('.verification').change(function() {
                setSelectedColor(this);
                var vendorId = $(this).data('vendor-id');
                var status = $(this).val();
                var reason = null;
                if (status == '-1') {
                    $('#invalidReasonForm').find('input[name="imageId"]').val(vendorId);
                    $('#notValidModal').modal('show');
                } else if (status == '1') {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('image-remark') }}',
                        data: {
                            imageId: vendorId,
                            remark: reason,
                            status: status,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Status updated successfully!',
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'An error occurred while updating the status!',
                            });
                        }
                    });
                }
            });

            $('#submitReason').click(function(e) {
                e.preventDefault();
                var vendorId = $('#imageId').val();
                var status = $(this).val();
                var reason = $('#reason').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('image-remark') }}',
                    data: {
                        imageId: vendorId,
                        remark: reason,
                        status: '-1',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#notValidModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Status updated successfully!',
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'An error occurred while updating the status!',
                        });
                    }
                });
            });
        });
    </script>
@endsection
