@extends('__layouts.auth')

@section('title', 'Login')

@section('content')

<div class="col-lg-6 d-none d-lg-block bg-login-image" style="{{ 'background-image: url('. asset('/img/privos-bg.jpg') .')' }}"></div>
<div class="col-lg-6">
<div class="p-5">
  <div class="text-center">
    <h1 class="h3 text-gray-900 mb-1">Perpustakaan - PRIVOS</h1>
  </div>
  <form class="user my-4" action="{{ route('login') }}" method="post">
    <div class="text-center">
      <label class="h6 text-gray-600 mb-4">login untuk memulai session</label>
    </div>
    @csrf
    <div class="form-group">
        <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="form-group">
      <div class="custom-control custom-checkbox small">
        <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="custom-control-label" for="customCheck">Tetap masuk</label>
      </div>
    </div>
    <hr>
    <button type="submit" class="btn btn-primary btn-user btn-block">
      Masuk
    </button>
  </form>
</div>
</div>

@endsection
