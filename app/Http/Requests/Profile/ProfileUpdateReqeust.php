<?php

namespace App\Http\Requests\Profile;

use App\Models\Profile;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateReqeust extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        /** @var Profile $profile */
        $profile = $this->route('profile');

        return auth()->user()->is($profile->owner);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'company' => 'required|string|min:2|max:250',
            'nationality' => ['required', 'string', 'min:2', 'max:250'],
        ];
    }
}
