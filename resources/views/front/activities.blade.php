<section class="page-section bg-light" id="activities">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">نشاطاتنا</h2>
        </div>
        <div>
            <post-list :posts="{{ json_encode($posts) }}"></post-list>
        </div>
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('posts.index') }}" class="btn btn-primary btn-xl text-uppercase">عرض المزيد</a>
    </div>
</section>
