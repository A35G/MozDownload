<?php

  include('inc/config.php');
  include('inc/dwnld.class.php');

  $mid = new MIDownload;
  //echo $mid->getUrlProgm('firefox', 'dim_files');
  //echo @$mid->errorAppl();
  //echo ($mid->validUrl('firefox', 'dim_files')) ? 'Valid!' : 'Not Valid!';
  echo $mid->datailUsr();