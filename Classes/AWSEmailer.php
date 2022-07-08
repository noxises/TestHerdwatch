<?php

class AWSEmailer
{

    private $sender;
    private $senderName;
    private $recipient;
    private $configurationSet;
    private $subject;
    private $client;
    private $htmlBody;
    private $message = '';

    public function __construct($emailer, $client)
    {
        $this->client = $client;
        $this->sender = $emailer['sender'];
        $this->senderName = $emailer['senderName'];
        $this->recipient = $emailer['recipient'];
        $this->configurationSet = $emailer['configurationSet'];
        $this->subject = $emailer['subject'];
        $this->htmlBody = $emailer['htmlBody'];
    }

    public function sendEmail($files)
    {
        $senders = implode(",", $this->recipient);
        $separator = md5(time());
        $separator_multipart = md5($this->subject . time());
        $this->message .= "MIME-Version: 1.0\n";
        $this->message .= "To: " . $senders . "\n";
        $this->message .= "From:" . $this->sender . "\n";
        $this->message .= "Subject:" . $this->subject . "\n";
        $this->message .= "Content-Type: multipart/mixed; boundary=\"" . $separator_multipart . "\"\n";
        $this->message .= "\n--" . $separator_multipart . "\n";
        $this->message .= "Content-Type: multipart/alternative; boundary=\"" . $separator . "\"\n";
        $this->message .= "\n--" . $separator . "\n";
        $this->message .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $this->message .= "\n" . $this->htmlBody . "\n";
        $this->message .= "\n--" . $separator . "--\n";


        foreach ($files as $file) {
            $file = 'uploads/' . $file;
            $this->message .= "--" . $separator_multipart . "\n";
            $fileName = basename($file);
            $dataAttachedFile = file_get_contents($file);
            $dataAttachedFile = chunk_split(base64_encode($dataAttachedFile));
            $fileMimeInfo = finfo_open(FILEINFO_MIME_TYPE);
            $fileMimeType = finfo_file($fileMimeInfo, $file);
            $this->message .= "Content-Type: " . $fileMimeType . "; name=\"" . $fileName . "\"\n";
            $this->message .= "Content-Disposition: attachment; filename=\"" . $fileName . "\"\n";
            $this->message .= "Content-Transfer-Encoding: base64\n\n";
            $this->message .= $dataAttachedFile;
            $this->message .= "\n--" . $separator_multipart . "\n";
        }

        try {
            $result = $this->client->sendRawEmail([
                'Destination' => [
                    'ToAddresses' => $this->recipient,
                ],
                'Source' => $this->sender,
                'RawMessage' => [
                    'Data' => $this->message
                ]
            ]);
            return 'Email send to : ' . $this->sender;
        } catch (AwsException $e) {
            // output error message if fails
            echo $e->getMessage();
            echo "\n";
        }

    }
}