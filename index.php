<?php
header('Content-type: text/html; charset=utf-8');

/*
  MozDownload - Mozilla Software Download
  vers. 0.0.5rc - February 2014

  Get a button to download latest or nightly version of Firefox/Thunderbird

  Thanks to:
  - Mozilla (http://www.mozilla.org/);
  - MozillaItalia (http://www.mozillaitalia.org/)

  Copyright © 2013 - 2014 Gianluigi 'A35G'
  http://www.hackworld.it/ - http://www.gmcode.it/
*/

  include('inc/config.php');
  include('inc/dwnld.class.php');

  $mid = new MIDownload;
  $mid->dataProgram('firefox');
  
  $ts = array(
    "dwln_prgm" => $mid->getProg(),
    "url_dwln" => $mid->getDownload(),
    "name_prgm" => $mid->getNameAct(),
    "lang_prgm" => $mid->getNameLang(),
    "opsys_prgm" => $mid->getNameOS()
  );

  echo $mid->getButtDownload($ts, 'tpl/appl.html');