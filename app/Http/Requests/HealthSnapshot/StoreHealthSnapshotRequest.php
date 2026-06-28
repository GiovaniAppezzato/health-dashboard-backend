<?php

namespace App\Http\Requests\HealthSnapshot;

use App\Rules\UniqueHealthSnapshotMeasuredAt;
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
            'water_intake'  => ['required', 'numeric', 'min:0'],
            'measured_at'   => ['required', 'date', 'before_or_equal:today', new UniqueHealthSnapshotMeasuredAt()],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'numeric' => 'O campo :attribute deve ser um número.',
            'integer' => 'O campo :attribute deve ser um número inteiro.',
            'date' => 'O campo :attribute deve ser uma data válida.',
            'min.numeric' => 'O campo :attribute deve ser no mínimo :min.',
            'max.numeric' => 'O campo :attribute deve ser no máximo :max.',
            'before_or_equal' => 'O campo :attribute não pode ser uma data futura.',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'sleep_hours' => 'horas de sono',
            'glucose_level' => 'nível de glicose',
            'heart_rate' => 'frequência cardíaca',
            'water_intake' => 'consumo de água',
            'measured_at' => 'data',
        ];
    }
}
