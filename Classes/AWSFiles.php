<?php


class AWSFiles
{
    private $client;
    private $bucket;
    private $folderForUploadFiles;

    public function __construct($client, $bucket, $folderForUploadFiles)
    {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->folderForUploadFiles = $folderForUploadFiles;
    }

    public function getDataFromS3($fileName)
    {
        $result = $this->client->getObject(array(
            'Bucket' => $this->bucket,
            'Key' => $fileName
        ));
        return $result['Body'] . "\n";
    }

    public function readData($file)
    {
        $json = new Json();
        $json->parseJsonFile($file);
        return $json->createJsonFiles();
    }

    public function showFiles()
    {
        $result = array();
        try {
            $objects = $this->client->listObjects([
                'Bucket' => $this->bucket
            ]);

            if (isset($objects['Contents'])) {
                $result = $objects['Contents'];
            }
        } catch (S3Exception $e) {
            echo $e->getMessage() . PHP_EOL;
        }
        return $result;

    }

    public function sendData($data)
    {
        $sended = array();

        foreach ($data as $one) {
            try {
                $result = $this->client->putObject([
                    'Bucket' => $this->bucket,
                    'Key' => $this->folderForUploadFiles . $one,
                    'SourceFile' => 'uploads/' . $one,
                ]);
                array_push($sended, $result);
            } catch (S3Exception  $e) {
                $sended = null;
            }

        }
        return $sended;
    }

}