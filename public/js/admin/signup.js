// Import the functions you need from the SDKs you need
import { initializeApp } from "https://www.gstatic.com/firebasejs/12.10.0/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/12.10.0/firebase-auth.js";

// Your web app's Firebase configuration
const firebaseConfig = {
    apiKey: "AIzaSyBQPx0Yoc_f8goGGZVQKXCaQaK2cV6s-1c",
    authDomain: "lgu-admin2026.firebaseapp.com",
    projectId: "lgu-admin2026",
    storageBucket: "lgu-admin2026.firebasestorage.app",
    messagingSenderId: "219340905543",
    appId: "1:219340905543:web:8c84e64457e44d857e2562"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app);

// Toggle password visibility
function togglePassword() {
    const passwordInput = document.getElementById('password');
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

// Make togglePassword available globally
window.togglePassword = togglePassword;

// Handle signup form submission
const submit = document.getElementById('submit');
submit.addEventListener("click", function (event) {
    event.preventDefault();

    // Get input values
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const name = document.getElementById('name')?.value || '';

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        alert('Security error: CSRF token not found. Please refresh the page.');
        return;
    }

    // First, authenticate with Firebase
    createUserWithEmailAndPassword(auth, email, password)
        .then((userCredential) => {
            // Firebase user created successfully
            const firebaseUser = userCredential.user;

            // Then, save user data to Laravel backend
            return fetch('/signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                credentials: 'include',
                body: JSON.stringify({
                    email: email,
                    password: password,
                    name: name || email,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Account created successfully! Redirecting to dashboard...");
                    window.location.href = '/dashboard';
                } else {
                    throw new Error(data.message || 'Failed to create account');
                }
            });
        })
        .catch((error) => {
            const errorCode = error.code;
            const errorMessage = error.message;
            console.error('Error:', errorCode, errorMessage);
            alert(`Error: ${errorMessage}`);
        });
});


