<?php

namespace App\Presentation\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InstrumentUsageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'instrument' => ['required', 'string', 'max:255'],
        ];
    }
}
