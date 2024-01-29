@extends('admin.layouts.app')

@section('content')
    <div class="container-xl">
        <!-- Page title -->
        <div class="page-header d-print-none">
            <div class="row align-items-center">
                <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    {{ config('app.name') }}
                </div>
                    <h2 class="page-title">
                        Мой аккаунт
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">

            @if ($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible">
                <div class="d-flex">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l5 5l10 -10"></path>
                        </svg>
                    </div>
                    <div>
                        {{ $message }}
                    </div>
                  </div>
                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" class="card" autocomplete="off">
                @csrf
                @method('PUT')

                <div class="card-body">


                    <div class="mb-3">
                        <label class="form-label required">Имя</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Логин</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Логин" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label">Ид пользователя в телеграме</label>
                        <input type="text" name="telegram_chat_id" class="form-control @error('telegram_chat_id') is-invalid @enderror" placeholder="Telegram chatId" value="{{ old('telegram_chat_id', auth()->user()->telegram_chat_id) }}">
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Новый пароль</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Новый пароль">
                    </div>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Повторите пароль</label>
                        <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="Повторите пароль" autocomplete="new-password">
                    </div>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Созранить</button>
                </div>

            </form>

        </div>
    </div>

@endsection
