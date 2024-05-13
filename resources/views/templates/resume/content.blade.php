@if(isset($page) && $page != null)
<section class="py-5" id="{{$page->title}}">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</section>
@endif