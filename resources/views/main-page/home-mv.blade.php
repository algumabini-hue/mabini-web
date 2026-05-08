{{-- Top Border --}}
<div class="ornate-divider-top"></div>

{{-- Content Box: Max-width keeps text readable, Lato font applied --}}
<div class="content-box text-center px-4 py-5 mx-auto" style="max-width: 900px; font-family: 'Lato', sans-serif;">

    {{-- MISSION SECTION --}}
    <div class="mb-5 pb-3">
        <h3 class="fw-bolder text-uppercase mb-4" style="color: #4d6057; letter-spacing: 3px; font-size: 2rem;">
            Mission
        </h3>
        <p class="mission-vision-text fw-normal text-secondary mb-0">
            CREATE AN ENVIRONMENT CONDUCIVE TO SUSTAINABLE AGRICULTURAL, INDUSTRIAL AND TRADE DEVELOPMENT;<br><br>
            STRIVE TO PROVIDE COMPREHENSIVE SERVICES TO ITS CONSTITUENTS;<br><br>
            EQUITABLE DISTRIBUTION OF RESOURCES;<br><br>
            ACTIVE INVOLVEMENT OF PUBLIC AND PRIVATE SECTORS IN THE DEVELOPMENT OF THE MUNICIPALITY;<br><br>
            GENDER SENSITIVE DEVELOPMENT PROGRAMS AND PROJECTS; AND;<br><br>
            STRENGTHEN AND EMPOWERMENT OF CONSTITUENTS TO BE MORE RESILIENT TO OCCURRENCE OF DISASTER.
        </p>
    </div>

    {{-- VISION SECTION --}}
    <div class="mt-4 pt-3">
        <h3 class="fw-bolder text-uppercase mb-4" style="color: #4d6057; letter-spacing: 3px; font-size: 2rem;">
            Vision
        </h3>
        <p class="mission-vision-text fw-normal text-secondary mb-0">
            MABINI ENVISIONS TO BECOME A PROGRESSIVE, EMPOWERED, AND DISASTER-RESILIENT MUNICIPALITY
            WHERE ITS GENDER RESPONSIVE CONSTITUENTS LIVE BETTER QUALITY OF LIFE BEING UNITED,
            ECONOMICALLY AND SOCIALLY STABLE, MORALLY UPRIGHT, CULTURALLY CONSCIOUS AND ENVIRONMENTALLY
            ORIENTED ENJOYING THE BENEFITS OF EFFECTIVE GOVERNANCE, DEMOCRACY AND SUSTAINABLE GROWTH
            AND DEVELOPMENT.
        </p>
    </div>

</div>

{{-- Bottom Border --}}
<div class="ornate-divider-bottom"></div>

<style>
    /* --- TYPOGRAPHY STYLING --- */
    .mission-vision-text {
        font-size: 1.15rem;
        line-height: 1.5;
        /* Gives the text room to breathe */
        letter-spacing: 0.5px;
    }

    /* --- ORNATE FILIGREE DIVIDERS --- */
    .ornate-divider-top,
    .ornate-divider-bottom {
        width: 100%;
        height: 150px;
        margin: 10px auto;
        background-color: #4d6057;
        /* Matches the heading color */

        -webkit-mask-size: contain;
        mask-size: contain;
        -webkit-mask-repeat: no-repeat;
        mask-repeat: no-repeat;
        -webkit-mask-position: center;
        mask-position: center;
    }

    .ornate-divider-top {
        -webkit-mask-image: url('/images/borders/border-top.png');
        mask-image: url('/images/borders/border-top.png');
    }

    .ornate-divider-bottom {
        -webkit-mask-image: url('/images/borders/border-bottom.png');
        mask-image: url('/images/borders/border-bottom.png');
    }

    @media (min-width: 992px) {

        .ornate-divider-top,
        .ornate-divider-bottom {
            max-width: 1000px;
        }
    }

    /* Slightly smaller text on mobile devices */
    @media (max-width: 768px) {
        .mission-vision-text {
            font-size: 1rem;
        }
    }
</style>


































{{--
<div class="container mt-2 pt-4 scroll-fade-in">

    <div class="row">
        <div class="col-12">
            <div class="ribbon-header">
                <h3>CONTACT US</h3>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-brands fa-facebook-f"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">Lorem ipsum dolor sit amet</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-brands fa-x-twitter"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">Lorem ipsum dolor sit amet</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-brands fa-instagram"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">Lorem ipsum dolor sit amet</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">lorem.ipsum@example.com</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">+63 912 345 6789</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-solid fa-location-dot"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">Lorem ipsum dolor sit amet</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-brands fa-youtube"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">Lorem ipsum dolor sit amet</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="contact-item">
                <div class="contact-icon">
                    <i class="fa-solid fa-globe"></i>
                </div>
                <div class="contact-text-box">
                    <a href="#">www.loremipsum.gov.ph</a>
                </div>
            </div>
        </div>

    </div>
</div> --}}