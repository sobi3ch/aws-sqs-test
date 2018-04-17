<?php

require 'vendor/autoload.php';
use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

$queueUrl = "https://sqs.eu-central-1.amazonaws.com/829489761149/pdf-generate";
$client = new SqsClient([
    'profile' => 'default',
    'region' => 'eu-central-1',
    'version' => '2012-11-05'
]);
try {
    $result = $client->receiveMessage(array(
        'AttributeNames' => ['SentTimestamp'],
        'MaxNumberOfMessages' => 1,
        'MessageAttributeNames' => ['All'],
        'QueueUrl' => $queueUrl, // REQUIRED
        'WaitTimeSeconds' => 0,
    ));
    if (count($result->get('Messages')) > 0) {
        echo '<pre>' .var_export($result->get('Messages')[0], true). '</pre>';

        $result = $client->deleteMessage([
            'QueueUrl' => $queueUrl, // REQUIRED
            'ReceiptHandle' => $result->get('Messages')[0]['ReceiptHandle'] // REQUIRED
        ]);
    } else {
        echo "No messages in queue. \n";
    }
} catch (AwsException $e) {
    // output error message if fails
    error_log($e->getMessage());
}
