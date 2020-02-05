
@extends('layouts.default')

<style>
body{
  background-color: #e9ecef !important;
}

  </style>
@section('content')
<style>
  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
  a { color: #dc8100; text-decoration: none; }
  a:hover { color: #333; text-decoration: none; }
</style>

<article>
  <div class="container mt-5">
    <h1>Halaman belum tersedia!</h1>
    <div>
        <p>Mohon maaf atas ketidaknyamanannya Halaman ini sedang dalam proses pembuatan. Harap menunggu kami akan segera kembali</p>
        <p><a href="{{ URL::previous() }}" class="btn-primary btn">Kembali</a></p>
    </div>
  </div>
</article>
@stop