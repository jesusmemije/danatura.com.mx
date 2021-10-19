@extends('front.layout.app')

@section('title')
    {{ $blog->titulo }}
@endsection

@section('styles')
<style>
    .title-blog {
        font-family: 'AmasisMTStd-Bold'; 
        color: #F79860; 
        font-size: 38px;
        font-weight: 800;
    }
</style>
@endsection

@section('content')
@include('front.layout.partials.menu')
    <div class="container my-5">
        <div class="row my-5">
            <div class="col-md-6 align-self-center ">
                <div class="title-blog">{{ $blog->titulo }}</div>
            </div>
            <div class="col-md-6 align-self-center text-right">
                <div class="text-muted">{{ $blog->getDateShowBlog( $blog->created_at ) }}</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @php echo $blog->contenido; @endphp
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection