@extends('adminlayout.adminlayout')
@section('admin-content')

<div class="container-fluid">
    <div>
        <form id="signup-form" class="register-form container col-md-4 offset-md-4" method="POST" action="{{ url('/signup') }}">
            @csrf
            <h2 class="login-header">REGISTER</h2>
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control text-uppercase" id="name" name="name" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
                <button type="submit" class="btn btn-color w-100" id="submit">Create Account</button>
        </form>
    </div>
</div>

<script type="module" src="{{ asset('js/admin/signup.js') }}"></script>

@endsection

