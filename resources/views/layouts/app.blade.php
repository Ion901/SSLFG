<!DOCTYPE html>
<html lang="en">
<head>
    @section('meta')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @show

    @section('stylesheets')
    @vite(['resources/css/app.css'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href='https://fonts.googleapis.com/css?family=Public Sans' rel='stylesheet'>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/themes/odometer-theme-default.css"
      integrity="sha512-kMPqFnKueEwgQFzXLEEl671aHhQqrZLS5IP3HzqdfozaST/EgU+/wkM07JCmXFAt9GO810I//8DBonsJUzGQsQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link href='https://fonts.googleapis.com/css?family=Roboto Slab' rel='stylesheet'>
    @show

    @section('scripts')
    @vite(['resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/d258707c8d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.7/odometer.min.js"
    integrity="sha512-v3fZyWIk7kh9yGNQZf1SnSjIxjAKsYbg6UQ+B+QxAZqJQLrN3jMjrdNwcxV6tis6S0s1xyVDZrDz9UoRLfRpWw=="
    crossorigin="anonymous"
    referrerpolicy="no-referrer"
  ></script>
    @show



</head>
<body>

    @yield('content')

</body>
</html>
