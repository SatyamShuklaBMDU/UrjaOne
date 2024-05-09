@extends('include.master')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-sm-4 d-flex flex-wrap align-items-center text-head">
            <h2 class="mb-3 me-auto">Add Role</h2>
        </div>
        <div class="col-md-5"></div>
        <div class="col-md-3 mb-sm-4 d-flex flex-wrap align-items-end text-head">
            <a href="{{ route('all-role') }}" class="btn btn-primary mb-2 h6"><span class="text-white fw-bold">See All
                    Role</span></a>
        </div>
    </div>
    <!-- row -->
    <div class="row">
        <div class="col-xl-12 col-xxl-12">
            <div class="card">
                <form class="card-body" action="{{ route('store-role') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="role" class="form-label text-dark fw-bold h5">Role</label>
                        <input type="text" name="role" class="form-control border-dark" id="role"
                            placeholder="Enter Role">
                        <small class="text-primary h6">(e.g., Manager,Tester)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold h4">Assign Modules</label><br>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="all"
                                name="permissions[]" id="selectAllModules">
                            <label class="form-check-label text-dark fw-bold h6" for="selectAllModules">
                                All
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Profile"
                                name="permissions[]" id="profile">
                            <label class="form-check-label text-dark fw-bold h6" for="profile">
                                Profile
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Enquiry"
                                name="permissions[]" id="enquiry">
                            <label class="form-check-label text-dark fw-bold h6" for="enquiry">
                                Enquiry
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Quotation"
                                name="permissions[]" id="quotations">
                            <label class="form-check-label text-dark fw-bold h6" for="quotations">
                                Quotations
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Feedback"
                                name="permissions[]" id="feedback">
                            <label class="form-check-label text-dark fw-bold h6" for="feedback">
                                Feedback
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Complaints"
                                name="permissions[]" id="complaints">
                            <label class="form-check-label text-dark fw-bold h6" for="complaints">
                                Complaints
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Faqs"
                                name="permissions[]" id="faqs">
                            <label class="form-check-label text-dark fw-bold h6" for="faqs">
                                FAQs
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Notification"
                                name="permissions[]" id="notification">
                            <label class="form-check-label text-dark fw-bold h6" for="notification">
                                Notification
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Blogs"
                                name="permissions[]" id="blogs">
                            <label class="form-check-label text-dark fw-bold h6" for="blogs">
                                Blogs
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Banner"
                                name="permissions[]" id="bannerManage">
                            <label class="form-check-label text-dark fw-bold h6" for="bannerManage">
                                Banner Manage
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Plans"
                                name="permissions[]" id="plans">
                            <label class="form-check-label text-dark fw-bold h6" for="plans">
                                Subscription Plans
                            </label>
                        </div>
                        <div class="form-check-inline">
                            <input class="form-check-input border-primary fw-bold" type="checkbox" value="Payment"
                                name="permissions[]" id="paymentHistory">
                            <label class="form-check-label text-dark fw-bold h6" for="paymentHistory">
                                Payment History
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary h6" data-bs-dismiss="modal">Submit</button>
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
