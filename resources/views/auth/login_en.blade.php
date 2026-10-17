@extends('front.layout_en.app')



@section('title')
    Iniciar sesión
@endsection



@section('content')
    @include('front.layout_en.partials.menu')



    <div class="container my-5">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header text-center" style="font-size: 32px; font-weight: bold;">{{ __('Login') }}</div>



                    <div class="card-body">

                        <form method="POST" action="{{ route('login') }}">

                            @csrf


                            <input type="hidden" value="en" name="idioma">
                            <div class="form-group row">

                                <label for="email"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Email') }}</label>



                                <div class="col-md-6">

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>



                                    @error('email')
                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>
                                    @enderror

                                </div>

                            </div>



                            <div class="form-group row">

                                <label for="password"
                                    class="col-md-3 col-form-label text-md-right">{{ __('Password') }}</label>



                                <div class="col-md-6">

                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">



                                    @error('password')
                                        <span class="invalid-feedback" role="alert">

                                            <strong>{{ $message }}</strong>

                                        </span>
                                    @enderror

                                </div>

                            </div>



                            <div class="form-group row">

                                <div class="col-md-6 offset-md-3">

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>



                                        <label class="form-check-label" for="remember">

                                            {{ __('Remember') }}

                                        </label>

                                    </div>

                                </div>

                            </div>



                            <div class="form-group row mb-0">

                                <div class="col-md-6 offset-md-3 text-center">

                                    <button type="submit" class="btn btn-primary btn-block">

                                        {{ __('Login') }}

                                    </button>



                                    <div class="mt-3">

                                        {{ __('Do not you have an account yet?') }} <a class="btn-link"
                                            href="{{ route('register_en') }}">

                                            {{ __('Sign up') }}

                                        </a>

                                    </div>



                                    @if (Route::has('password.request'))
                                        <div>

                                            <a class="btn-link" href="{{ route('password.request') }}">

                                                {{ __('Did you forget your password?') }}

                                            </a>

                                        </div>
                                    @endif

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
