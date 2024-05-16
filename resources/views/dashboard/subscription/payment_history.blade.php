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
@endsection
@section('content')
    <div class="mt-2 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-2 me-auto">Payment History</h2>
    </div>
    <div class="justify-content-between align-items-center mb-2">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <form action="{{ route('filter-subscription') }}" method="post">
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
                            <a href="{{ route('get-payment-history') }}"
                                class="btn btn-primary position-absolute "style="right:46px; bottom: 2px;"><i
                                    class="fas fa-sync"></i></a>
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
                                    <th style="text-align: center;">Sr NO.</th>
                                    <th style="text-align: center;">Created Date</th>
                                    <th style="text-align: center;">CIN No.</th>
                                    <th style="text-align: center;">Name</th>
                                    <th style="text-align: center;">Phone No.</th>
                                    <th style="text-align: center;">Plan Name</th>
                                    <th style="text-align: center;">Plan Type</th>
                                    <th style="text-align: center;">Plan Category</th>
                                    <th style="text-align: center;">Plan Details</th>
                                    <th style="text-align: center;">Plan Amount</th>
                                    <th style="text-align: center;">Expiration Date</th>
                                    <th style="text-align: center;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($paymentHistory as $payment)
                                    <tr data-payment-id="{{ $payment->id }}">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">{{ $payment->created_at->format('d/m/y') }}</td>
                                        <td style="text-align: center;"><a
                                                href="javascript:void(0);"><strong>{{ $payment->Vendor->cin_no }}</strong></a>
                                        </td>
                                        <td style="text-align: center;">{{ $payment->Vendor->name }}</td>
                                        <td style="text-align: center;">{{ $payment->Vendor->phone_number }}</td>
                                        <td style="text-align: center;">{{ $payment->plan_name }}</td>
                                        <td style="text-align: center;">{{ $payment->plan_type }}</td>
                                        <td style="text-align: center;">{{ $payment->plan_category }}</td>
                                        <td style="text-align: center;"><a href="#" data-bs-toggle="tooltip"
                                                title="{{ strip_tags($payment->plan_details) }}" data-placement="top">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($payment->plan_details), 10) }}
                                            </a></td>
                                        <td style="text-align: center;">{{ $payment->plan_amount }}</td>
                                        <td style="text-align: center;">{{ $payment->expiration_date->format('d/m/y') }}
                                        </td>
                                        <td style="text-align: center;"><input class="statusSwitch"
                                                style="transform: translateY(0px);"
                                                {{ $payment->status == '1' ? 'checked' : '' }} type="checkbox"></td>
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
@endsection
@section('script')
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
        $('.statusSwitch').on('change', function() {
            var isChecked = $(this).prop('checked');
            var status = isChecked ? '1' : '0';
            var currentRow = $(this).closest('tr');
            var planId = currentRow.data('payment-id');
            $.ajax({
                url: '{{ route('update-subscription-status') }}',
                method: 'POST',
                data: {
                    status: status,
                    paymentID: planId,
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
