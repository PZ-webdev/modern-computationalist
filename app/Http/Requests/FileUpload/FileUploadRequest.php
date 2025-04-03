<?php

declare(strict_types=1);

namespace App\Http\Requests\FileUpload;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

final class FileUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'files' => ['required', 'array'],
            'files.*' => ['required', 'max:2048'], // 2MB,
        ];
    }
}
