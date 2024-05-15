@extends('include.master')
@section('style')
    <style>
        section {
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            background-color: #fd683e;
            /* Orange background for the section */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 960px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .section-header {
            cursor: pointer;
            position: relative;
            padding-right: 30px;
            /* Space for the toggle icon */
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-header i {
            transition: transform 0.3s ease;
        }

        .section-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out, opacity 0.5s ease-out;
            /* Added opacity transition */
            background-color: white;
            padding: 20px;
            opacity: 0;
            /* Initially hide content */
        }

        .expanded .section-content {
            max-height: 500px;
            opacity: 1;
            /* Show content when expanded */
        }

        .expanded .section-header i {
            transform: rotate(180deg);
        }

        #loom-companion-mv3 {
            display: none !important;
        }

        div.dt-container .dt-length,
        div.dt-container .dt-search,
        div.dt-container .dt-info,
        div.dt-container .dt-processing {
            display: none !important;
        }
    </style>
@endsection
@section('content')
    <div class="mt-5 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">User Banner's</h2>
        <div class="col-md-1">
            <!-- Modal -->
            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                data-bs-target="#basicModal2"
                style="width: 85px; height: 40px; text-align: center; font-size: 23px;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height: normal;">+</a>
        </div>
    </div>
    <div class="justify-content-between align-items-center mb-5">
        <div class="row">
            {{-- <div class="col-md-12 d-flex">
                <div class="col-md-3">
                    <div class="align-items-center">
                        <a href="{{ route('user-banner', 'Home') }}" class="btn btn-primary mb-2 btn-rounded" style="width: 150px; height: 50px;font-size: 15px;box-shadow: 2px 10px 9px 0px #00000063 !important;"><span
                                class="text-white fw-bold"> Home Banner</span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="align-items-center">
                        <a href="{{ route('user-banner', 'About') }}" class="btn btn-primary mb-2 btn-rounded" style="width: 150px; height: 50px;font-size: 15px;box-shadow: 2px 10px 9px 0px #00000063 !important;"><span
                                class="text-white fw-bold"> About Banner</span></a>
                    </div>
                </div>
            </div> --}}
            <section id="home-banner">
                <div class="section-header text-white">
                    <h2>Home Banner</h2><i class="fa fa-chevron-down"></i>
                </div>
                <div class="section-content">
                    <table id="tableHome" class="display">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Sr NO.</th>
                                <th style="text-align: center;">Created Date, <br> Time</th>
                                {{-- <th style="text-align: center;">Update Date, <br> Time</th> --}}
                                <th style="text-align: center;">Banner Image</th>
                                {{-- <th style="text-align: center;">Banner For</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($homebanners as $user)
                                <tr data-banner-id="{{ $user->id }}">
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">
                                        {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                        {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                    </td>
                                    {{-- <td style="text-align: center;">
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td> --}}
                                    <td style="text-align: center;"><a href="{{ asset($user->banner) }}" target="_blank"
                                            rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                                src="{{ asset($user->banner) }}" alt=""></a>
                                    </td>
                                    {{-- <td style="text-align: center;">{{ $user->for }}</td> --}}
                                    <td>
                                        <select class="form-select border-dark fw-bold statusSwitch" style="width:100px;">
                                            <option value="1" {{ $user->status == '1' ? 'selected' : '' }}
                                                class="bg-success text-light">Active</option>
                                            <option value="0" {{ $user->status == '0' ? 'selected' : '' }}
                                                class="bg-danger text-light">Deactive</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                data-bs-toggle="modal"
                                                onclick="editBanner({{ $user->id }}, '{{ $user->for }}')"
                                                data-bs-target="#basicModal"><i class="fas fa-pencil-alt"></i></a> --}}
                                            <a data-banner-id="{{ $user->id }}"
                                                class="btn btn-danger shadow btn-xs sharp deleteBtn"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            <section id="about-banner">
                <div class="section-header text-white">
                    <h2>About Banner</h2><i class="fa fa-chevron-down"></i>
                </div>
                <div class="section-content">
                    <table id="tableAbout" class="display">
                        <thead>
                            <tr>
                                <th style="text-align: center;">Sr NO.</th>
                                <th style="text-align: center;">Created Date, <br> Time</th>
                                {{-- <th style="text-align: center;">Update Date, <br> Time</th> --}}
                                <th style="text-align: center;">Banner Image</th>
                                {{-- <th style="text-align: center;">Banner For</th> --}}
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aboutbanners as $user)
                                <tr data-banner-id="{{ $user->id }}">
                                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                                    <td style="text-align: center;">
                                        {{ $user->created_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                        {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                    </td>
                                    {{-- <td style="text-align: center;">
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('d F Y') }}<br>
                                            {{ $user->updated_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                        </td> --}}
                                    <td style="text-align: center;"><a href="{{ asset($user->banner) }}" target="_blank"
                                            rel="noopener noreferrer"><img class="rounded-circle" width="35"
                                                src="{{ asset($user->banner) }}" alt=""></a>
                                    </td>
                                    {{-- <td style="text-align: center;">{{ $user->for }}</td> --}}
                                    <td>
                                        <select class="form-select border-dark fw-bold statusSwitch" style="width:100px;">
                                            <option value="1" {{ $user->status == '1' ? 'selected' : '' }}
                                                class="bg-success text-light">Active</option>
                                            <option value="0" {{ $user->status == '0' ? 'selected' : '' }}
                                                class="bg-danger text-light">Deactive</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            {{-- <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"
                                                data-bs-toggle="modal"
                                                onclick="editBanner({{ $user->id }}, '{{ $user->for }}')"
                                                data-bs-target="#basicModal"><i class="fas fa-pencil-alt"></i></a> --}}
                                            <a data-banner-id="{{ $user->id }}"
                                                class="btn btn-danger shadow btn-xs sharp deleteBtn"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="basicModal2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.banners.store') }}" method="POST" id="addBannerForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="for" class="form-label text-dark fw-bold h5">For</label>
                            <Select class="form-control" name="for" id="for">
                                <option value="" selected disabled>Choose For</option>
                                <option value="Home">Home</option>
                                <option value="About">About</option>
                                {{-- <option value="Blog">Blog</option> --}}
                            </Select>
                            <small class="text-primary h6">(e.g., Banner )</small>
                        </div>
                        <div class="mb-3">
                            <label for="bannerImage" class="form-label text-dark fw-bold h5">Banner Image</label>
                            <input type="file" class="form-control border-dark" id="bannerImages" name="images[]"
                                multiple accept="image/*">
                            <small class="text-primary h6">(Upload an image for the Banner)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary h6">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editBannerModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Edit Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('user.banners.edit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <input type="hidden" name="bannerId" value="" id="VendorBannerId">
                            <label for="editTitle" class="form-label text-dark fw-bold h5">For</label>
                            <select class="form-select border-dark" id="editTitle" name="for">
                                <option value="" selected disabled>Choose Title</option>
                                <option value="Home">Home</option>
                                <option value="About">About</option>
                                {{-- <option value="Blog">Blog</option> --}}
                            </select>
                            <small class="text-primary h6">(e.g., Banner)</small>
                        </div>
                        <div class="mb-3">
                            <label for="editBannerImage" class="form-label text-dark fw-bold h5">Banner Image</label>
                            <input type="file" class="form-control border-dark" name="image" id="editBannerImage"
                                accept="image/*">
                            <small class="text-primary h6">(Upload a new image for the Banner)</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light h6" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary h6">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function editBanner(id, title) {
            $('#VendorBannerId').val(id);
            $('#editTitle').val(title);
            $('#editBannerModal').modal('show');
        }
    </script>
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
        $(document).ready(function() {
            $('.section-header').click(function() {
                var section = $(this).parent();
                var content = section.find('.section-content');
                var icon = $(this).find('i');
                var table = section.find('.display').DataTable();

                // Close all other sections
                $('.section').not(section).each(function() {
                    var otherSection = $(this);
                    var otherContent = otherSection.find('.section-content');
                    var otherIcon = otherSection.find('.section-header i');

                    otherSection.removeClass('expanded');
                    otherContent.css({
                        'max-height': '0',
                        'overflow': 'hidden'
                    });
                    otherIcon.removeClass('fa-minus').addClass('fa-chevron-down');
                });

                section.toggleClass('expanded');

                if (section.hasClass('expanded')) {
                    content.css('max-height', content[0].scrollHeight + 'px');
                    content.css('overflow', 'visible');
                    table.columns.adjust().draw();
                } else {
                    content.css('max-height', '0');
                    content.css('overflow', 'hidden');
                }

                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            });
            $('#tableHome, #tableAbout').DataTable({
                lengthMenu: false // Remove the length menu
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.deleteBtn').forEach(function(deleteButton) {
                deleteButton.addEventListener('click', function() {
                    var faqId = this.dataset.bannerId;
                    swal.fire({
                        title: 'Are you sure?',
                        text: 'You will not be able to recover this Banner!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            deleteFAQ(faqId);
                        }
                    });
                });
            });
        });

        function deleteFAQ(faqId) {
            var token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = "{{ route('user-banner-delete', ':faqId') }}".replace(':faqId', faqId);
            fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': token
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to delete Banner');
                    }
                    return response.json();
                })
                .then(data => {
                    swal.fire({
                        title: 'Deleted!',
                        text: 'The Banner has been deleted.',
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
                        text: 'Failed to delete Banner.',
                        icon: 'error'
                    });
                });
        }
    </script>
    <script>
        $('.statusSwitch').on('change', function() {
            var selectElement = $(this).closest('tr').find('select'); // Find the select element in the current row
            var status = selectElement.val(); // Get the selected value (1 or 0)
            var bannerId = $(this).closest('tr').data('banner-id'); // Get the data-banner-id attribute value
            $.ajax({
                url: '{{ route('update-banner-status') }}',
                method: 'POST',
                data: {
                    status: status,
                    banner: bannerId, // Pass the banner ID
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
