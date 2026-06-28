<?php

namespace App\Http\Requests\HealthSnapshot;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreHealthSnapshotRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sleep_hours'   => ['required', 'numeric', 'min:0', 'max:24'],
            'glucose_level' => ['required', 'integer', 'min:1'],
            'heart_rate'    => ['required', 'integer', 'min:1'],
            'water_intake'  => ['required', 'integer', 'min:0'],
            'measured_at'   => ['required', 'date'],
        ];
    }
}
