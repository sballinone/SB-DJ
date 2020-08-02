<?php

if(!readdir("user_upload")) mkdir("user_upload");
$target_file = "user_upload/import_".date('YmdHis').".csv";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["importfile"]["name"],PATHINFO_EXTENSION));

if ($_FILES["importfile"]["size"] > 500000) {
  $status->setMsg($output["uploadFileToLarge"]);
  $uploadOk = 0;
}

if($imageFileType != "csv") {
  $status->setMsg($output["uploadWrongFiletype"]);
  $uploadOk = 0;
}

if ($uploadOk == 0) {
  $status->setMsg($output["uploadFailed"]);
} else {
  if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_file)) {
    $status->setMsg($output["uploadSuccess"]);
  } else {
    $status->setMsg($output["uploadFailed"]);
  }
}