<?php
/**
 * Copyright 2018 OpenCensus Authors
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once __DIR__ . '/../../../vendor/autoload.php';

use OpenCensus\Trace\Exporter\ZipkinExporter;
use OpenCensus\Trace\Tracer;

$host = getenv('ZIPKIN_HOST') ?: 'localhost';
$url = sprintf('http://%s:9411/api/v2/spans', $host);
$exporter = new ZipkinExporter('integration-test', $url);

Tracer::start($exporter, [
    'attributes' => [
        'foo' => 'bar'
    ]
]);

$ipv4 = Tracer::inSpan(
    ['name' => 'gethostbyname'],
    'gethostbyname',
    [$host]
);
$exporter->setLocalIpv4($ipv4);

echo 'Hello world!';
