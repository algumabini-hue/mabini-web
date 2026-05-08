<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ADMIN</title>

    <link rel="stylesheet" href="{{ asset('css/main-page.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ordinance.css') }}">
    <link rel="stylesheet" href="{{ asset('css/events.css') }}">
    <link rel="stylesheet" href="{{ asset('css/nav.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">

    


</head>

<body class="bg-light p-0 m-0">
    <main class="main">

        @include('layout.nav')


        @yield(section: 'ord-upload')
        @yield('ord-uploaded')
        @yield('ord-description')

        @yield('officials-upload')
        @yield('event-upload')
        @yield('event-uploaded')
        @yield('event-description')
        

        

    </main>



    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200;300;400;600;700;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('js/official-modal.js') }}"></script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Set up the Intersection Observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    // If the element is visible on the screen
                    if (entry.isIntersecting) {
                        // Add the class that triggers the CSS animation
                        entry.target.classList.add('is-visible');

                        // Stop watching this element so it doesn't animate out and in again
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1 // Triggers when exactly 10% of the element is visible
            });

            // Find all elements with the 'scroll-fade-in' class and start watching them
            const hiddenElements = document.querySelectorAll('.scroll-fade-in');
            hiddenElements.forEach((el) => observer.observe(el));
        });

        $('form').submit(function () {
            if ($(document.activeElement).attr('type') == 'submit')
                return true;
            else return false;
        });
    </script>
</body>

</html>