<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AiService
{
    public function analyzeTask(?string $description): array
    {
        // Guard clause (WAJIB)
        if (blank($description)) {
            return [
                'category' => null,
                'priority' => null,
            ];
        }

        $response = Http::withToken(config('services.groq.key'))
            ->post(config('services.groq.url') . '/chat/completions', [
                'model' => 'openai/gpt-oss-120b',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Kamu adalah sistem klasifikasi tugas sederhana.'
                    ],
                    [
                        'role' => 'user',
                        'content' => <<<PROMPT
Tentukan category dan priority dari teks berikut.
Jawab HANYA dalam format JSON berikut:

{
  "category": "IT|Administrasi|Keamanan",
  "priority": "Rendah|Sedang|Tinggi"
}

Teks:
{$description}
PROMPT
                    ],
                ],
                'temperature' => 0.1,
            ]);

        if (!$response->successful()) {
            return [
                'category' => null,
                'priority' => null,
            ];
        }

        $content = $response->json('choices.0.message.content');

        return json_decode($content, true) ?? [
            'category' => null,
            'priority' => null,
        ];
    }
}
