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
                    {{-- <div id="datePickerContainer">
                        <form action="{{ route('filter-enquiry') }}" method="post">
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
                                type="submit" style="right:135px; bottom: 28px;">Apply</button>
                            <a href="{{ route('get-quotation') }}" class="btn btn-primary position-absolute "
                                onclick="clearFilter()" style="right:46px; bottom: 28px;"><i class="fas fa-sync"></i></a>
                        </form>
                    </div> --}}
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
                                <th style="text-align: center;">Action</th>
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
                                    <td style="text-align: center;"><a href="">{{ $enquiry->inverter_warranty }}</a>
                                    </td>
                                    <td style="text-align: center;">
                                        <div class="d-flex">
                                            {{-- <div class="view-more-btn"><i
                                                    style="color:blue;padding-right: 10px;margin-top:10px;cursor: pointer;"
                                                    class="fas fa-eye"
                                                    onclick="fetchEnquiryDetails({{ $enquiry->id }})"></i></div> --}}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <p><b>Subsidy:</b> <span id="enquiry-subsidy"></span></p>
                    <p><b>Finance:</b> <span id="enquiry-finance"></span></p>
                    <p><b>Structure Type:</b> <span id="enquiry-structure-type"></span></p>
                    <p><b>Solar Panel Type:</b> <span id="enquiry-solar-panel"></span></p>
                    <p><b>Panel Brands:</b> <span id="enquiry-panel-brands"></span></p>
                    <p><b>Inverter Brands:</b> <span id="enquiry-brands"></span></p>
                    <p><b>Book Time:</b> <span id="enquiry-time"></span></p>
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
                lengthMenu: [10, 25, 50, 100], // Optional: specify the page length options
            });
        });
    </script>
    <script>
        function fetchEnquiryDetails(enquiryId) {
            $.ajax({
                url: '{{ url('/enquiry-details/') }}' + '/' + enquiryId,
                type: 'GET',
                success: function(response) {
                    $('#enquiry-subsidy').text(response.subsidy === '1' ? 'Yes' : 'No');
                    $('#enquiry-finance').text(response.finance === '1' ? 'Yes' : 'No');
                    $('#enquiry-structure-type').text(response.structure_type);
                    $('#enquiry-solar-panel').text(response.solar_panel);
                    $('#enquiry-panel-brands').text(response.panel_brands);
                    $('#enquiry-brands').text(response.brands);
                    $('#enquiry-time').text(response.time);
                    $('#enquiryDetailsModal').modal('show');
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    </script>
@endsection
