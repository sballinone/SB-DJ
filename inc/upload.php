<?php

if (!readdir("user_upload")) {
	mkdir("user_upload");
}

$target_file = "user_upload/import_".date('YmdHis').".csv";
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($_FILES["importfile"]["name"], PATHINFO_EXTENSION));

if ($_FILES["importfile"]["size"] > 500000) {
	$status->setMsg(_("Sorry, your file is too large."));
	$uploadOk = 0;
}

if ($imageFileType != "csv") {
	$status->setMsg(_("Sorry, only djay styled CSV files are allowed."));
	$uploadOk = 0;
}

if ($uploadOk == 0) {
	$status->setMsg(_("Sorry, there was an error uploading your file."));
} else {
	if (move_uploaded_file($_FILES["importfile"]["tmp_name"], $target_file)) {
		$status->setMsg(sprintf(_("The file %s has been uploaded."),basename( $_FILES["importfile"]["name"])));
	} else {
		$status->setMsg(_("Sorry, there was an error uploading your file."));
	}
}