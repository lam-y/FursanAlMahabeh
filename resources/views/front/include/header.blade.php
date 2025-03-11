@php
    $isHomePage = request()->is('/');
@endphp

<header class="masthead">
    <div class="container">
        <div class="masthead-subheading">كُحليُ الحكمـةِ فكرُنا <span class="space">عملُنا خمريُ العطـاء</div>
        <div class="masthead-heading text-uppercase">فرسان المحبة</div>
        <a class="btn btn-primary btn-xl text-uppercase" href="{{ $isHomePage ? '#goals' : route('home') . '#goals' }}">تعرف علينا</a>
    </div>
</header>
