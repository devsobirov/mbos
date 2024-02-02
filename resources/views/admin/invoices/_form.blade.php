<div class="modal modal-blur fade" id="invoice-form-{{$item->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div x-data="invoiceFormData()" class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('projects.save-plan')}}" class="modal-content" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Select the project</label>
                            <select type="text" name="project_id" required class="form-select" x-model="form.project_id">
                                <option :value="null" :selected="!form.project_id" disabled>Choose from list</option>
                                <template x-show="projectList.length" x-for="item in projectList" :key="item.id">
                                    <option :value="item.id" x-text="item.name"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3" x-show="form.project_id" x-cloak>
                            <label class="form-label">Select the plan</label>
                            <template x-show="form.project_id && getPlans().length" x-for="item in getPlans()">
                                <div>
                                    <label class="form-check">
                                        <input class="form-check-input" name="plan_id" type="radio" :value="item.id" x-model="form.plan_id">
                                        <span class="form-check-label" x-text="item.name"></span>
                                        <span class="form-check-description" x-text="item.description"></span>
                                    </label>
                                </div>
                            </template>
                            <p x-cloak x-show="!getPlans().length">Tarif planlar topilmadi</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                </a>
                <button class="btn btn-primary ms-auto">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
                    Save plan
                </button>
            </div>
        </form>
    </div>
</div>
