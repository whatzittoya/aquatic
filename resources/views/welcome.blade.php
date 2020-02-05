@extends('layouts.default')

<style>

    .welcome {
  display: none;
}

@media only screen and (max-width: 768px) {
  .welcome {
    display: block;
  }
}
</style>
@section('content')
<div id="carouselExampleIndicators" class="carousel slide col-md-12" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>

    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block img-fluid c-item " src="{{asset('img/1.jpeg')}}" alt="First slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
        <div class="carousel-item">

            <img class="d-block img-fluid c-item " src="{{asset('img/2.jpeg')}}" alt="Second slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block img-fluid c-item " src="{{asset('img/3.jpeg')}}" alt="Third slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block img-fluid c-item " src="{{asset('img/4.jpeg')}}" alt="Fourth slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
        <div class="carousel-item">

            <img class="d-block img-fluid c-item " src="{{asset('img/5.jpeg')}}" alt="Fifth slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
        <div class="carousel-item">
            <img class="d-block img-fluid c-item " src="{{asset('img/6.jpeg')}}" alt="Sixth slide">
            <div class="carousel-caption d-none d-md-block" style="background-color: rgba(108, 117, 125, 0.4);">
                <h3>Selamat Datang di Website Riau Aquatic</h3>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
                </p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<div class=" welcome " >
    <div class="row">
        <div class="col-12 p-0">
            <div class="jumbotron text-center m-4 d-flex flex-column justify-content-center">
                <h1 >Selamat Datang di Website Riau Aquatic</h1>
                <p class="lead">Bagi peserta yang ingan mendaftar silahkan klik link di bawah ini.</p>
                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="{{route('register')}}" role="button">Daftar</a>
</p>
</div>
</div>
</div>
</div>

@stop