<?php

declare(strict_types=1);

namespace App\Http\Requests\StudentCard;

use App\Enums\SchoolEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                'required',
                'exists:users,id',
            ],
            'school' => [
                'required',
                new Enum(
                    type: SchoolEnum::class,
                ),
            ],
            'description' => [
                'nullable',
                'min:10',
                'max:700',
            ],
            'is_internal' => [
                'required',
                'boolean',
            ],
            'date_of_birth' => [
                'required',
                'date_format:Y-m-d',
                'before:-11 years',
                'after:-50 years',
            ],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_internal' => $this->boolean('is_internal'),
        ]);
    }
}
