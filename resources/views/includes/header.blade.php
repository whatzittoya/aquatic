<nav class="navbar navbar-expand-xl navbar-dark bg-dark static-top">
    <div class="container">
        <img src="{{ asset('img/logo-sm.png') }}" width="80" style="padding-right: 15px;" />
        <a class="navbar-brand" href="{{ route('welcome')}}">Riau Aquatic</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav mr-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('about')}}">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('match_result')}}">Hasil Pertandingan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('contact')}}">Kontak</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{ url('guide')}}" target="_blank">Panduan Website</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="https://web.facebook.com/RiauAquaticPekanbaru/" target="_blank"><i class="fab fa-facebook pr-1  fa-2x"></i></a>
                   
                </li>
               <li class="nav-item ">
 <a class="nav-link" href="https://www.instagram.com/riauaquatic/" target="_blank"><i class="fab fa-instagram pr-1 fa-2x"></i></a>
                  
               </li>

                <li class="nav-item ">
                    <a class="nav-link" href="https://www.youtube.com/channel/UC7FMuwrTSHELgjl8RNfg9Cw" target="_blank"><i class="fab fa-youtube pr-1 fa-2x"></i></a>  
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login')}}">Login</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('register')}}">Register</a>
                </li>
                @endguest
                @auth
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('members')}}">Dashboard</a>
                </li>

                @endauth
                <!-- note the end auth -->

            </ul>
        </div>
    </div>
</nav>