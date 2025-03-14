<?php

namespace App\Modules\Pet\Requests;

use App\Modules\Pet\Enums\PetStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOrUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
            'category.id' => 'integer',
            'category.name' => 'string',
            'photoUrls' => 'required|array|min:1',
            'photoUrls.*' => 'url',
            'tags' => 'array',
            'tags.id' => 'integer',
            'tags.name' => 'string',
            'status' => [Rule::enum(PetStatus::class)]
        ];
    }
}
