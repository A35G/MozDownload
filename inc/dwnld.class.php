<?php

  class MIDownload {

    var $fx_info = '';

    protected function getInfoVrs($prgname) {

      // Get cURL resource
      $curl = curl_init();

      // Set some options - we are passing in a useragent too here
      curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => "http://svn.mozilla.org/libs/product-details/json/firefox_versions.json",
          //CURLOPT_USERAGENT => 'MozillaItalia Automatic Download Script - Beta version'
      ));

      // Send the request & save response to $resp
      $resp = curl_exec($curl);

      if(!$resp)
        die('Error: "' . curl_error($curl) . '" - Code: ' . curl_errno($curl));
      else
        return $resp;

      // Close request to clear up some resources
      curl_close($curl);

    }

    public function getVrs($prgname) {
      return $this->getInfoVrs($prgname);
    }

  }