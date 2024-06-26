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

        div.dt-container .dt-length {
            display: none !important;
        }

        #userTable_length {
            margin-top: 10px;
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
        <h2 class="mb-2 me-auto">Vendor Profile</h2>

    </div>

    <div class="justify-content-between align-items-center mb-3">
        <div class="row">
            <div class="col-md-7">
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
                            <button class="btn btn-primary position-absolute btn-style-apply" type="submit"
                                style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('vendor-profile') }}" class="btn btn-primary position-absolute "
                                style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
                        </form>
                    </div>

                </div>
            </div>

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
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table display mb-4 dataTablesCard order-table card-table text-black" id="example7">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Prof Img</th>
                                <th>CIN No</th>
                                <th>Join Date</th>
                                <th>Company</th>
                                <th>Name</th>
                                <th>Phone-Number</th>
                                <th>Email</th>
                                {{-- <th>Category</th>
                            <th>Pin Code</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Coordinates</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vendors as $vendor)
                                <tr data-vendor-id={{ $vendor->id }}>
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;"><a
                                            href="{{ isset($vendor->photo) ? asset($vendor->photo) : asset('images/profile/Vendor Image.png') }}"
                                            target="_blank" rel="noopener noreferrer"><img class="rounded-circle"
                                                width="35"
                                                src="{{ isset($vendor->photo) ? asset($vendor->photo) : asset('images/profile/Vendor Image.png') }}"
                                                alt></a></td>
                                    <td style="text-align: center;">{{ $vendor->cin_no }}</td>
                                    <td style="text-align: center;" class="wspace-no">
                                        {{ $vendor->created_at->format('d/m/y') }}
                                    </td>
                                    <td style="text-align: center;">{{ $vendor->company_name }}</td>
                                    <td style="text-align: center;">{{ $vendor->name }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $vendor->phone_number }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $vendor->email }}</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="eyeViewMore"><i
                                                    style="color:blue;padding-right: 10px;margin-top:10px;cursor: pointer;"
                                                    class="fas fa-eye"></i></div>
                                            <a style="padding-right: 10px;margin-top:7px;cursor: pointer;"
                                                href="{{ route('image-verification', encrypt($vendor->id)) }}">KYC</a>
                                            <input class="statusSwitch" style="transform: translateY(0px);"
                                                {{ $vendor->status === 'active' ? 'checked' : '' }} type="checkbox">
                                            {{-- <input type="checkbox" class="statusSwitch"
                                            {{ $vendor->status === 'active' ? 'checked' : '' }} data-toggle="switchbutton"
                                            data-onlabel="Active" data-offlabel="Block" data-onstyle="success"
                                            data-offstyle="danger"> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_length" id="example7_length" style="display: flex; align-items: center;">
                        <label for="userTable_length" style="margin-right: 10px;">Show</label>
                        <select name="userTable_length" aria-controls="userTable" class="form-select form-select-sm"
                            style="width: 9%; margin-right: 10px;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="userTable_length">entries</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Vendor Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>Landmark:</b> <span id="customer-whatsapp-number"></span></p>
                    <p><b>Address:</b> <span id="customer-address"></span></p>
                    <p><b>Pincode:</b> <span id="customer-pincode"></span></p>
                    <p><b>City:</b> <span id="customer-city"></span></p>
                    <p><b>State:</b> <span id="customer-state"></span></p>
                    <p><b>Longitude:</b> <span id="customer-longitude"></span></p>
                    <p><b>Latitude:</b> <span id="customer-latitude"></span></p>
                    <p><b>Category:</b> <span id="customer-category"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example7').DataTable({
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
                // lengthMenu: [10, 25, 50, 100], // Optional: specify the page length options
            });
            $('#example7_length select').change(function() {
                var length = $(this).val();
                $('#example7').DataTable().page.len(length).draw();
            });
            $('.eyeViewMore').on('click', function() {
                var currentRow = $(this).closest('tr');
                var customerId = currentRow.data('vendor-id');
                var baseUrl = "{{ route('get-vendor', ['id' => '__id__']) }}";
                var customerDetailsUrl = baseUrl.replace('__id__', customerId);
                $.ajax({
                    url: customerDetailsUrl,
                    type: 'GET',
                    success: function(data) {
                        console.log(data.whatsapp_number);
                        $('#customer-whatsapp-number').text(data.landmark || 'Not Available');
                        $('#customer-address').text(data.address || 'Not Available');
                        $('#customer-pincode').text(data.pincode || 'Not Available');
                        $('#customer-city').text(data.city || 'Not Available');
                        $('#customer-state').text(data.state || 'Not Available');
                        $('#customer-latitude').text(data.latitude || 'Not Available');
                        $('#customer-longitude').text(data.longitude || 'Not Available');
                        $('#customer-category').text(data.category || 'Not Available');
                        $('#customerDetailsModal').modal('show');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching customer details:', textStatus,
                            errorThrown);
                        // Handle errors appropriately (e.g., display an error message to the user)
                    }
                });
            });
        });
    </script>
    <script>
        $('.statusSwitch').on('change', function() {
            var isChecked = $(this).prop('checked');
            var status = isChecked ? 'active' : 'inactive';
            var currentRow = $(this).closest('tr');
            var vendorId = currentRow.data('vendor-id');
            $.ajax({
                url: '{{ route('update-status-vendor') }}',
                method: 'POST',
                data: {
                    status: status,
                    vendor: vendorId,
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
