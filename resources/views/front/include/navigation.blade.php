@php
    $isHomePage = request()->is('/');
@endphp

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="{{ $isHomePage ? '#page-top' : route('home') }}">
            <img src="{{ asset('img/navbar-logo.png') }}" alt="..." />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            القائمة
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isHomePage ? '#goals' : route('home') . '#goals' }}">أهدافنا</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isHomePage ? '#activities' : route('home') . '#activities' }}">نشاطاتنا</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isHomePage ? '#about' : route('home') . '#about' }}">من نحن؟</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isHomePage ? '#members' : route('home') . '#members' }}">الأعضاء</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ $isHomePage ? '#contact' : route('home') . '#contact' }}">تواصل معنا</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
