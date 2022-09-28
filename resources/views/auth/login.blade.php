@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-sm-10">
                <div class="bg-transparent">
                    <div class="card-header border-0 bg-transparent text-light">
                        <div class="row align-items-center justify-content-center">
                            <img class="atec-ge-login" src= "./img/atec-ge-white.png" alt="">
                            <h1 class="col-md-6 text-center pt-md-2 pt-4">{{ __('Bem-Vindo') }}</h1>
                        </div>
                    </div>
                    <div class="card-body bg-transparent text-light">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('E-Mail:') }}</label>
                                <div class="col-md-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="exemplo@edu.atec.pt">
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password:') }}</label>
                                <div class="col-md-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="********">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 my-2 d-flex justify-content-between offset-md-2">
                                        <a class="btn btn-dark text-light" style="text-decoration: none" href="{{ route('register') }}">Registar</a>
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
