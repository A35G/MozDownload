<?php

/**
 *  MI Download Area - PoC
 *  vers. 0.0.1a - Oct 2013
 *  http://www.mozillaitalia.org/
 **/
 
  //  Database variables and parameters
  define ( "host", "localhost" );
  define ( "user", "root" );
  define ( "password", "" );
  define ( "databs", "mozillaitalia" );
  
/**
 *  URL SVN
 **/
 
  //  Firefox
  define("vrs_list", json_encode(Array(
    'firefox' => 'http://svn.mozilla.org/libs/product-details/json/firefox_versions.json',
    'thunderbird' => 'http://svn.mozilla.org/libs/product-details/json/thunderbird_versions.json'
    ))
  );

  define("dim_list", json_encode(Array(
    'firefox' => 'http://svn.mozilla.org/libs/product-details/json/firefox_primary_builds.json',
    'thunderbird' => 'http://svn.mozilla.org/libs/product-details/json/thunderbird_primary_builds.json'
    ))
  );