<?php
header('Content-type: text/html; charset=utf-8');

  include('inc/config.php');
  include('inc/dwnld.class.php');

  $mid = new MIDownload;
  $mid->dataProgram('firefox');
  
  $ts = array(
    "dwln_prgm" => "firefox",
    "url_dwln" => $mid->getDownload('firefox'),
    "name_prgm" => $mid->getNameAct('firefox'),
    "lang_prgm" => $mid->getNameLang(),
    "opsys_prgm" => $mid->getNameOS()
  );

  echo $mid->getButtDownload($ts, 'tpl/appl.html');