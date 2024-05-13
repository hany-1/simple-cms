<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="{{url('/')}}">{{ env('WEBSITE_TITLE', 'My Website')}}</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbar">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                @foreach(\App\Models\Post::allPages() as $key => $page)
                <li class="nav-item"><a href="{{$page->link}}" class="nav-link">{{ $page->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>