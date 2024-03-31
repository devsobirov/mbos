<div class="modal modal-blur fade" id="project-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('projects.save-plan')}}" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <input type="hidden" name="plan_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->name ?: "Yangi tarif yaratish"}} ({{$project->name}})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Tarif yoki xizmat nomi <sup class="fw-bold text-danger">*</sup></label>
                    <input type="text" class="form-control" name="name" required value="{{$item->name ?: old('name')}}" placeholder="Abonent tulovi (50-70)">
                </div>
                <div class="mb-3">
                    <label class="form-label">Izoh</label>
                    <textarea class="form-control" name="description" rows="2"
                     placeholder="Abonent tulovi dastlabki xodimlar 50 xodim uchun 750'000 sum bazoviy narx, va keyingi xar bir qo’shimcha xodim uchun 1 oylik xizmat uchun 12'000 sumni tashkil qiladi"
                    >{{$item->description ?: old('description')}}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-3">
                        <label class="form-label">Bazaviy xizmat miqdori<sup class="fw-bold text-danger">*</sup></label>
                        <input type="number" class="form-control" name="base_amount" required value="{{$item->base_amount ?: old('base_amount')}}" placeholder="Masalan, 1 oylik obuna uchun">
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <label class="form-label">Birlikni tanlang <sup class="fw-bold text-danger">*</sup></label>
                        <select class="form-select" name="unit_id" required>
                            <option value="" selected disabled>Tanlang</option>
                            @foreach(\App\Helpers\UnitHelper::getUnits() as $id => $name)
                            <option value="{{$id}}" @if($item->unit_id == $id) selected="" @endif>{{$name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 col-sm-12 mb-3">
                        <label class="form-label">Bazaviy xizmat narxi <sup class="fw-bold text-danger">*</sup></label>
                        <input type="number" class="form-control" name="base_price" required value="{{$item->base_price ?: old('base_price')}}" placeholder="750'000 sum">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Qo'shimcha xizmat miqdori</label>
                        <input type="number" class="form-control" name="per_extra_amount" value="{{$item->per_extra_amount ?: old('per_extra_amount')}}" placeholder="Masalan, 1 qo'shimcha xodim uchun">
                    </div>
                    <div class="col-md-6 col-sm-12 mb-3">
                        <label class="form-label">Ko'rsatilgan qo'shimcha xizmat birligi uchun narx</label>
                        <input type="number" class="form-control" name="per_extra_price" value="{{$item->per_extra_price ?: old('per_extra_price')}}" placeholder="M-n, 12'000 sum">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-label">Status</div>
                    <label class="form-check form-switch">
                        <input class="form-check-input" @if($item->status) checked @endif name="status" type="checkbox" value="1">
                        <span class="form-check-label">Tarif reja aktiv</span>
                    </label>
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
