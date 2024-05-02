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
    </style>
@endsection
@section('content')
    <div class="mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">User Profile</h2>

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
                                    class="form-control @error('startDate') is-invalid @enderror input-primary-active shadow-sm" value="{{ $start ?? '' }}">
                            </div>
                            <div>
                                <input type="date" name="endDate" id="endDate"
                                    class="form-control @error('endDate') is-invalid @enderror input-primary-active shadow-sm" value="{{ $end ?? '' }}">
                            </div>
                            <button class="btn btn-primary position-absolute btn-style-apply" onclick="filterByDate()"
                                type="submit" style="right:135px; bottom: 2px;">Apply</button>
                            <a href="{{ route('user-profile') }}" class="btn btn-primary position-absolute "
                                onclick="clearFilter()" style="right:46px; bottom: 2px;"><i class="fas fa-sync"></i></a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-5 d-flex justify-content-end">
                <div class="customer-search mb-sm-0 mb-3">
                    <div class="input-group search-area">
                        <input type="text" class="form-control" placeholder="Search here......">
                        <span class="input-group-text"><a href="javascript:void(0)"><i
                                    class="flaticon-381-search-2"></i></a></span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 card">
            <div class="table-responsive">
                <table class="table display mb-4 dataTablesCard order-table shadow-hover  card-table text-black"
                    id="example7">
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
                            <th>Pin Code</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Address</th>
                            <th>Coordinates</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr data-customer-id="{{ $customer->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td><img class="rounded-circle" width="35" src="{{ asset($customer->photo) }}"
                                        alt="No"></td>
                                <td>{{ $customer->cin_no }}</td>
                                <td class="wspace-no">{{ $customer->created_at->format('d/m/y') }}</td>
                                <td>{{ $customer->name }}</td>
                                <td class="text-ov">+91{{ $customer->phone_number }}</td>
                                <td class="text-ov">{{ $customer->email }}</td>
                                <td class="text-ov">{{ $customer->category }}</td>
                                <td class="text-ov">{{ $customer->pincode }}</td>
                                <td class="text-ov">{{ $customer->state }}</td>
                                <td class="text-ov">{{ $customer->city }}</td>
                                <td class="text-ov">{{ $customer->address }}</td>
                                <td class="text-ov">{{ $customer->coordinates }}</td>
                                <td>
                                    <select name="status" id="status" class="custom-select bg-success">
                                        <option value="accept" class="text-success">Accept</option>
                                        <option value="block" class="text-danger">Block</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function changestatus() {

        }
    </script>
    <script>
        var currentPage = window.location.pathname;
        var isUserProfile = currentPage.includes('user-profile.html');
        var isVendorProfile = currentPage.includes('vendor-profile.html');

        if (isUserProfile || isVendorProfile) {
            document.querySelector('.profile-menu').classList.add('active');
        }
    </script>
    <script>
        document.getElementById('status').addEventListener('change', function() {
            var selectElement = this;
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var selectedValue = selectedOption.value;

            if (selectedValue === 'accept') {
                selectElement.classList.remove('bg-danger');
                selectElement.classList.add('bg-success');
            } else if (selectedValue === 'block') {
                selectElement.classList.remove('bg-success');
                selectElement.classList.add('bg-danger');
            }
        });
        document.getElementById('status2').addEventListener('change', function() {
            var selectElement = this;
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var selectedValue = selectedOption.value;

            if (selectedValue === 'accept') {
                selectElement.classList.remove('bg-danger');
                selectElement.classList.add('bg-success');
            } else if (selectedValue === 'block') {
                selectElement.classList.remove('bg-success');
                selectElement.classList.add('bg-danger');
            }
        });
    </script>
    <script>
        function filterByDate() {
            var startDate = document.getElementById("startDate").value;
            var endDate = document.getElementById("endDate").value;
            console.log("Start Date:", startDate);
            console.log("End Date:", endDate);
        }
        document.getElementById("dateFilterButton").addEventListener("click", function() {
            var datePickerContainer = document.getElementById("datePickerContainer");
            if (datePickerContainer.style.display === "none") {
                datePickerContainer.style.display = "block";
            } else {
                datePickerContainer.style.display = "none";
            }
        });

        function clearFilter() {
            document.getElementById("startDate").value = "";
            document.getElementById("endDate").value = "";
        }
        document.querySelector('#datePickerContainer button:nth-child(3)').addEventListener('click', clearFilter);
    </script>
    <script>
        let table = new DataTable('#example7');
    </script>
@endsection
