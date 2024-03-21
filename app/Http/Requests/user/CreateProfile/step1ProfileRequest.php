<?php

namespace App\Http\Requests\user\CreateProfile;

use Illuminate\Foundation\Http\FormRequest;

class step1ProfileRequest extends FormRequest
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
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'location' => 'sometimes|string|max:255',
            'phoneNum' => 'sometimes|string|max:255',
            'about' => 'sometimes|string|max:255',
            'email' => 'sometimes|email',
        ];
    }
}
