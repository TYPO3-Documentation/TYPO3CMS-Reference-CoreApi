#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Crowdin Mass Approval Script
 *
 * Approves all unapproved translations in a Crowdin project.
 * Requires PHP 8.4+
 */
const API_BASE = 'https://api.crowdin.com/api/v2';
const ENDPOINTS = [
    'project'      => '/projects/%d',
    'files'        => '/projects/%d/files?limit=500',
    'strings'      => '/projects/%d/strings?fileId=%d&limit=500',
    'translations' => '/projects/%d/translations?stringId=%d&languageId=%s&limit=500',
    'approvals'    => '/projects/%d/approvals',
];

class CrowdinClient
{
    public function __construct(
        private string $token,
        private int $projectId,
    ) {}

    private function request(
        string $endpoint,
        string $method = 'GET',
        ?array $data = null,
    ): array {
        $ch = curl_init(API_BASE . $endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer {$this->token}",
                'Content-Type: application/json',
            ],
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POSTFIELDS => $data ? json_encode($data) : null,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false || $httpCode >= 400) {
            if ($httpCode >= 400) {
                fprintf(STDERR, "ERROR: HTTP %d\n%s\n", $httpCode, $response);
            }
            return [];
        }

        return json_decode($response, true) ?? [];
    }

    private function endpoint(string $key, mixed ...$args): string
    {
        return sprintf(ENDPOINTS[$key], $this->projectId, ...$args);
    }

    public function getLanguages(): array
    {
        $project = $this->request($this->endpoint('project'));
        return array_column($project['data']['targetLanguages'] ?? [], 'id');
    }

    public function getFiles(): array
    {
        $response = $this->request($this->endpoint('files'));
        return array_column(
            array_column($response['data'] ?? [], 'data'),
            'id',
        );
    }

    public function getStrings(int $fileId): array
    {
        $response = $this->request($this->endpoint('strings', $fileId));
        return array_column(
            array_column($response['data'] ?? [], 'data'),
            'id',
        );
    }

    public function getTranslations(int $stringId, string $lang): array
    {
        $response = $this->request($this->endpoint('translations', $stringId, $lang));
        return array_map(
            fn($item) => [
                'id' => $item['data']['id'],
                'approved' => !empty($item['data']['approvals']),
            ],
            $response['data'] ?? [],
        );
    }

    public function approve(int $translationId): bool
    {
        $response = $this->request(
            $this->endpoint('approvals'),
            'POST',
            ['translationId' => $translationId],
        );
        return !empty($response);
    }
}

// --- Main ---

$token = getenv('CROWDIN_TOKEN')
    ?: exit("ERROR: CROWDIN_TOKEN environment variable not set\n");

$projectId = (int)($argv[1]
    ?? exit("Usage: php crowdin_mass_approve.php <project-id> [language-id]\n"));

$filterLang = $argv[2] ?? null;

$client = new CrowdinClient($token, $projectId);

echo "\n=== Crowdin Mass Approval ===\n";
echo "Project ID: {$projectId}\n";
if ($filterLang) {
    echo "Language filter: {$filterLang}\n";
}

// Step 1: Get languages
echo "\nStep 1: Getting languages...\n";
$languages = $filterLang ? [$filterLang] : $client->getLanguages();
if (empty($languages)) {
    exit("ERROR: No languages found\n");
}
printf("Found %d language(s): %s\n", count($languages), implode(', ', $languages));

// Step 2: Get files
echo "\nStep 2: Getting files...\n";
$files = $client->getFiles();
if (empty($files)) {
    exit("ERROR: No files found\n");
}
printf("Found %d file(s)\n", count($files));

// Step 3: Process translations
echo "\nStep 3: Processing translations...\n";
echo "Legend: F=file, S=string, L=translation\n\n";

$stats = ['approved' => 0, 'skipped' => 0, 'errors' => 0];
$errors = [];

foreach ($files as $fileId) {
    echo 'F';
    foreach ($client->getStrings($fileId) as $stringId) {
        echo 'S';
        foreach ($languages as $lang) {
            foreach ($client->getTranslations($stringId, $lang) as $translation) {
                echo 'L';
                if ($translation['approved']) {
                    $stats['skipped']++;
                    continue;
                }

                if ($client->approve($translation['id'])) {
                    $stats['approved']++;
                } else {
                    $stats['errors']++;
                    $errors[] = [
                        'file' => $fileId,
                        'string' => $stringId,
                        'lang' => $lang,
                        'translation' => $translation['id'],
                    ];
                }
            }
        }
    }
}

// Summary
printf(
    "\n\n=== Summary ===\nApproved: %d | Skipped: %d | Errors: %d\n",
    $stats['approved'],
    $stats['skipped'],
    $stats['errors'],
);

if ($errors) {
    echo "\n=== Failed Approvals ===\n";
    foreach ($errors as $e) {
        printf(
            "  File: %d, String: %d, Lang: %s, Translation: %d\n",
            $e['file'],
            $e['string'],
            $e['lang'],
            $e['translation'],
        );
    }
}
