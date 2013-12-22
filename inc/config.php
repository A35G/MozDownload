<?php

/*
  Mozilla Software Download - PoC
  vers. 0.0.2a - Oct 2013

  Thanks to MozillaItalia Staff & Community
  http://www.mozillaitalia.org/
*/

  //  Version List
  define('vrs_list', json_encode(Array(
    'firefox' => 'http://svn.mozilla.org/libs/product-details/json/firefox_versions.json',
    'thunderbird' => 'http://svn.mozilla.org/libs/product-details/json/thunderbird_versions.json'/*,
    'seamonkey' => ''*/
    ))
  );

  //  List of software dimension
  define('dim_list', json_encode(Array(
    'firefox' => 'http://svn.mozilla.org/libs/product-details/json/firefox_primary_builds.json',
    'thunderbird' => 'http://svn.mozilla.org/libs/product-details/json/thunderbird_primary_builds.json'/*,
    'seamonkey' => ''*/
    ))
  );

  //  Download URL
  define('dwn_list', 'https://download.mozilla.org/?product=%1$s&os=%2$s&lang=%3$s');
  
  // Default Language
  define('lng_def', 'it');                                