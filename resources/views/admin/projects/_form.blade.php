<div class="modal modal-blur fade" id="project-form-{{$project->id}}" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form action="{{route('projects.save')}}" class="modal-content" enctype="multipart/form-data" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{$project->id}}">
            <div class="modal-header">
                <h5 class="modal-title">{{$project->name ?: "Yangi loyiha"}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nomi</label>
                    <input type="text" class="form-control" name="name" required value="{{$project->name ?: old('name')}}" placeholder="Your report name">
                </div>
                <div class="mb-3 row">
                    <div class="col-md-8">
                        <label class="form-label">Logo</label>
                        <input type="file" accept="image/*" class="form-control" name="logo">
                    </div>
                    <div class="col-md-4">
                        <img src="{{$project->logoUrl()}}" alt="">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Qo'shimcha ma'lumot</label>
                    <textarea class="form-control" name="description" rows="3">{{$project->description ?: old('description')}}</textarea>
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
