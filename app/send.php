<?php

require 'vendor/autoload.php';
use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$client = new SqsClient([
    'profile' => 'default',
    'region' => 'eu-central-1',
    'version' => '2012-11-05'
]);
$params = [
    'DelaySeconds' => 10,
    'MessageAttributes' => [
        "Title" => [
            'DataType' => "String",
            'StringValue' => "PDF do przetworzenia..."
        ],
        "Author" => [
            'DataType' => "String",
            'StringValue' => "Piotr Sobieszczański."
        ],
        "WeeksOn" => [
            'DataType' => "Number",
            'StringValue' => "6"
        ]
    ],
    'MessageBody' => "Information about current NY Times fiction bestseller for week of 12/11/2016.",
    'QueueUrl' => 'https://sqs.eu-central-1.amazonaws.com/829489761149/pdf-generate'
];
try {
    $result = $client->sendMessage($params);
    echo '<pre>' . var_export($result, true) . '</pre>';
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
}
