<div class="modal modal-blur fade" id="user-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('users.save', $item->id)}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->name ?: "Yangi mijoz yaratish"}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                    <div class="mb-3">
                        <label class="form-label required">Имя</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Имя" value="{{ old('name', $item->name) }}" required>
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label required">Логин</label>
                        <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Логин" value="{{ old('email', $item->email) }}" required>
                    </div>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label class="form-label">Ид пользователя в телеграме</label>
                        <input type="text" name="telegram_chat_id" class="form-control @error('telegram_chat_id') is-invalid @enderror" placeholder="Telegram chatId" value="{{ old('telegram_chat_id', $item->telegram_chat_id) }}">
                    </div>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if($item->isAdmin())
                    <div class="mb-3">
                        <label class="form-label">Роль</label>
                        <select type="text" name="role" class="form-select" required>
                            <option selected value="99">Админ</option>
                        </select>
                    </div>
                    @else
                    <div class="mb-3">
                        <label class="form-label">Роль</label>
                        <select type="text" name="role" class="form-select" >
                            <option value="">Макомсиз</option>
                            <option value="55" @if($item->role == 55) selected @endif>Ходим</option>
                        </select>
                    @endif
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
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                </a>
                <button class="btn btn-primary ms-auto">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Saqlash
                </button>
            </div>
        </form>
    </div>
</div>
