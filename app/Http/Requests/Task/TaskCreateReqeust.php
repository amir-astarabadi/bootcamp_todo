<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class TaskCreateReqeust extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->boards()->whereId($this->get('board_id'))->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'due_date' => ['required', 'date', 'after_or_equal:' . now()->toDateString()],
            'board_id' => ['required', 'exists:boards,id'],
            'image' => [
                'nullable',
                File::image()
                    ->min('1kb')
                    ->max('10mb'),
            ],
        ];
    }
}
