@extends('layout.master')
@section('ordinances')

    

    
        @include('ordinances.ord-cards')
    

    <section class="p-2 overflow-hidden" id="">
        @yield('ordinances.ord-desc')
    </section>



@endsection