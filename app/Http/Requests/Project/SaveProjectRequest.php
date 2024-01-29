<?php

namespace App\Http\Requests\Project;

use App\Helpers\UploadImageHelper;
use Illuminate\Foundation\Http\FormRequest;

class SaveProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:projects,name,'.$this->project_id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image'
        ];
    }

    protected function passedValidation()
    {
        if ($this->file('logo')) {
            // If 'logo' file exists, store the image and replace 'logo' with the uploaded file path
            $uploadedFile = UploadImageHelper::uploadAndGetPath($this->file('logo'));
            $this->merge(['logo' => $uploadedFile]);
        }  else {
            // If 'logo' file doesn't exist, remove the 'logo' key
            $this->request->remove('logo');
        }
    }
}
