<?php

class Upload {
    private $fileName;
    private $fileSize;
    private $fileTmp;
    private $fileType;
    private $maxSize = 5000; // maximum image size in kb(kilo byte);
    public $errorMsg = array();

    function __construct() {
        for ($i = 0; $i <= count($_FILES['file']['tmp_name']); $i++) {
            $this->setImage($i);
            $this->validate();
            if ($this->errorMsg[$i]) {
                echo $this->errorMsg[$i];
                continue;
            }
            move_uploaded_file($_FILES['file']['tmp_name'][$i], "uploads/" . $_FILES['file']['name'][$i]);
        }
    }

    /**
     * set the input image name what was used in input field
     *
     * @param integer $key
     */
    function setImage($key) {
        $this->fileName = $_FILES['file']['name'][$key];
        $this->fileSize = $_FILES['file']['size'][$key];
        $this->fileTmp = $_FILES['file']['tmp_name'][$key];
        $this->fileType = $_FILES['file']['type'][$key];
    }

    public function validate() {
        $this->checkExt();
        $this->checkSize();
    }

    /**
     * Check the input image size with max image size
     *
     * @return boolean
     */
    function checkSize() {
        if ($this->fileSize > ($this->maxSize * 1024))
            $this->errorMsg[] = 'File size is Big';
        else
            return true;
    }

    /**
     * checks image extension
     *
     * @return boolean
     */
    function checkExt() {
        if (($this->fileType != 'image/jpg') && ($this->fileType != 'image/jpeg') &&
                ($this->fileType != 'image/gif') && ($this->fileType != 'image/png')) {
            echo $this->fileName;
            $this->errorMsg[] = 'File ext is not supported';
        } else {
            return true;
        }
    }

}

$upload = new Upload();
