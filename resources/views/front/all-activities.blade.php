@extends('front.include.layout')

@section('content')

    <!-- Headere-->
    @include('front.include.header')

    <section class="page-section bg-light" id="all-posts">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">نشاطاتنا</h2>
            </div>

            <div class="row">
                <post-list :posts="{{ json_encode($posts->items()) }}"></post-list>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

@endsection
