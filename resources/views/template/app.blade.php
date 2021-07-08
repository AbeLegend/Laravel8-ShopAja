<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <title>@yield('title')</title>
</head>
<body>
  @include('template.navbar')
  @yield('content')
</body>

    <script>
      // Toggle Navbar
      let isOpen = false;
        function toggleNavbar() {
          let navItem = document.getElementById("nav_item");
          isOpen = !isOpen;
          if(isOpen){
            navItem.classList.add("block");
            navItem.classList.remove("hidden");
          }else{
            navItem.classList.add("hidden");
            navItem.classList.remove("block");
          }
        }
      // End Toggle Navbar
    </script>

</html>