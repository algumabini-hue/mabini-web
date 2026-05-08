@extends('adminlayout.adminlayout')
@section('admin-content')

<div class="container-fluid">
    <div>
        <form id="login-form" class="register-form container col-md-4 offset-md-4" method="POST" action="{{ url('/login') }}">
            @csrf
            <h2 class="login-header">ADMINISTRATOR</h2>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                <input type="checkbox" onclick="togglePassword()"> Show Password
            </div>
                <button type="submit" class="btn btn-color w-100" id="submit">Login</button>
        </form>
    </div>
</div>

<script type="module" src="{{ asset('js/admin/login.js') }}"></script>

@endsection

