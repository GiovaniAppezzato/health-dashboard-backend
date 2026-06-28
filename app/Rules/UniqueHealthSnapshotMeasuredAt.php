<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use App\Services\HealthSnapshot\HealthSnapshotService;

class UniqueHealthSnapshotMeasuredAt implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $healthSnapshot = app(HealthSnapshotService::class)->findByMeasuredAt($value);

        if ($healthSnapshot) {
            $fail('Já existe um registro para a data informada, caso deseje editar o registro, utilize a rotina de edição.');
        }
    }
}
