<?php
$credentials = [
    'key' => 'AKIAQ4Q5FUQ634MGH2NA',
    'secret' => 'EiM9+bbGaYbIymFyHTj+BOK5ANIRVQry7oEeOm32',
];

$region = 'eu-north-1';// Your Amazon region for bucket and SQS

$bucket = 'noxisestestbucket'; // Your Amazon S3 bucket name

$folderForUploadFiles =''; //'test/' //Leave blank if the download will be without a folder

$sqsQueueUrl = "https://sqs.eu-north-1.amazonaws.com/061264471101/test"; //Link to Amazon SQS message repository

$fileNameFromS3 = '372212262620341.json'; // The filename that will be taken from the $bucket for parsing information

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
]; //Information for emailSender


