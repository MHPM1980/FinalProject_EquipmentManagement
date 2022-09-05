@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-sm-10">
                <div class="bg-transparent">
                    <div class="card-header border-0 bg-transparent text-light">
                        <div class="row align-items-center justify-content-center">
                            <h1 class="col-md-6 order-2 order-md-1 text-center pt-md-2 pt-4">{{ __('Bem-Vindo') }}</h1>
                            <img class="order-1 order-md-2" src= "https://trainingserver.atec.pt/trainingserver/Controls/ImageRender.aspx?ImageId=5cccaf2a-94ba-47ed-a8bf-0f103aeaf800&ImageType=Normal" alt="" height="80px">
                        </div>
                    </div>
                    <div class="card-body bg-transparent text-light">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail:') }}</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password:') }}</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-lg-8 offset-xl-7 offset-md-6 my-2">
                                    <button class="btn btn-dark">
                                        <a class="text-light" style="text-decoration: none" href="{{ route('register') }}">Registar</a>
                                    </button>
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
