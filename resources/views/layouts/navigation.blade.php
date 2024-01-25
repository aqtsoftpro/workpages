<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        {{--
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('admin/dashboard') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->  --}}

        <li class="nav-item">
            <a class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="bi bi-grid"></i><span>Dashboard</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
        </li><!-- End Components Nav -->
        @if (auth()->user()->hasRole('Super Admin'))
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gear"></i><span>Settings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    {{--  <li class="nav-heading">Site Settings</li>  --}}
                    <li>
                        <a href="{{ url('admin/settings') }}">
                            <i class="bi bi-circle"></i><span>Site Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/design_settings') }}">
                            <i class="bi bi-circle"></i><span>Design Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/social_media_settings') }}">
                            <i class="bi bi-circle"></i><span>Social Media Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/payment_settings') }}">
                            <i class="bi bi-circle"></i><span>Payment Gateway Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/newsletter_settings') }}">
                            <i class="bi bi-circle"></i><span>Newsletter Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/sms_settings') }}">
                            <i class="bi bi-circle"></i><span>SMS Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/slider_settings') }}">
                            <i class="bi bi-circle"></i><span>Slider Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/job_seeker_settings') }}">
                            <i class="bi bi-circle"></i><span>Job Seeker Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('admin/settings/notification_settings') }}">
                            <i class="bi bi-circle"></i><span>Notification Setting</span>
                        </a>
                    </li>

                </ul>
            </li><!-- End Components Nav -->
        @endif


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#cms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-display"></i><span>CMS</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="cms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/manage_pages/') }}">
                        <i class="bi bi-circle"></i><span>Manage Pages</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#jobcat-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-menu-button-wide"></i><span>Job Categories</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="jobcat-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/job_categories') }}">
                        <i class="bi bi-circle"></i><span>Job Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/sectors') }}">
                        <i class="bi bi-circle"></i><span>Sectors</span>
                    </a>
                </li>
                {{-- <li>
            <a href="{{ url('admin/locations') }}">
              <i class="bi bi-circle"></i><span>Locations</span>
            </a>
          </li> --}}
                <li>
                    <a href="{{ url('admin/location_states') }}">
                        <i class="bi bi-circle"></i><span>States</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/skills') }}">
                        <i class="bi bi-circle"></i><span>Skills</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/technologies') }}">
                        <i class="bi bi-circle"></i><span>Technologies</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/suburbs') }}">
                        <i class="bi bi-circle"></i><span>Suburbs</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#email-template-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-envelope"></i><span>Email Templates</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="email-template-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/email_templates/admin_templates') }}">
                        <i class="bi bi-circle"></i><span>Admin Emails</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/email_templates/company_templates') }}">
                        <i class="bi bi-circle"></i><span>Company Emails</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/email_templates/job_seeker_templates') }}">
                        <i class="bi bi-circle"></i><span>Job Seekar Emails</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav -->

        {{-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#blog-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-bootstrap-fill"></i><span>Blog</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="blog-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ url('/admin/blog/') }}">
              <i class="bi bi-circle"></i><span>Manage Posts</span>
            </a>
          </li>
          <li>
            <a href="{{ url('/admin/blog_categories') }}">
              <i class="bi bi-circle"></i><span>Manage Categories</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav --> --}}

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#subscription-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-basket"></i><span>Packages & Subscriptions</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="subscription-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/packages/') }}">
                        <i class="bi bi-circle"></i><span>Manage Packages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/admin/subscriptions/') }}">
                        <i class="bi bi-circle"></i><span>Subscription History</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#admin-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person-lines-fill"></i><span>User Management</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="admin-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/roles') }}">
                        <i class="bi bi-circle"></i><span>Role Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/permissions') }}">
                        <i class="bi bi-circle"></i><span>Permissions</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->


        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#users-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-people"></i><span>Site Users</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="users-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/admin_users') }}">
                        <i class="bi bi-circle"></i><span>Admin User</span>
                    </a>
                </li>
                @if (auth()->user()->roles('Super Admin'))
                    <li>
                        <a href="{{ url('admin/users') }}">
                            <i class="bi bi-circle"></i><span>Total User</span>
                        </a>
                    </li>
                @endif
                <li>
                    <a href="{{ url('admin/job_seekers') }}">
                        <i class="bi bi-circle"></i><span>Job Seeker</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/companies') }}">
                        <i class="bi bi-circle"></i><span>Companies</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#jobs-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-briefcase"></i><span>Jobs</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="jobs-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/jobs') }}">
                        <i class="bi bi-circle"></i><span>Current/Expired Jobs</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#app-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-newspaper"></i><span>Applications</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="app-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/applications') }}">
                        <i class="bi bi-circle"></i><span>Manage Applications</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#testimonials-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-emoji-smile"></i><span>Testimonials/Feedback</span><i
                    class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="testimonials-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/testimonials') }}">
                        <i class="bi bi-circle"></i><span>All Testimonials</span>
                    </a>
                </li>

            </ul>
        </li><!-- End Components Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#notification-nav" data-bs-toggle="collapse"
                href="#">
                <i class="bi bi-newspaper"></i><span>Notification</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="notification-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ url('admin/notification_job_alert') }}">
                        <i class="bi bi-circle"></i><span>Job Alerts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('admin/notification_package_subscription') }}">
                        <i class="bi bi-circle"></i><span>Package Subscriptions</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        {{--
      <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Manage Locations</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Manage Candidates</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>All Jobs</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Manage Employers</span>
        </a>
      </li><!-- End Profile Page Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Manage Packages</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Payment Gateway</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Website Settings</span>
        </a>
      </li><!-- End Profile Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-faq.html">
          <i class="bi bi-question-circle"></i>
          <span>F.A.Q</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-contact.html">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-register.html">
          <i class="bi bi-card-list"></i>
          <span>Register</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-login.html">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Login</span>
        </a>
      </li><!-- End Login Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="pages-error-404.html">
          <i class="bi bi-dash-circle"></i>
          <span>Error 404</span>
        </a>
      </li><!-- End Error 404 Page Nav -->

      <li class="nav-item">
        <a class="nav-link " href="pages-blank.html">
          <i class="bi bi-file-earmark"></i>
          <span>Blank</span>
        </a>
      </li><!-- End Blank Page Nav -->  --}}

    </ul>

</aside><!-- End Sidebar-->
{{--  <nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>  --}}
