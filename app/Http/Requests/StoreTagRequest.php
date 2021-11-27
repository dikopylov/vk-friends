<?php

declare(strict_types=1);


namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreTagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
        ];
    }

    public function getTitle(): string
    {
        return $this->get('title');
    }
}