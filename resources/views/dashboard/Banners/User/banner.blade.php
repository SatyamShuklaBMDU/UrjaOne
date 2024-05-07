@extends('include.master')
@section('style')
    <style>
        .dt-search label {
            margin-left: 50rem !important;
        }

        .dt-paging {
            margin-left: 66rem !important;
            margin-bottom: 1rem !important;
        }

        .dt-button {
            background: #FD683E !important;
            padding: .7rem !important;
            color: #fff !important;
            border-radius: 1.125rem !important;
        }
    </style>
@endsection
@section('content')
    <div class="mt-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">User Banner </h2>
    </div>
    <div class="justify-content-between align-items-center mb-4">
        <div class="row">
            <div class="col-md-7">
                <div class=" align-items-center">
                    <div id="datePickerContainer">
                        <input type="date" id="startDate" class="form-control input-primary-active shadow-sm">
                        <input type="date" id="endDate" class="form-control input-primary-active shadow-sm">
                        <button class="btn btn-primary position-absolute btn-style-apply" onclick="filterByDate()"
                            style=" right:135px;
                               bottom: 2px;">Apply</button>
                        <button class="btn btn-primary position-absolute " onclick="clearFilter()"
                            style=" right:46px;bottom: 2px;"><i class="fas fa-sync" aria-hidden="true"></i></button>
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
                                    <th style="text-align: center;">Created Date, <br> Time</th>
                                    <th style="text-align: center;">Update Date, <br> Time</th>
                                    <th style="text-align: center;">Banner Image</th>
                                    <th style="text-align: center;">Banner For</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: center;">
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td>
                                        <td style="text-align: center;"><a href="{{ asset($user->banner) }}" target="_blank"
                                                rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                                    src="{{ asset($user->banner) }}" alt=""></a></td>
                                        <td style="text-align: center;">{{$user->for}}</td>
                                        {{-- <td>
                                            <select class="form-select border-dark fw-bold" style="width:100px;">
                                                <option value="active" class="bg-success text-light">Active</option>
                                                <option value="deactive" class="bg-danger text-light">Deactive</option>
                                            </select>
                                        </td> --}}
                                        <td>
                                            <div class="d-flex">
                                                {{-- <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                    data-bs-toggle="modal" data-bs-target="#basicModal"><i
                                                        class="fas fa-pencil-alt"></i></a> --}}
                                                <a href="#" class="btn btn-danger shadow btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
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
    <!-- Modal -->
    <div class="modal fade" id="basicModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="editImgTitle" class="form-label text-dark fw-bold h5">Image Title</label>
                            <input type="text" class="form-control border-dark" id="editImgTitle" value="Banner Title">
                            <small class="text-primary h6">(e.g., Banner)</small>
                        </div>
                        <div class="mb-3">
                            <label for="editBannerImage" class="form-label text-dark fw-bold h5">Banner Image</label>
                            <input type="file" class="form-control border-dark" id="editBannerImage" accept="image/*">
                            <small class="text-primary h6">(Upload a new image for the Banner)</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary h6">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#example3').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print' // Define which buttons to display
                ],
                language: {
                    paginate: {
                        next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                        previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                    }
                }
            });
        });
    </script>
        <script>
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
        </script>
@endsection
