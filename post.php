<?php
$loader = require 'vendor/autoload.php';
$loader->addPsr4('', __DIR__ . '/Classes/');
$loader->register();
require 'config.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

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

if ($_FILES != null) {
    $file = $_FILES;
}

$AWSEmail = new AWSEmailer($emailer, $SesClient);
$AWSFiles = new AWSFiles($s3Client, $bucket, $folderForUploadFiles);
$AWSMessage = new AWSMessages($sqsClient, $sqsQueueUrl);
if (isset($_POST['delete']) && isset($_POST['remfile'])) {
    $result = $s3Client->deleteObject([
        'Bucket' => $bucket,
        'Key' => $_POST['remfile'],
    ]);
    header('Location:' . '/');
}
if (isset($file)) {
    $data = $AWSFiles->readData($file);
    $sended = $AWSFiles->sendData($data);
    $sendedMessage = $AWSMessage->sendMessage($sended);
    $sendedEmail = $AWSEmail->sendEmail($data);
}


include 'index.phtml'; ?>