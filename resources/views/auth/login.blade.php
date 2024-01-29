@extends('admin.layouts.guest')

@section('content')
    <form class="card card-md" action="{{ route('login') }}" method="post" autocomplete="off">
        @csrf

        <div class="card-body">
            <h2 class="card-title text-center mb-4">Вход в систему</h2>

            <div class="mb-3">
                <label class="form-label">Логин</label>
                <input type="text" name="email" value="{{ old('email', '') }}" class="form-control @error('email') is-invalid @enderror" placeholder="Ваш логин" required autofocus tabindex="1">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <input type="password" name="password" value="" class="form-control @error('password') is-invalid @enderror" placeholder="Ваш пароль" required tabindex="2">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label class="form-check">
                    <input type="checkbox" class="form-check-input" tabindex="3" name="remember" />
                    <span class="form-check-label">Запомнить на этом устройстве</span>
                </label>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100" tabindex="4">Вход</button>
            </div>
        </div>
    </form>

@endsection
