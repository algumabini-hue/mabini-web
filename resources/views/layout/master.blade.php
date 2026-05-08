<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900&display=swap"
        rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mabini</title>

    <link rel="stylesheet" href="{{ asset('css/main-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/page-header.css') }}">
    <link rel="stylesheet" href="{{ asset('css/officials.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mun-history.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ordinance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contacts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom-header.css') }}">


</head>

<body class="bg-light p-0 m-0">
    <main class="main">

        @include('layout.nav')


        @yield(section: 'ord-upload')
        @yield('ord-uploaded')
        @yield('home')
        @yield('officials')

        @yield('ordinances')
        @yield('history')
        @yield('events')

        @include('layout.footer')

    </main>



    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&amp;display=swap"
        rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    {{-- Light box in events gallery --}}
    <script src="{{ asset('js/lightbox.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
    
    {{-- loading animation for search bar in ordinances and events --}}
    <script src="{{ asset('js/ajax.js') }}"></script>

    {{-- Scroll fade in animation of all the blades --}}
    <script src="{{ asset('js/scroll-fade-in.js') }}"></script>

    {{-- Navbar Scroll Effect --}}
    <script src="{{ asset('js/navbar-scroll-effect.js') }}"></script>
</body>

</html>