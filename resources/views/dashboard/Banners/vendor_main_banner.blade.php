@extends('include.master')
@section('content')
    <div class="mt-5 mb-sm-4 d-flex flex-wrap align-items-center text-head">
        <h2 class="mb-3 me-auto">Main Banner Page</h2>
        <div class="col-md-1">
            <!-- Modal -->
            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal"
                data-bs-target="#basicModal2"
                style="width: 85px; height: 40px; text-align: center; font-size: 23px;box-shadow: 2px 10px 9px 0px #00000063 !important;line-height: normal;">+</a>
        </div>
    </div>
    <div class="justify-content-between align-items-center mb-5">
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="col-md-3">
                    <div class="align-items-center">
                        <a href="{{ route('vendor-banner', 'Home') }}" class="btn btn-primary mb-2 btn-rounded" style="width: 150px; height: 50px;font-size: 15px;box-shadow: 2px 10px 9px 0px #00000063 !important;"><span
                                class="text-white fw-bold"> Home Banner</span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="align-items-center">
                        <a href="{{ route('vendor-banner', 'About') }}" class="btn btn-primary mb-2 btn-rounded" style="width: 150px; height: 50px;font-size: 15px;box-shadow: 2px 10px 9px 0px #00000063 !important;"><span
                                class="text-white fw-bold"> About Banner</span></a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="align-items-center">
                        {{-- <a href="{{ route('vendor-banner', 'Blog') }}" class="btn btn-primary mb-2 btn-rounded"><span
                                class="text-white fw-bold"> Blog Banner</span></a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="basicModal2">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title h2">Add Banner</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('vendor.banners.store') }}" method="POST" id="addBannerForm"
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
@endsection
@section('script')
    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    </script>
@endsection
