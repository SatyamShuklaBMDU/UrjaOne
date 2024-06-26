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
        <h2 class="mb-2 me-auto">All Quotations</h2>
    </div>

    <div class="justify-content-between align-items-center mb-1">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <p style="font-size: 20px;color: black;">Lead No:<strong>{{ $Did }}</strong></p>
                    </div>
                </div>
            </div>
            {{-- <div class="col-md-5 d-flex justify-content-end">
                <div class="enquiry-search mb-sm-0 mb-3">
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
                                <th style="text-align: center;">S No.</th>
                                <th style="text-align: center;">Date</th>
                                <th style="text-align: center;">Quotation No.</th>
                                <th style="text-align: center;">CIN No</th>
                                <th style="text-align: center;">Name</th>
                                <th style="text-align: center;">Phone-Number</th>
                                <th style="text-align: center;">Price Per <strong>(KW)</strong></th>
                                <th style="text-align: center;">Panel Warranty</th>
                                <th style="text-align: center;">Inverter Warranty</th>
                                <th style="text-align: center;">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quoatations as $enquiry)
                                <tr data-quotation-id="{{ $enquiry->id }}">
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;" class="wspace-no">
                                        {{ $enquiry->created_at->format('d/m/y') }}</td>
                                    <td style="text-align: center;">{{ $enquiry->quotation_no }}</td>
                                    <td style="text-align: center;">{{ $enquiry->vendor->cin_no }}</td>
                                    <td style="text-align: center;">{{ $enquiry->vendor->name }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $enquiry->vendor->phone_number }}
                                    </td>
                                    <td style="text-align: center;" class="text-ov">{{ $enquiry->price_per_kw }}</td>
                                    <td style="text-align: center;" class="text-ov">{{ $enquiry->panel_warranty }}</td>
                                    <td style="text-align: center;"><a>{{ $enquiry->inverter_warranty }}</a>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="d-flex">
                                            <div class="view-more-btn"><a class="btn btn-primary"
                                                    style="padding: 0.375rem 0.75rem;border-radius: 0.75rem;font-size: 0.875rem;"
                                                    onclick="fetchEnquiryDetails({{ $enquiry->id }})"
                                                    role="button">View</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_length" id="userTable_length">
                        <label for="userTable_length">Show
                            <select name="userTable_length" aria-controls="userTable" class="form-select form-select-sm">
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
            {{-- {{ $enquirys->links() }} --}}
        </div>
    </div>
    <div class="modal fade" id="enquiryDetailsModal" tabindex="-1" aria-labelledby="enquiryDetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="enquiryDetailsModalLabel">Enquiry Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><b>AC Cable Brand:</b> <span id="ac_cable_brand"></span></p>
                    <p><b>DC Cable Brand:</b> <span id="dc_cable_brand"></span></p>
                    <p><b>Earthing:</b> <span id="earthing"></span></p>
                    <p><b>MMS Structure:</b> <span id="mms_structure"></span></p>
                    <p><b>Metering Support:</b> <span id="metering_support"></span></p>
                    <p><b>Subsidy Support:</b> <span id="subsidy_support"></span></p>
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
                lengthMenu: false, // Optional: specify the page length options
            });
            $('#userTable_length select').change(function() {
                var length = $(this).val();
                $('#userTable').DataTable().page.len(length).draw();
            });
        });
    </script>
    <script>
        function fetchEnquiryDetails(enquiryId) {
            $.ajax({
                url: '{{ url('/quotation-details/') }}' + '/' + enquiryId,
                type: 'GET',
                success: function(response) {
                    $('#subsidy_support').text(response.subsidy_support === '1' ? 'Yes' : 'No');
                    $('#metering_support').text(response.metering_support === '1' ? 'Yes' : 'No');
                    $('#ac_cable_brand').text(response.ac_cable_brand);
                    $('#dc_cable_brand').text(response.dc_cable_brand);
                    $('#earthing').text(response.earthing);
                    $('#mms_structure').text(response.mms_structure);
                    $('#enquiryDetailsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection
