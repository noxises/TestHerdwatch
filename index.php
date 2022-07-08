<?php
$loader = require 'vendor/autoload.php';
$loader->addPsr4('', __DIR__ . '/Classes/');
$loader->register();
require 'config.php';

use Aws\S3\S3Client;
use Aws\Ses\SesClient;
use Aws\Sqs\SqsClient;

$s3Client = new S3Client([
    'version' => 'latest',
    'region' => $region,
    'credentials' => $credentials,
]);
$SesClient = new SesClient([
    'version' => 'latest',
    'region' => $region,
    'credentials' => $credentials,
]);

$sqsClient = new SqsClient([
    'version' => 'latest',
    'region' => $region,
    'credentials' => $credentials,
]);

$AWSMessage = new AWSMessages($sqsClient, $sqsQueueUrl);
$AWSFiles = new AWSFiles($s3Client, $bucket, $folderForUploadFiles);
$AWSEmail = new AWSEmailer($emailer, $SesClient);

//Uncomment it if you want read data from file in S3 bucket
//$file = $AWSFiles->getDataFromS3($fileNameFromS3);


$message = $AWSMessage->receiveMessage();//Show message and delete it from sqs
if (isset($file)) {
    $data = $AWSFiles->readData($file); //Read data and create files for upload
    $sended = $AWSFiles->sendData($data);// Upload result files
    $sendedMessage = $AWSMessage->sendMessage($sended); // Upload message with url to result in S3
    $sendedEmail = $AWSEmail->sendEmail($data);// Send email with result
}
$listFiles = $AWSFiles->showFiles();

include 'index.phtml'; ?>
