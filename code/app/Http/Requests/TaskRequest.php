<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\TaskStatus;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rules\Enum;

class TaskRequest extends FormRequest
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
        $rules = [
            'title' => 'string|nullable',
            'status' => ['string', 'nullable', new Enum(TaskStatus::class)],
            'priority' => 'integer|between:1,5',
            'description' => 'string|nullable'
        ];

        // add required rules for new model request
        if ($this->isNewModel()) {
            foreach ($rules as $key => $rule) {
                $rules[$key] = is_string($rule)
                    ? 'required|' . $rules[$key]
                    : array_merge(['required'], $rule);
            }
        }

        return $rules;
    }

    /**
     * Is new model request
     *
     * @return bool
     */
    private function isNewModel(): bool
    {
        return $this->route('task') === null;
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 401));
    }
}
