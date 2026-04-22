<?php

namespace App\Http\Requests;

use App\Enums\ReactionType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreReactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', new Enum(ReactionType::class)],
            'reactable_id' => ['required', 'integer'],
            'reactable_type' => ['required', 'string', 'in:App\Models\Question,App\Models\Comment'],
        ];
    }
}
