<?php

class UploadController extends Controller
{
    private array $supportedFileTypes = ['gif', 'jpg', 'png', 'webp'];

    private function returnBytes($val): float|int
    {
        if (!$val) {
            $val = 0;
        }

        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = floatval($val);

        switch($last) {
            case 'g': $val *= (1024 * 1024 * 1024); break;
            case 'm': $val *= (1024 * 1024); break;
            case 'k': $val *= 1024; break;
        }

        return $val;
    }

    public function index(IKernel $kernel)
    {
        $response = $kernel->get('IResponse');
        $targetFileKey = 'imageToUpload';
        $targetFileExists = array_key_exists($targetFileKey, $_FILES);

        if (!$targetFileExists) {
            $response->jsond([
                'message' => 'Could not find a file to upload!'
            ], 400);
        }

        $targetFile = $_FILES[$targetFileKey];
        $targetFileSize = $targetFile['size'];
        $maxFileSize = $this->returnBytes(ini_get('upload_max_filesize'));

        if ($targetFileSize > $maxFileSize) {
            $response->jsond([
                'message' => 'The file you want to upload is too large!'
            ], 400);
        }

        $targetFileName = $targetFile['name'];
        $fileType = pathinfo($targetFileName, PATHINFO_EXTENSION);
        $isSupportedFileType = in_array(strtolower($fileType), $this->supportedFileTypes);

        if (!$isSupportedFileType) {
            $response->jsond([
                'message' => 'This file type is not supported!'
            ], 400);
        }

        $randomFilename = substr(md5(microtime()), 1, 12);
        $filePath = "static/$randomFilename.$fileType";
        $targetFileTmpName = $targetFile['tmp_name'];

        $moveWasSuccessful = move_uploaded_file($targetFileTmpName, $filePath);

        if (!$moveWasSuccessful) {
            $response->jsond([
                'message' => 'There was an error uploading this file!'
            ], 500);
        }

        $serverName = $_SERVER['SERVER_NAME'];
        $fileUrl = "https://$serverName/static/$randomFilename.$fileType";

        $response->json([
            'url' => $fileUrl
        ]);
    }

}