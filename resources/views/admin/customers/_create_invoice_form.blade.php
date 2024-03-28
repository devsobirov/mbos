<div class="modal modal-blur fade" id="invoice-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div x-data="invoiceFormData()" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="#" @submit.prevent="" class="modal-content" method="POST">
            @csrf
            <input type="hidden" name="customer_id" value="{{$item->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$item->name}} uchun yangi shartnoma yaratish</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">Loyihani tanlang</label>
                            <select type="text" name="url" x-model="url" required class="form-select">
                                <option :value="null" :selected="!url" disabled>Tanlang</option>
                                @foreach($projects as $project)
                                    <option value="{{route('invoices.create', ['customer' => $item->id, 'project' => $project->id])}}">
                                        {{$project->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Bekor qilish
                </a>
                <button class="ms-auto" :class="isValid() ? 'btn btn-primary ' : 'invisible'" @click="next()">
                    <x-svg.plus></x-svg.plus> Davom etish
                </button>
            </div>
        </form>
    </div>
</div>
