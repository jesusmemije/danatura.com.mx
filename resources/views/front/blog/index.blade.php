@extends('front.layout.app')

@section('title')
Blog
@endsection

@section('styles')
<style>
    .title-section-blog {
        font-family: 'AmasisMTStd-Bold'; 
        color: #F79860; 
        font-size: 48px;
    }
</style>
@endsection

@section('content')
@include('front.layout.partials.menu')

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5 text-center">
            <h1 class="title-section-blog">Últimas publicaciones</h1>
        </div>
    </div>
    <div class="card-deck my-5">

        <?php
                              
            foreach ($blogs as $blog) {

                $imagen = $blog->portada;
                $source = "assets/blogs/".$imagen;
                $source = $imagen;
                        
                if ( $imagen == "" ) {
                    $source = asset("assets/blogs/default.png");
                }
                                
                if ( strpos($source, 'https') !== false ) {
                    $source = $source;
                } else {
                    $source = asset("assets/blogs")."/".$imagen;
                }

                $array_galeria = explode('|',$blog->portada);
                $foto_principal = $array_galeria[0];
        ?>

        <div class="col-md-4 mb-5">
            <div class="card">
                <img class="card-img-top" src="{{ $foto_principal }}" alt="Card image cap">
                <div class="card-body">
                    <a href="{{ route('blog.show', $blog->id) }}"><h5 class="card-title">{{ $blog->titulo }}</h5></a>
                    <p class="card-text text-justify">{{$blog->resumen}}</p>
                    <a href="{{ route('blog.show', $blog->id) }}" class="btn btn-primary">Ver publicación</a>
                </div>
                <div class="card-footer">
                    <small class="text-muted">{{ $blog->getDateShowBlog( $blog->created_at ) }}</small>
                    <footer class="blockquote-footer">{{ $blog->autor }} en <cite title="Source Title">Danatura</cite></footer>
                </div>
            </div>
        </div>
            
        <?php
            }
        ?>

    </div>
</div>

@endsection

@section('scripts')
@endsection