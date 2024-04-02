<div class="modal modal-blur fade" id="customer-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('customers.save')}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->name ?: "Yangi mijoz yaratish"}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tashkilot nomi <sup class="fw-bold text-danger">*</sup></label>
                    <input type="text" class="form-control" name="name" required value="{{$item->name ?: old('name')}}" placeholder="MBOS">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tashkilot rahbari FIO <sup class="fw-bold text-danger">*</sup></label>
                    <input type="text" class="form-control" name="fio" value="{{$item->fio ?: old('fio')}}" placeholder="Yusupov Mansur">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tel</label>
                    <input type="text" class="form-control" name="phone" value="{{$item->phone ?: old('phone')}}" placeholder="+998990000000">
                </div>

                <div class="mb-3">
                    <label class="form-label">INN</label>
                    <input type="text" class="form-control" name="inn" value="{{$item->inn ?: old('inn')}}" placeholder="555-555">
                </div>

                <div class="mb-3">
                    <label class="form-label">Tug'ilgan kun</label>
                    <input type="date" class="form-control" name="birthday" value="{{$item->birthday ? $item->birthday->format('Y-m-d') : ''}}" placeholder="1993-01-22">
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" value="{{$item->email ?: old('email')}}" placeholder="">
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" value="{{$item->address ?: old('address')}}" placeholder="">
                </div>

                <div class="mb-3">
                    <label class="form-label">Izoh</label>
                    <textarea type="text" class="form-control" name="notes" placeholder="...">{{$item->notes ?: old('notes')}}</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Bekor qilish
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
