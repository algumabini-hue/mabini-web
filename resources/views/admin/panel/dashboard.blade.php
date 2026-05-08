@extends('adminlayout.adminpanellayout')
@section('adminpanel-content')

<div class="container-fluid mt-5 mb-5">
    <div class="row mb-4">
        <div class="col-md-12 dashboard-title">
                    <span class="nav-link text-dark mt-3 greetings text-uppercase"><strong>HELLO, {{ auth()->user()->name }}</strong></span>
            <h1 class="display-4"><strong>WHAT ARE YOU UPLOADING?</strong></h1>
            <p class="lead"><strong>SELECT WHAT YOU WANT TO UPLOAD</strong></p>
        </div>
    </div>
    <div class="container-fluid content-dashboard">
        <div class="row">
            <div class="col-md-4 mb-2 mt-4">
                <div class="card choices-container">
                    <div class="card-body">
                        <a class="choices" href="{{ route('municipality') }}" data-uid="true">
                            <h5 class="card-title m-auto"><strong>EVENTS</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2 mt-4">
                <div class="card choices-container">
                    <div class="card-body">
                        <a class="choices" href="{{ route('ordinance') }}" data-uid="true">
                            <h5 class="card-title m-auto"><strong>ORDINANCES</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-2 mt-4">
                <div class="card choices-container">
                    <div class="card-body">
                        <a class="choices" href="{{ route('official') }}" data-uid="true">
                            <h5 class="card-title m-auto"><strong>OFFICIALS</strong></h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <button class="btn btn-success mt-2 mb-4 button-view">VIEW WEBSITE</button>
    </div>

</div>

<!-- Script to append Firebase UID to dashboard URL -->
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/12.10.0/firebase-app.js";
    import { getAuth, onAuthStateChanged } from "https://www.gstatic.com/firebasejs/12.10.0/firebase-auth.js";

    const firebaseConfig = {
        apiKey: "AIzaSyBQPx0Yoc_f8goGGZVQKXCaQaK2cV6s-1c",
        authDomain: "lgu-admin2026.firebaseapp.com",
        projectId: "lgu-admin2026",
        storageBucket: "lgu-admin2026.firebasestorage.app",
        messagingSenderId: "219340905543",
        appId: "1:219340905543:web:8c84e64457e44d857e2562"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    onAuthStateChanged(auth, (user) => {
        if (user) {
            const uid = user.uid;
            const currentUrl = window.location.href;

            // Check if UID is already in the URL
            if (!currentUrl.includes('uid=')) {
                // Add UID to the URL
                const separator = currentUrl.includes('?') ? '&' : '?';
                window.history.replaceState({}, document.title, `${currentUrl}${separator}uid=${uid}`);
            }
        }
    });
</script>

@endsection
