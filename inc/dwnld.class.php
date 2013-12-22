<?php

  class MIDownload {

    var $version_info = vrs_list;
    var $dimn_info = dim_list;

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

    protected function infoUsr() {
    
      //  Predefined Language
      $lng_usr = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
      return $lng_usr;
    
    }

    protected function svnUrl($prgname, $type_url) {

      $url_svn = '';

      if (isset($prgname) && !empty($prgname)) {

        if (isset($type_url) && !empty($type_url)) {

          switch(htmlentities($type_url)) {
            case 'last_version':
              // With 'TRUE', returned objects will be converted into associative arrays.
              $arr_v = json_decode($this->version_info, true);
            break;
            case 'dim_files':
              // With 'TRUE', returned objects will be converted into associative arrays.
              $arr_v = json_decode($this->dimn_info, true);
            break;
          }

          if (is_array($arr_v) && !empty($arr_v)) {

            if (array_key_exists(htmlentities($prgname), $arr_v)) {

              $arr_data = $arr_v[htmlentities($prgname)];

              $url_svn = (!empty($arr_data)) ? $arr_data : $this->errorAppl('NTURL04');

            } else {

              $url_svn = $this->errorAppl('NTURL03');

            }

          } else {

            $url_svn = $this->errorAppl('NTURL02');

          }

        } else {

          $url_svn = $this->errorAppl('NTURL01');

        }

      } else {

        $url_svn = $this->errorAppl('NTAPP01');

      }

      return $url_svn;

    }

    protected function checkUrl($prgname, $type_url, $preld = '') {

      $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
      $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
      $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
      $regex .= "(\:[0-9]{2,5})?"; // Port
      $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
      $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
      $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor

      $url_svn = $this->svnUrl($prgname, $type_url);

      if (preg_match("/^$regex$/", $url_svn))
        $info_url = TRUE;
      else
        $info_url = FALSE;

      return $info_url;

    }

    public function errorAppl($code_err = '') {

      $trad_code = '';

      if (!empty($code_err)) {

        switch(htmlentities($code_err)) {
          case 'NTAPP01':
            $trad_code = "Non &egrave; stata specificata l'applicazione di cui si vuole ricevere informazioni.";
          break;
          case 'NTERR00':
            $trad_code = "Non &egrave; stato indicato il tipo di errore da visualizzare.";
          break;
          case 'NTURL01':
            $trad_code = "Non &egrave; stata indicata la tipologia di indirizzo da visualizzare.";
          break;
          case 'NTURL02':
            $trad_code = "Lista SVN non disponibile!";
          break;
          case 'NTURL03':
            $trad_code = "Il programma indicato, non &egrave; in lista!";
          break;
          case 'NTURL04':
            $trad_code = "URL SVN mancante, per il programma indicato!";
          break;
        }

      } else {

        $trad_code = self::errorAppl('NTERR00');

      }

      return $trad_code;

    }

    public function getVrs($prgname) {
      return $this->getInfoVrs($prgname);
    }

    public function validUrl($prgname, $type_svn) {
      return $this->checkUrl($prgname, $type_svn);
    }

    public function getUrlProgm($prgname, $type_svn) {
      return $this->svnUrl($prgname, $type_svn);
    }
    
    public function datailUsr() {
      return $this->infoUsr();
    }

  }