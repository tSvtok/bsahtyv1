<?php

namespace App\Http\Requests;

use App\Enums\EventStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'sport' => ['required', 'string', 'max:100'],
            'location' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date_format:Y-m-d', 'after_or_equal:today'],
            'time' => ['required', 'date_format:H:i'],
            'max_participants' => ['required', 'integer', 'min:2'],
            'image' => ['nullable', 'string'],
            'status' => ['nullable', new Enum(EventStatus::class)],
            'question_id' => ['nullable', 'exists:questions,id'],
        ];
    }
}
