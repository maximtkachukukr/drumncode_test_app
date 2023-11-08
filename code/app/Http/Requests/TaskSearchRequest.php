<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TaskSearchRequest extends FormRequest
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
            'status' => ['string', 'nullable', new Enum(TaskStatus::class)],
            'priority' => 'nullable|integer||between:1,5',
            'title' => 'nullable|string',
            'description' => 'nullable|string',
            'sorting' => 'array|nullable',
            'sorting.*.column' => Rule::in(['createdAt', 'completedAt', 'priority']),
            'sorting.*.direction' => Rule::in(['ASC', 'asc', 'DESC', 'desc']),
        ];
    }


    public function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ]));
    }
}
