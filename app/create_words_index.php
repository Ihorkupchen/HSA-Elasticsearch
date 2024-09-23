<?php
//php /var/www/html/app/create_words_index.php
require __DIR__ . '/../vendor/autoload.php';

use App\ESClient;

$client = ESClient::build();

$params = [
    'index' => 'words',
    'body' => [
        'settings' => [
            'analysis' => [
                'filter' => [
                    'autocomplete_filter' => [
                        'type' => 'edge_ngram',
                        'min_gram' => 2,
                        'max_gram' => 20
                    ]
                ],
                'analyzer' => [
                    'autocomplete' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'autocomplete_filter']
                    ]
                ]
            ]
        ],
        'mappings' => [
            'properties' => [
                'word' => [
                    'type' => 'text',
                    'analyzer' => 'autocomplete',
                    'search_analyzer' => 'standard'
                ]
            ]
        ]
    ]
];

$client->indices()->create($params);

echo "Index created\n";