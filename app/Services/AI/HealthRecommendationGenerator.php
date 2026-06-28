<?php

namespace App\Services\AI;

use App\Models\HealthSnapshot;
use OpenAI\Laravel\Facades\OpenAI;
use RuntimeException;

class HealthRecommendationGenerator
{
    public function handle(HealthSnapshot $healthSnapshot): array
    {
        $response = OpenAI::responses()->create([
            'model' => config('openai.model'),
            'temperature' => 0.4,
            'text' => [
                'format' => [
                    'type' => 'json_schema',
                    'name' => 'health_recommendations',
                    'strict' => true,
                    'schema' => [
                        'type' => 'object',
                        'additionalProperties' => false,
                        'required' => ['recommendations'],
                        'properties' => [
                            'recommendations' => [
                                'type' => 'array',
                                'minItems' => 3,
                                'maxItems' => 3,
                                'items' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ]
            ],
            'instructions' => $this->instructions(),
            'input'        => $this->prompt($healthSnapshot),
        ]);

        return $this->parseRecommendations($response->outputText);
    }

    private function instructions(): string
    {
        return <<<PROMPT
        Você é um assistente especializado em hábitos saudáveis.

        Analise os biomarcadores fornecidos e gere recomendações práticas, objetivas e fáceis de aplicar no dia a dia.

        As recomendações devem:
        - Ser escritas em português do Brasil.
        - Considerar apenas os biomarcadores informados.
        - Ser específicas para os valores recebidos.
        - Conter apenas hábitos saudáveis.
        - Não fazer diagnóstico médico.
        - Não assumir doenças ou condições clínicas.
        - Não recomendar medicamentos ou tratamentos.
        - Evitar repetir recomendações com o mesmo objetivo.
        PROMPT;
    }

    private function prompt(HealthSnapshot $healthSnapshot): string
    {
        return <<<PROMPT
        Analise os biomarcadores abaixo e gere exatamente 3 recomendações personalizadas de hábitos diários.

        Biomarcadores:
        - Horas de sono: {$healthSnapshot->sleep_hours} horas
        - Nível de glicose: {$healthSnapshot->glucose_level} mg/dL
        - Frequência cardíaca: {$healthSnapshot->heart_rate} BPM
        - Consumo de água: {$healthSnapshot->water_intake} litro(s)

        Considere o conjunto dos biomarcadores para gerar as recomendações, evitando analisar apenas um valor isoladamente.
        PROMPT;
    }

    private function parseRecommendations(?string $output): array
    {
        if (! $output) {
            throw new RuntimeException('The AI returned an empty response.');
        }

        $data = json_decode($output, associative: true);

        return array_map(
            fn (mixed $item): string => trim((string) $item),
            $data['recommendations'] ?? []
        );
    }
}
