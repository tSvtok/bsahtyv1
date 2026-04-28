<?php

namespace App\Http\Requests;

use App\Enums\SportCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'min:2', 'max:255', 'regex:/^[\pL\s\-\']+$/u'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'              => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'city'                  => ['nullable', 'string', 'max:100'],
            'bio'                   => ['nullable', 'string', 'max:500'],
            'location'              => ['nullable', 'string', 'max:255'],
            'sports'                => ['nullable', 'array', 'max:10'],
            'sports.*'              => ['string', new Enum(SportCategory::class)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'         => 'Your full name is required.',
            'name.min'              => 'Name must be at least 2 characters.',
            'name.regex'            => 'Name may only contain letters, spaces, hyphens and apostrophes.',
            'email.required'        => 'An email address is required.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'This email is already registered.',
            'password.required'     => 'A password is required.',
            'password.confirmed'    => 'Password confirmation does not match.',
            'password.min'          => 'Password must be at least 8 characters.',
            'sports.max'            => 'You may select up to 10 sports.',
            'sports.*.Illuminate\Validation\Rules\Enum' => 'One or more selected sports are invalid.',
        ];
    }
}
