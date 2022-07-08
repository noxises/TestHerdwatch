<?php


class Json
{
    private $acceptedObject = array();
    private $createdFiles = array();

     public function parseJsonFile($file)
    {
        $content ='';
        if (is_string($file)){
            $content = $file;
        }
        if (!$file['files']['name']) {
            return 'error';
        }else{
            $path = $file['files']['name'];
            move_uploaded_file($file['files']['tmp_name'], $path);
            $info = new SplFileInfo($path);
            if ($info->getExtension() != 'json') {
                return print_r('Please use .json files');
            }
            $content = file_get_contents($path);
        }

        $text = json_decode($content, true);
        foreach ($text as $one) {
            foreach ($one as $value) {
                if (substr($value['tag'], -1) == 1) {
                    array_push($this->acceptedObject, $value);

                }
            }
        }
        return $this->acceptedObject;

    }

     public function createJsonFiles()
    {
        foreach ($this->acceptedObject as $value) {
            $json = json_encode(array(array($value)));
            $fp = fopen('uploads/'.$value['tag'] . '.json', "w");
            fwrite($fp, $json);
            fclose($fp);
            array_push($this->createdFiles, $value['tag'] . '.json');
        }
        return $this->createdFiles;
    }

}