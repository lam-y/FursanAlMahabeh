<!DOCTYPE html>
<html lang="en">
    @include('front.include.head')
    <body id="page-top">
        <!-- Navigation -->
        @include('front.include.navigation')

        <!-- Vue Root -->
        <div id="app">
            @yield('content')
        </div>

        <!-- Footer -->
        @include('front.include.footer')

        <!-- Bootstrap core JS -->
        @include('front.include.scripts')
        @yield('script')
    </body>
</html>
