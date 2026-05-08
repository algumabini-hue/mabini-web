
<!-- Section: Social media -->

    <footer id="main-footer" class="text-center text-lg-start text-white footer-overlay ">
        <section class="d-flex justify-content-between p-4 text-white" style="background-color: #13bd82">
            <!-- Left -->
            <div class="me-5">
            </div>
            <!-- Left -->
        
            <!-- Right -->
            
            <!-- Right -->
        </section>
        <!-- Grid container -->
        <div class="container p-4">
            <!--Grid row-->
            <div class="row my-4">
                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                    <div class="rounded-circle bg-white shadow-1-strong d-flex align-items-center justify-content-center mb-4 mx-auto"
                        style="width: 152px; height: 152px;">
                        <img src="{{ asset('images/logo.png') }}" height="150" width="150" class="rounded-circle"
                            alt="" loading="lazy" />
                    </div>

                    <p class="text-center">Municipality of Mabini Pangasinan</p>

                    

                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Links</h5>

                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="{{ route('history') }}" class="text-white text-decoration-none"><i class="fas fa-landmark pe-3"></i>History of Mabini</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('officials') }}" class="text-white text-decoration-none"><i class="fas fa-people-group pe-3"></i>Officials of Term 2025
                                - 2028</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('ordinances') }}" class="text-white text-decoration-none"><i class="fas fa-file-lines pe-3"></i>Ordinances</a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('events') }}" class="text-white text-decoration-none"><i class="fas fa-calendar-days pe-3"></i>Events</a>
                        </li>
                       
                    </ul>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                

                <!--Grid column-->
                <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                    <h5 class="text-uppercase mb-4">Contacts</h5>

                    <ul class="list-unstyled">
                        <li>
                            <p><i class="fas fa-map-marker-alt pe-2"></i>Poblacion, Mabini, Pangasinan</p>
                        </li>
                        <li>
                            <p><i class="fas fa-phone pe-2"></i>+ 01 234 567 89</p>
                        </li>
                        <li>
                            <p><i class="fas fa-envelope pe-2 mb-0"></i>mabinipangasinan.@example.com</p>
                        </li>
                        <li class="mb-2">
                            <a href="https://www.facebook.com/profile.php?id=61587384729217" class="text-white text-decoration-none"><i
                                    class="fab fa-facebook-f pe-2"></i>Sangguniang Bayan of Mabini Pangasinan - Official Facebook Page</a>
                        </li>
                    </ul>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </div>
        <!-- Grid container -->

        <!-- Copyright -->
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            © 2026 Copyright:
            <a class="text-white text-decoration-none" href="{{ url('/') }}">
                {{ config('app.name', 'Mabini') }}
            </a>
        </div>
    </footer>

</div>
<!-- End of .container -->