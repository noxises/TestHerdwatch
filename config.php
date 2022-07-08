<?php
$credentials = [
    'key' => '**',
    'secret' => '**',
];

$region = 'eu-north-1';

$bucket = 'noxisestestbucket';

$folderForUploadFiles =''; //'test/'

$sqsQueueUrl = "https://sqs.eu-north-1.amazonaws.com/061264471101/test";

$fileNameFromS3 = '372212262620341.json';

$emailer = [
    'sender' => 'simptom000@gmail.com',
    'senderName' => 'Sender Name',
    'recipient' => ['simptom000@gmail.com'],
    'configurationSet' => 'ConfigSet',
    'subject' => 'Amazon SES test (SMTP interface accessed using PHP)',
    'htmlBody' => '<h1>AWS Amazon Simple Email Service Test Email</h1>' .
        '<p>This email was sent with <a href="https://aws.amazon.com/ses/">' .
        'Amazon SES</a> using the <a href="https://aws.amazon.com/sdk-for-php/">' .
        'AWS SDK for PHP</a>.</p>'
];


