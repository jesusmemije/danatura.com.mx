@extends('front.layout_en.app')

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
@include('front.layout_en.partials.menu')

<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5 text-center">
            <h1 class="title-section-blog">Latest posts</h1>
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
                    <a href="blog_en?id={{$blog->id}}" class="btn btn-primary">See publication</a>
                </div>
                <div class="card-footer">
                    <small class="text-muted">{{ $blog->getDateEnShowBlog( $blog->created_at ) }}</small>
                    <footer class="blockquote-footer">{{ $blog->autor }} in <cite title="Source Title">Danatura</cite></footer>
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