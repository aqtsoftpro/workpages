<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/js/app.js', "resources/js/bootstrap.js"])
  </head>
<body>
    <h1>This is just test page</h1>

    <!-- Pusher event listener -->
    <div id="app">
        <!-- Content to be updated dynamically -->
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.js"></script>
    <script>
    </script> --}}
    <script>
        async function setupChannel() {
            try {
                const channel = await window.Echo.channel('user-register-event');
                channel.listen('my-event', data => {
                    // ... event handling
                });
            } catch (error) {
                console.error('Error creating Echo channel:', error);
            }
        }
        setupChannel()
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
