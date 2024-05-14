<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class href="{{ url('dashboard') }}" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span> </a></li>
            @if (auth()->check())
                @php
                    $user = auth()->user();
                    $role = $user->roles;
                    $SuperRole = App\Models\Role::where('role', 'Super admin')->first();
                    $permissions = $role->permission ? json_decode($role->permission, true) : [];
                @endphp

                <!-- Profile menu -->
                @if (in_array('Profile', $permissions) ||
                        in_array('All', $permissions) ||
                        auth()->user()->role ||
                        auth()->user()->role_id == $SuperRole->id)
                    {{-- @if (auth()->user()->role_id == $SuperRole->id) --}}
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-user fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Profile</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('user-profile') }}">User Profile</a></li>
                            <li><a href="{{ route('vendor-profile') }}">Vendor Profile</a></li>
                        </ul>
                    </li>
                @endif
                <!-- Enquiry menu -->
                @if (in_array('Enquiry', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-regular fa-circle-question"></i>
                            <span class="nav-text">Enquiry </span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('get-enquiry-page') }}">User</a></li>
                            {{-- <li><a href="#">Vendor</a></li> --}}
                        </ul>
                    </li>
                @endif
                <!-- Quotations menu -->
                @if (in_array('Quotation', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-file-circle-check"></i>
                            <span class="nav-text">Quotations</span>
                        </a>
                        <ul aria-expanded="false">
                            {{-- <li><a href="#">User</a></li> --}}
                            <li><a href="{{ route('get-quotation') }}">Vendor</a></li>
                        </ul>
                    </li>
                @endif
                <!-- Feedback menu -->
                @if (in_array('Feedback', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-message"></i>
                            <span class="nav-text">Feedback </span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('customer-feedback') }}">User</a></li>
                            <li><a href="{{ route('vendor-feedback') }}">Vendor</a></li>
                        </ul>
                    </li>
                @endif
                <!-- Complaints menu -->
                {{-- @if (in_array('Complaints', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-clipboard-question fa-lg"></i>
                            <span class="nav-text">Complaints </span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('customer-complaint') }}">User</a></li>
                            <li><a href="{{ route('vendor-complaint') }}">Vendor</a></li>
                        </ul>
                    </li>
                @endif --}}
                @if (in_array('Faqs', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="ai-icon" href="{{ route('faq-index') }}" aria-expanded="false">
                            <i class="fa-solid fa-circle-question fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">FAQs</span>
                        </a>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Notification', $permissions) ||
                        in_array('All', $permissions) ||
                        auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="ai-icon" href="{{ route('show-notification') }}" aria-expanded="false">
                            <i class="fa-solid fa-bell fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Notification</span>
                        </a>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('history', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="ai-icon" href="{{ route('get-enquiry-history') }}" aria-expanded="false">
                            <i class="fa-regular fa-circle-question"></i>
                            <span class="nav-text">Enquiry History</span>
                        </a>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Blogs', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-blog fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Blogs</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('get-blog-page') }}">All Blogs</a></li>
                            <li><a href="{{ route('add-blog-page') }}">Add Blog</a></li>
                        </ul>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Banner', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-image"></i>
                            <span class="nav-text">Banner Manage</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('main-banner-page') }}">User Banner</a></li>
                            <li><a href="{{ route('vendor-main-banner-page') }}">Vendor Banner</a></li>
                        </ul>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Plans', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-lightbulb fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Plans</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('plans-page') }}">All Plans</a></li>
                            <li><a href="{{ route('add-plans') }}">Add Plans</a></li>
                        </ul>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Plans', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-lightbulb fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Wallet</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('get-wallet') }}">All Transactions</a></li>
                        </ul>
                    </li>
                    <!-- next end -->
                @endif
                @if (in_array('Payment', $permissions) || in_array('All', $permissions) || auth()->user()->role_id == $SuperRole->id)
                    <!-- next start -->
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-credit-card fa-lg" style="color: #969ba0;"></i>
                            <span class="nav-text">Payment History</span>
                        </a>
                    </li>
                @endif
                <!-- next end -->
                <!-- next start -->
                @if (auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-users"></i>
                            <span class="nav-text">Manage Roles</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('all-role') }}">All Roles</a></li>
                            <li><a href="{{ route('add-role') }}">Add Roles</a></li>
                        </ul>
                    </li>
                @endif
                @if (auth()->user()->role_id == $SuperRole->id)
                    <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                            <i class="fa-solid fa-users"></i>
                            <span class="nav-text">Manage Admin</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('admin-page') }}">All Admin</a></li>
                            <li><a href="{{ route('add-admin') }}">Add Admin</a></li>
                        </ul>
                    </li>
                @endif
            @endif
            <!-- next end -->
        </ul>
        <div class="copyright">
            <p><strong>Energy Book</strong> © 2024 All Rights Reserved</p>
        </div>
    </div>
</div>
