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

        /* .dt-search label,
        input {
            transform: translateY(-30px);
        } */

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
        div.dt-container .dt-length{
            display: none !important;
        }
        #userTable_length{
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css">
@endsection
@section('content')
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">User Profile</h2>

    </div>

    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-user') }}" method="post">
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
                            <button class="btn btn-primary position-absolute btn-style-apply" onclick="filterByDate()"
                                type="submit" style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('user-profile') }}" class="btn btn-primary position-absolute "
                                onclick="clearFilter()" style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
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
                    <table class="display mb-2 text-black pt-4" id="userTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>S No.</th>
                                <th>Prof Img</th>
                                <th>CIN No</th>
                                <th>Join Date</th>
                                <th>Name</th>
                                <th>Phone-Number</th>
                                <th>Email</th>
                                <th>Category</th>
                                {{-- <th>Pin Code</th> --}}
                                {{-- <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Coordinates</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr data-customer-id="{{ $customer->id }}">
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;"><a href="{{ isset($customer->photo)?asset($customer->photo):asset('images/profile/User Image.png') }}" target="_blank"
                                            rel="noopener noreferrer"><img class="rounded-circle" width="35" height="25"
                                                src="{{ isset($customer->photo)?asset($customer->photo):asset('images/profile/User Image.png') }}" alt="No"></a></td>
                                    <td style="text-align: center;">{{ $customer->cin_no }}</td>
                                    <td style="text-align: center;" class="wspace-no">
                                        {{ $customer->created_at->format('d/m/y') }}</td>
                                    <td style="text-align: center;">{{ $customer->name }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $customer->phone_number }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $customer->email }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $customer->category }}</td>
                                    {{-- <td style="text-align: center;" class="text-ov">{{ $customer->pincode }}</td> --}}
                                    {{-- <td style="text-align: justify;" class="text-ov">{{ $customer->state }}</td> --}}
                                    {{-- <td style="text-align: justify;" class="text-ov">{{ $customer->city }}</td> --}}
                                    {{-- <td style="text-align: justify;" class="text-ov">{{ $customer->address }}</td> --}}
                                    {{-- <td style="text-align: justify;" class="text-ov">{{ $customer->coordinates }}</td> --}}
                                    <td>
                                        <div class="d-flex">
                                            {{-- <button class="btn btn-primary view-more-btn" data-toggle="modal" data-target="#customerDetailsModal">View More</button> --}}
                                            <div class="view-more-btn"><i
                                                    style="color:blue;padding-right: 10px;margin-top:10px;cursor: pointer;"
                                                    class="fas fa-eye"></i></div>
                                            {{-- <input type="checkbox" class="statusSwitch"
                                            {{ $customer->status === 'active' ? 'checked' : '' }}
                                            data-toggle="switchbutton" data-onlabel="Active" data-offlabel="Block"
                                            data-onstyle="success" data-offstyle="danger"> --}}
                                            <input class="statusSwitch" style="transform: translateY(0px);"
                                                {{ $customer->status === 'active' ? 'checked' : '' }} type="checkbox">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_length" id="userTable_length" style="display: flex; align-items: center;">
                        <label for="userTable_length" style="margin-right: 10px;">Show</label>
                        <select name="userTable_length" aria-controls="userTable" class="form-select form-select-sm" style="width: 9%;">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="userTable_length" style="margin-left: 10px;">entries</label>
                    </div>
                </div>
            </div>
            {{-- {{ $customers->links() }} --}}
        </div>
    </div>
    <div class="modal fade" id="customerDetailsModal" tabindex="-1" aria-labelledby="customerDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerDetailsModalLabel">Customer Details</h5>
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
            $('#userTable').DataTable({
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
                lengthMenu: false,
            });
            $('#userTable_length select').change(function() {
                var length = $(this).val();
                $('#userTable').DataTable().page.len(length).draw();
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var viewMoreButtons = document.querySelectorAll('.view-more-btn');
            viewMoreButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var currentRow = this.closest('tr');
                    var customerId = currentRow.getAttribute('data-customer-id');
                    var baseUrl = "{{ route('get-customer', ['id' => '__id__']) }}";
                    var customerDetailsUrl = baseUrl.replace('__id__', customerId);

                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', customerDetailsUrl);
                    xhr.onload = function() {
                        if (xhr.status === 200) {
                            var data = JSON.parse(xhr.responseText);
                            document.getElementById('customer-whatsapp-number').textContent =
                                data.landmark || 'Not Available';
                            document.getElementById('customer-address').textContent = data
                                .address || 'Not Available';
                            document.getElementById('customer-pincode').textContent = data
                                .pincode || 'Not Available';
                            document.getElementById('customer-city').textContent = data.city ||
                                'Not Available';
                            document.getElementById('customer-state').textContent = data
                                .state || 'Not Available';
                            document.getElementById('customer-longitude').textContent = data
                                .longitude || 'Not Available';
                            document.getElementById('customer-latitude').textContent = data
                                .latitude || 'Not Available';
                            document.getElementById('customer-category').textContent = data
                                .category || 'Not Available';
                            // Show the modal
                            var modal = document.getElementById('customerDetailsModal');
                            var modalInstance = new bootstrap.Modal(modal);
                            modalInstance.show();
                        } else {
                            console.error('Error fetching customer details. Status:', xhr
                                .status);
                            // Handle errors appropriately (e.g., display an error message to the user)
                        }
                    };
                    xhr.onerror = function() {
                        console.error('Error fetching customer details. Network error.');
                        // Handle errors appropriately (e.g., display an error message to the user)
                    };
                    xhr.send();
                });
            });
        });
    </script>
    <script>
        $('.statusSwitch').on('change', function() {
            var isChecked = $(this).prop('checked');
            var status = isChecked ? 'active' : 'inactive';
            var currentRow = $(this).closest('tr');
            var customerId = currentRow.data('customer-id');
            // AJAX request to update status
            $.ajax({
                url: '{{ route('update-status') }}',
                method: 'POST',
                data: {
                    status: status,
                    customer: customerId,
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
