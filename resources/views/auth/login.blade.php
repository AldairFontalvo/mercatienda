@extends('layout.app')
@section('content')
    <main class="form-signin w-100 m-auto">
        <form method="POST" action="{{ route('login') }}" novalidate>
            @csrf
            <h1>MERCATIENDA</h1>
            <p class="h4 mb-3 fw-normal">Por favor inicie sesión</p>
            @if (session('mensaje'))
                <div class="alert alert-danger" role="alert">
                    {{ session('mensaje') }}
                </div>
            @endif
            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email</label>
                @error('email')
                    <div class="invalid-feedback d-flex">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-floating mt-2 mb-2">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
                @error('password')
                    <div class="invalid-feedback d-flex">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="btn btn-primary w-100 py-2" type="submit">Iniciar Sesión</button>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2024</p>
        </form>
    </main>
@endsection
