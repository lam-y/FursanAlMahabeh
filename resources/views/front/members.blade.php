<section class="page-section bg-light" id="members">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">أعضاء الفريق</h2>
        </div>
        <div>
            <member-list :members="{{ json_encode($members) }}"></member-list>
        </div>
        <div class="text-center mt-4 mb-5">
            <a href="{{ route('members.index') }}" class="btn btn-primary btn-xl text-uppercase">عرض المزيد</a>
        </div>
        <div class="row mt-1 mb-1">
            <div class="col-lg-8 mx-auto text-center"><p class="large text-muted text-center fs-5 fw-bold">للإنضمام إلى فرقة فرسان المحبة، رجاءً راسلنا عبر النموذج في الأسفل (تواصل معنا)</p></div>
        </div>
    </div>
</section>
