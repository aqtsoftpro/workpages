<!-- ======= Header ======= -->
<style>
    .notification {
  position: fixed;
  top: 0;
  right: 12em;
  width: 300px;
  background-color: #333;
  color: #fff;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  display: none;
}

.notification:after {
  content: '';
  position: absolute;
  top: 50%;
  left: 100%;
  margin-top: -10px;
  border-width: 10px;
  border-style: solid;
  border-color: transparent #333 transparent transparent;
  transform: rotate(180deg);

}

.notification.show {
  display: block;
}

.closebtn {
  cursor: pointer;
  float: right;
  font-size: 20px;
  font-weight: bold;
}

.closebtn:hover {
  color: #ccc;
}
</style>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div id="notification" class="notification">
        <span id="message"></span>
        <span class="closebtn" onclick="closeNotification()">&times;</span>
      </div>

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">@php
                echo $site_name = get_site_setting('_site_name');
            @endphp Admin</span>
        </a>

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="GET" action="{{ route('search-global') }}">
            <input type="text" name="keyword" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>
                    <span class="badge bg-primary badge-number"
                        id="count-notify">{{ $headerData['notification_count'] }}</span>
                </a><!-- End Notification Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications"
                    style="overflow: scroll !important; height: 500px !important" id="notification-list">
                    <li class="dropdown-header">
                        You have <span id="notify-count">{{ $headerData['notification_count'] }}</span> new
                        notifications
                        <a href="{{ route('notification_job_alert') }}"><span
                                class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {!! $headerData['notification_list'] !!}


                </ul><!-- End Notification Dropdown Items -->

            </li><!-- End Notification Nav -->

            <!-- End Messages Nav -->

            <li class="nav-item dropdown pe-3">
                @php
                    $user = Auth::user();
                @endphp

                @if ($user->photo)
                    @php
                        $site_logo_img = URL::to('/uploads') . '/' . $user->photo;
                    @endphp


                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <div style="border-radius:50%!important ">
                            <img src="{{ $user->photo }}" alt="Profile" class="rounded-circle" width="40"
                                height="40">
                        </div>
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->
                @else
                    @php $site_logo_img  = URL::to('/uploads/no-img.jpg') @endphp
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ $site_logo_img }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                    </a><!-- End Profile Iamge Icon -->
                @endif



                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->roles->first()->name }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ url('admin/profile') }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    {{--  <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                        <i class="bi bi-question-circle"></i>
                        <span>Need Help?</span>
                        </a>
                    </li>  --}}
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item d-flex align-items-center" type="submit">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    function showNote(notify) {

        var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // Define API endpoint
            var apiEndpoint = '/admin/notify-status';

            // Define data to be sent in the request
            var requestData = {
                id: notify,
                // Add any additional data here
                _token: csrfToken // Include CSRF token in the request data
            };
            let notifyCount = parseInt($('#notify-count').text()) - 1;
            // Get text content of #count-notify element and subtract 1
            let mainCount = parseInt($('#count-notify').text()) - 1;

            $('#notify-count').text(notifyCount);
            $('#count-notify').text(mainCount);
            // Make the API request
            $.ajax({
                url: apiEndpoint,
                type: 'POST',
                data: requestData,
                success: function(response){
                    // console.log('API response:', response);
                    console.log(response);
                    // alert(JSON.stringify(response.name));

                    $("#message").html(response.name);
                    $("#notification").fadeIn(); // Fade in the notification

                    setTimeout(function() {
                        // $("#notification").removeClass("show");
                        $("#notification").fadeOut(); // Fade out the notification after the duration
                    }, 5000);
                },
                error: function(xhr, status, error){
                    console.error('API request failed:', error);
                    // Handle error response here
                }
            });
    }

    function closeNotification() {
        $("#notification").fadeOut();
    }

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;
    var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        // alert(JSON.stringify(data.message));
        const notificationSound = new Audio('{{ asset("sounds/pusher.wav") }}');
        notificationSound.play();
        $("#message").text(data.message);
        // $("#notification").addClass("show");
        $("#notification").fadeIn(); // Fade in the notification

        setTimeout(function() {
            // $("#notification").removeClass("show");
            $("#notification").fadeOut(); // Fade out the notification after the duration
        }, 5000);

        $.get("new-notification")
            .done(function(res) {
                // alert(JSON.stringify(res));
                let totalCount = 0;
                const $container = $('#notification-list');
                const $count = $('#notify-count');
                const $mainCount = $('#count-notify');
                // Iterate over each type
                $.each(res, function(type, items) {
                    // Add heading for the type
                    const itemCount = items.length;
                    totalCount += itemCount;
                    $count.text(totalCount);
                    $mainCount.text(totalCount);
                    var note_type = '';
                    if (type == '_notification_newsletter') {
                        note_type = 'News & Letters'
                    } else if (type == '_notification_job_activity') {
                        note_type = 'New Activities On Job'
                    }
                    $container.append(`
                    <li class="notification-item">
                        <h4>${note_type}</h4>
                    </li>
                    <li>
                    <hr class="dropdown-divider">
                  </li>`);

                    // Iterate over items of this type
                    $.each(items, function(index, item) {
                        // Add item details

                        var icon = '';
                        if (item.type == '_notification_job_activity' || item.type ==
                            '_notification_package_subscription') {
                            icon = 'bi-check-circle text-success';
                        }

                        $container.append(`
                        <a href="javascript:void(0)" class="show-notify" onclick="showNote(${item.id})">
                        <li class="notification-item">

                        <i class="${icon}"></i>
                        <div>
                            <h4>${item.name}</h4>
                            <p>${item.desc}</p>
                            <p>${item.created_at}</p>
                        </div>
                       
                    </li>
                    </a>
                    <li>
                    <hr class="dropdown-divider">
                  </li>
                  `);
                    });
                });
            });
    });
</script>
