@extends('front.include.layout')

@section('content')

    <!-- Headere-->
    @include('front.include.header')

    <section class="page-section bg-light" id="all-members">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">الأعضاء</h2>
            </div>
            
            <div class="row">
                <member-list :members="{{ json_encode($members) }}"></member-list>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $members->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

@endsection
