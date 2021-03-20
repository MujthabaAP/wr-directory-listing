<?php

include './config/helper.php';

$obj = new helper();

if (!empty($_GET['id'])) {
    //remove the file from dir
    $fileDetail = $obj->selectFileInfo(trim($_GET['id']));
    if (!empty($fileDetail['data']['name'])) {
        //make sure DIRECTORY uploads has required permission
        $filePath = __DIR__ . '/uploads/' . $fileDetail['data']['name'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    //update db that the file is deleted
    $response = $obj->deleteFile(trim($_GET['id']));
    if (!empty($response['status']) && $response['status'] == 'success') {
        header('Location: index.php');
    }
} else {
    echo 'The file id is missing';
}