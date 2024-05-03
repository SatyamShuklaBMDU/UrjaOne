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
                <table class="table display mb-4 dataTablesCard order-table card-table text-black"
                    id="example7">
                    <thead>
                        <tr>
                            <th>S No.</th>
                            <th>CIN No</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($vendors as $vendor)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$vendor->VendorDetail->cin_no}}</td>
                            <td>{{$vendor->VendorDetail->name}}</td>
                            <td>{{$vendor->title}}</td>
                            <td style="text-align: center;"><a href="{{$vendor->image}}" target="_blank" rel="noopener noreferrer"><img class="rounded-circle" width="35" src="{{$vendor->image}}" alt></a></td>
                            <td>{{$vendor->number}}</td>
                            <td>{{$vendor->number}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection