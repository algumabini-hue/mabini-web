    @extends('layout.master')
    @section('officials')

           
    @include('officials.officials-chart')
            

            <section class="p-2 overflow-hidden" id="">
                @yield('officials.officials-personal')
            </section>

    @endsection