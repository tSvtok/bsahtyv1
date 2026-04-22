<?php

namespace App\Http\Requests;

use App\Enums\SportCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Consider checking if $this->user()->id == $this->question->user_id
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'content' => ['sometimes', 'string'],
            'sport_category' => ['sometimes', new Enum(SportCategory::class)],
            'spot_id' => ['nullable', 'exists:spots,id'],
            'event_id' => ['nullable', 'exists:events,id'],
        ];
    }
}
