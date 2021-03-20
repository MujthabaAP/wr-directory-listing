<?php

include './config/helper.php';

$obj = new helper();

$output_dir = "uploads/";
if (isset($_FILES["myfile"])) {
    $ret = array();

    //This is for custom errors;	
    /* 	$custom_error= array();
      $custom_error['jquery-upload-file-error']="File already exists";
      echo json_encode($custom_error);
      die();
     */
    $error = $_FILES["myfile"]["error"];
    //You need to handle  both cases
    //If Any browser does not support serializing of multiple files using FormData() 
    if (!is_array($_FILES["myfile"]["name"])) { //single file
        $fileName = time() . '_' . $_FILES["myfile"]["name"];
        move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName);
        $ret[] = $fileName;
    } else {  //Multiple files, file[]
        $fileCount = count($_FILES["myfile"]["name"]);
        for ($i = 0; $i < $fileCount; $i++) {
            $fileName = time() . '_' . $_FILES["myfile"]["name"][$i];
            move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);
            $ret[] = $fileName;
        }
    }
    echo json_encode($ret);

    //insert into database
    $queryParam = '';
    foreach ($ret as $key => $file) {
        $queryParam .= " ('{$file}', false, now()) ";
        if (count($ret) > $key && count($ret) != 1) {
            $queryParam .= ",";
        }
    }
    $sql = "INSERT INTO `files`(`name`, `is_deleted`, `created_at`) VALUES $queryParam";
    echo $sql;
    $obj->mysqli->exec($sql);
}