<?php

namespace App\Http\Requests\Github;

use Illuminate\Foundation\Http\FormRequest;

class SaveTokenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'github_token' => 'required|string|min:7|max:50'
        ];
    }
}
