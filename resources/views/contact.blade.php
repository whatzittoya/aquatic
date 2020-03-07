@extends('layouts.default')


@section('content')

<style>
    .btn-fb {
    color: #fff !important;
    background-color: #3b5998 !important;
}
.btn-ins {
    color: #fff !important;
    background-color: #c61111 !important;
}
.btn-yt {
    color: #fff !important;
    background-color: #ed302f !important;
}
</style>
<div class="container-fluid pt-2">
  
 
       <h2><center> Hubungi Kami </center></h2>
       <div class="row">
          
        <div class="col-md-10">
               <div class="float-md-right "><center>
<img src='{{asset("img/logo.png")}}' class="img-fluid"/></center>
        </div>
            Apabila anda memiliki pertanyaan atau ingin mengetahui informasi lebih lanjut silahkan hubungi kami di:
        
            <h5 class=" pt-3 ">Handphone: <strong class="text-primary">0812 6161 6566</strong></h5>
             <h5 class=" pt-3 pb-3">Email: <strong class="text-primary">riauaquatic@gmail.com</strong></h5>
        </div>
      
        </div>
   <div class="row">
        <div class="col-md-12">
                <div class="float-md-right "><center>
<img src='{{asset("img/1.jpeg")}}' class="img-fluid" width="500px"/></center>
        </div>
  <h3> Sosial Media:</h3>
            <p>
<a type="button" href="https://web.facebook.com/RiauAquaticPekanbaru/" class="btn btn-fb" target="_blank"><i class="fab fa-facebook-f pr-1"></i> Facebook</a>  <strong>@RiauAquaticPekanbaru</strong>

</p>
<p>
<a href="https://www.instagram.com/riauaquatic/" class="btn btn-ins" target="_blank"><i class="fab fa-instagram pr-1"></i> Instagram</a>
<strong>@riauaquatic</strong>  
</p>
<p>
<a href="https://www.youtube.com/channel/UC7FMuwrTSHELgjl8RNfg9Cw" class="btn btn-yt" target="_blank">
  <i class="fab fa-youtube pr-1"></i>
  Youtube
</a>
<strong>Riau Aquatic</strong>  
</p>

             </div>
         

        </div>

        </div>
   </div>
</div>
@stop