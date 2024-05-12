<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('WEBSITE_TITLE', 'My Website')}}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#!">{{ env('WEBSITE_TITLE', 'My Website')}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @foreach($pages as $key => $page)
                    <li class="nav-item"><a href="#{{$page->title}}" class="nav-link">{{ $page->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header - set the background image for the header in the line below-->
    <header class="py-5 bg-image-full" style="background-image: url('https://source.unsplash.com/wfh8dDlNFOk/1600x900')">
        <div class="text-center my-5">
            <img class="img-fluid rounded-circle mb-4" src="https://dummyimage.com/150x150/6c757d/dee2e6.jpg" alt="..." />
            <h1 class="text-white fs-3 fw-bolder">Full Width Pics</h1>
            <p class="text-white-50 mb-0">Landing Page Template</p>
        </div>
    </header>

    <!-- Content section-->
    @foreach($pages as $key => $page)
    <section class="py-5" id="{{$page->title}}">
        <div class="container my-5">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    {!! $page->content !!}
                </div>
            </div>
        </div>
    </section>
    @endforeach

    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; {{now()->year}}</p>
        </div>
    </footer>
</body>

</html>