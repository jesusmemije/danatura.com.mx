@extends('front.layout_en.app')



@section('title')

Gallery


@endsection



@section('styles')

<link rel="stylesheet" href="{{asset('assets/css/productos.css')}}">

<style>

  .mybadge {

    line-height: 1.3;

    padding: 10px;

  }

</style>

@endsection



@section('content')



@include('front.layout_en.partials.menu')



<div class="container-fluid">

  <div class="row">
    <div class="col-md-12">
        <style>
            .galeria > a{
                display: block;
                position: relative;
                overflow: hidden;
                box-shadow: 0 0 6px rgba(0, 0, 0, .5);
            }
            .galeria{
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                width: 85%;
                margin: auto;
                grid-gap: 15px;
                padding: 20px 0;
                overflow: hidden;
            }
            .galeria img{
                width: 100%;
                vertical-align: top;
                height: 300px;
                object-fit: cover;
                transition: transform 0.5s;
            }
            .galeria a:hover img{
                filter: blur(2px);
                transform: rotate(10deg) scale(1.3);
            }
            .light-box{
                position: fixed;
                top: 0;
                left: 0;
                background: rgba(0, 0, 0, .5);
                transition: transform .3s ease-in-out;
                width: 100%;
                height: 100vh;
                z-index: 2000;
                display: flex;
                justify-content: center;
                align-items: center;
                transform: scale(0);
            }
            .light-box img{
                width: 30vw;
                /* max-height: 70vh; */
            }
            .light-box:target{
                transform: scale(1);
            }
            .close{
                display: block;
                position: absolute;
                top: 40px;
                right: 40px;
                background: #f79860;
                color: #fff;
                width: 50px;
                height: 50px;
                text-decoration: none;
                border-radius: 4px;
                text-align: center;
                line-height: 45px;

            }
            .close:hover{
                color: #fff;
            }
            .next{
                display: block;
                /* background: #f79860; */
                color: #fff;
                height: 50px;
                width: 50px;
                line-height: 50px;
                text-decoration: none;
            }
            .next img{
                width: 50px;
                
            }

        </style>
    
        <section class="galeria">
    
            {{-- <span class="linea"></span> --}}
            <a href="#image1">
                <img src="{{asset('images/galeria/DSC05324.png')}}" alt="">
            </a>
            <a href="#image2">
                <img src="{{asset('images/galeria/DSC05326.jpg')}}" alt="">
            </a>
            <a href="#image3">
                <img src="{{asset('images/galeria/DSC05376.jpg')}}" alt="">
            </a>
            <a href="#image4">
                <img src="{{asset('images/galeria/DSC05506.jpg')}}" alt="">
            </a>
            <a href="#image5">
                <img src="{{asset('images/galeria/DSC05520.jpg')}}" alt="">
            </a>
            <a href="#image6">
                <img src="{{asset('images/galeria/DSC05548.jpg')}}" alt="">
            </a>
            <a href="#image7">
                <img src="{{asset('images/galeria/DSC05605.jpg')}}" alt="">
            </a>
            <a href="#image8">
                <img src="{{asset('images/galeria/DSC06574.jpg')}}" alt="">
            </a>
            <a href="#image9">
                <img src="{{asset('images/galeria/DSC06674.jpg')}}" alt="">
            </a>
            <a href="#image10">
                <img src="{{asset('images/galeria/DSC06701.jpg')}}" alt="">
            </a>
            <a href="#image11">
                <img src="{{asset('images/galeria/DSC06742.jpg')}}" alt="">
            </a>
    
        </section>
        <article class="light-box" id="image1">
            <a href="#image11" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05324.png')}}" alt="">
            <a href="#image2" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image2">
            <a href="#image1" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05326.jpg')}}" alt="">
            <a href="#image3" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image3">
            <a href="#image2" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05376.jpg')}}" alt="">
            <a href="#image4" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image4">
            <a href="#image3" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05506.jpg')}}" alt="">
            <a href="#image5" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image5">
            <a href="#image4" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05520.jpg')}}" alt="">
            <a href="#image6" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image6">
            <a href="#image5" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05548.jpg')}}" alt="">
            <a href="#image7" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image7">
            <a href="#image6" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC05605.jpg')}}" alt="">
            <a href="#image8" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image8">
            <a href="#image7" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC06574.jpg')}}" alt="">
            <a href="#image9" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image9">
            <a href="#image8" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC06674.jpg')}}" alt="">
            <a href="#image10" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image10">
            <a href="#image9" class="next">
                <img src="{{asset('assets/img/izq_blanco.png')}}" width="20px" alt="">
            </a>
            <img src="{{asset('images/galeria/DSC06701.jpg')}}" alt="">
            <a href="#image11" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        <article class="light-box" id="image11">
            <a href="#image10" class="next"><img src="{{asset('assets/img/izq_blanco.png')}}" alt=""></a>
            <img src="{{asset('images/galeria/DSC06742.jpg')}}" alt="">
            <a href="#image1" class="next">
                <img src="{{asset('assets/img/der_blanco.png')}}" width="20px" alt="">
            </a>
            <a href="#" class="close">x</a>

        </article>
        
    </div>



    <div class="col-md-12">

      <div id="post_data" class="row ">

      </div>

    </div>

  </div>

  <!--main row-->

</div>



<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"

  aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header">

        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        ...

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

        <button type="button" class="btn btn-primary">Save changes</button>

      </div>

    </div>

  </div>



</div>



@endsection



@section('scripts')



<script>



</script>



@endsection