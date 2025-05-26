<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'boolean'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório',
            'name.max' => 'O nome do serviço não pode ter mais de 255 caracteres',
            'duration.required' => 'A duração do serviço é obrigatória',
            'duration.min' => 'A duração deve ser maior que zero',
            'price.required' => 'O preço do serviço é obrigatório',
            'price.min' => 'O preço deve ser maior ou igual a zero'
        ];
    }
} 