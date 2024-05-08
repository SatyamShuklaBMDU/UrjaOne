<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a class href="{{url('dashboard')}}" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span> </a></li>
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-user fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Profile</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('user-profile') }}">User Profile</a></li>
                    <li><a href="{{ route('vendor-profile') }}">Vendor Profile</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-086-star"></i>
                    <span class="nav-text">Enquiry </span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">User</a></li>
                    <li><a href="#">Vendor</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-045-heart"></i>
                    <span class="nav-text">Quotations</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="#">User</a></li>
                    <li><a href="#">Vendor</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="flaticon-072-printer"></i>
                    <span class="nav-text">Feedback </span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('customer-feedback') }}">User</a></li>
                    <li><a href="{{ route('vendor-feedback') }}">Vendor</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-clipboard-question fa-lg"></i>
                    <span class="nav-text">Complaints </span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('customer-complaint') }}">User</a></li>
                    <li><a href="{{ route('vendor-complaint') }}">Vendor</a></li>
                </ul>
            </li>
            <!-- next start -->
            <li><a class="ai-icon" href="{{ route('faq-index') }}" aria-expanded="false">
                    <i class="fa-solid fa-circle-question fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">FAQs</span>
                </a>
            </li>
            <!-- next end -->
            <!-- next start -->
            <li><a class="ai-icon" href="notification.php" aria-expanded="false">
                    <i class="fa-solid fa-bell fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Notification</span>
                </a>
            </li>
            <!-- next end -->
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
            <!-- next start -->
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-sheet-plastic fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Banner Manage</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('main-banner-page') }}">User Banner</a></li>
                    <li><a href="{{ route('vendor-main-banner-page') }}">Vendor Banner</a></li>
                </ul>
            </li>
            <!-- next end -->
            <!-- next start -->
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-lightbulb fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Plans</span>
                </a>
            </li>
            <!-- next end -->
            <!-- next start -->
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-credit-card fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Payment History</span>
                </a>
            </li>
            <!-- next end -->
            <!-- next start -->
            <li><a class="has-arrow ai-icon" href="#" aria-expanded="false">
                    <i class="fa-solid fa-credit-card fa-lg" style="color: #969ba0;"></i>
                    <span class="nav-text">Manage Admin</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="all-admin.php">All Admin</a></li>
                    <li><a href="add-admin.php">Add Admin</a></li>
                </ul>
            </li>
            <!-- next end -->
        </ul>
        <div class="copyright">
            <p><strong>Energy Book</strong> © 2024 All Rights Reserved</p>
        </div>
    </div>
</div>
