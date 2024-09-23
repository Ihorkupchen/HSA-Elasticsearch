<?php

namespace App;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ESClient
{
    public static function build(): Client
    {
        return ClientBuilder::create()
            ->setHosts([getenv('ELASTICSEARCH_HOST')])
            ->setBasicAuthentication(getenv('ELASTICSEARCH_USERNAME'), getenv('ELASTICSEARCH_PASSWORD'))
            ->setSSLVerification(false)
            ->build();
    }
}