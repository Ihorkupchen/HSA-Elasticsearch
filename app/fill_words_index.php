<?php
//php /var/www/html/app/fill_words_index.php
require __DIR__ . '/../vendor/autoload.php';

use App\ESClient;

$client = ESClient::build();

$file = __DIR__ . '/../words.txt';
$handle = fopen($file, 'r');

if ($handle) {
    $bulkParams = ['body' => []];
    $counter = 0;

    while (($word = fgets($handle)) !== false) {
        $word = trim($word);

        $bulkParams['body'][] = [
            'index' => [
                '_index' => 'words',
            ]
        ];

        $bulkParams['body'][] = [
            'word' => $word
        ];

        $counter++;

        if ($counter % 1000 == 0) {
            $response = $client->bulk($bulkParams);
            echo "Indexed 1000 words\n";

            $bulkParams = ['body' => []];
        }
    }

    if (!empty($bulkParams['body'])) {
        $response = $client->bulk($bulkParams);
        echo "Indexed remaining words\n";
    }

    fclose($handle);
} else {
    echo "Failed to open file $file\n";
}
