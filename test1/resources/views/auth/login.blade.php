@extends('auth.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<div class="container">
    <div class="card">

        <div class="card-body">
            @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
            @endif
            <a href="/" class="back-button">
                <i class="fa fa-arrow-left"></i>
            </a>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">

                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                        autocomplete="email" autofocus placeholder="Email">
                </div>

                <div class="form-group">
                    <input id="password" type="password" class="form-control" name="password" required
                        autocomplete="current-password" placeholder="Password">
                </div>

                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection