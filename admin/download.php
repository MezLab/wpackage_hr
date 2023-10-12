<?php
  $archive_file_name = $_GET['name'];
  header("Content-type: application/zip");  
  header("Content-Disposition: attachment; filename=$archive_file_name");
  header("Pragma: no-cache"); 
  header("Expires: 0"); 

  readfile($_GET['filename']); // Scarica Automaticamente
  unlink($_GET['filename']); // Cancella lo zip creato
  exit;
?>