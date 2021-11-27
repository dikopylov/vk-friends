<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachTagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required|number',
        ];
    }

    public function getId(): string
    {
        return $this->get('id');
    }
}
