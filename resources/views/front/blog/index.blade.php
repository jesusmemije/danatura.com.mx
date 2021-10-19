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

        @foreach ($blogs as $blog)

        <div class="card">
            <img class="card-img-top" src="{{ asset('images/blog/default.png') }}" alt="Card image cap">
            <div class="card-body">
                <a href="{{ route('blog.show', $blog->id) }}"><h5 class="card-title">{{ $blog->titulo }}</h5></a>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
                <a href="{{ route('blog.show', $blog->id) }}" class="btn btn-primary">Ver publicación</a>
            </div>
            <div class="card-footer">
                <small class="text-muted">{{ $blog->getDateShowBlog( $blog->created_at ) }}</small>
                <footer class="blockquote-footer">{{ $blog->autor }} en <cite title="Source Title">Danatura</cite></footer>
            </div>
        </div>
            
        @endforeach

    </div>
</div>

@endsection

@section('scripts')
@endsection