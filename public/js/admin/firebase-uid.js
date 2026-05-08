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

        // Store UID in sessionStorage for access across pages
        sessionStorage.setItem('firebaseUID', uid);

        // Update all links with data-uid attribute
        const links = document.querySelectorAll('[data-uid="true"]');
        links.forEach(link => {
            const baseHref = link.getAttribute('href');
            if (baseHref && !baseHref.includes('uid=')) {
                const separator = baseHref.includes('?') ? '&' : '?';
                link.href = `${baseHref}${separator}uid=${uid}`;
            }
        });

        // Display UID in elements with class firebase-uid
        const uidElements = document.querySelectorAll('.firebase-uid');
        uidElements.forEach(el => {
            el.textContent = uid;
        });

        // Dispatch custom event for other scripts to listen
        window.dispatchEvent(new CustomEvent('firebaseUserLoaded', { detail: { uid } }));
    } else {
        sessionStorage.removeItem('firebaseUID');
    }
});
