<?php

require_once "_api.php";

use App\Provider\S3Repository;
use App\Core\Controller;

Controller::serve(function(request) {
  $s3 = S3Repository::instance();

  $only_file_name = $request->get('onlyFilename');

  $media_path = $request->get('mediaPath');

  $file = $request->get('file');

  if (!$file) $request->send('File not found');

  $folder_path = implode('/', $media_path ? [$media_path] : []);

  $upload = $s3->upload_file($folder_path, $file);

  return $request->send($only_file_name ? $upload["name"]: $upload["path"]);
})