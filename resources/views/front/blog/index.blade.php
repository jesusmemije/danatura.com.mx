@extends('front.layout.app')

@section('title')
Blog
@endsection

@section('styles')
<style>
    .title-blog {
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
            <h1 class="title-blog">Últimas publicaciones</h1>
        </div>
    </div>
    <div class="card-deck my-5">

        @foreach ($blogs as $blog)

        <div class="card">
            <img class="card-img-top" src="{{ asset('images/blog/default.png') }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $blog->titulo }}</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                    content. This content is a little bit longer.</p>
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