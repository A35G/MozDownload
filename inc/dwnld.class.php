<?php

/*
  MIDownload - Script for downloading Mozilla programs
  vers. 0.0.1 - December 2013
  http://www.hackworld.it/ - http://www.gmcode.it/

  Dedicated to my Best Friend and Brother: Giuseppe,
  companion of many adventures and projects, adventures and ideas;
  backbone of every day...THANKS!

  Stay Tuned 
*/

  class MIDownload {

    var $version_info = vrs_list;
    var $dimn_info = dim_list;
    private $info = array();
    private $agent = "";
    private $buttond;
    private $data_svn = array();
    private $fix_text;

    function __construct() {

      //  User Agent
      $this->agent = isset($_SERVER['HTTP_USER_AGENT']) ?
      $_SERVER['HTTP_USER_AGENT'] : NULL;
      // Browser Lang
      $this->info['lang_user'] = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ?
      substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : NULL;
      // OS User
      $this->getOS();
      // Fix Text by Browser Lang
      $this->getLocale();

    }

    protected function getOS(){
      
      $os_list = array(
        "win"     =>    "/Windows/i",
        "linux"   =>    "/Linux/i",
        "osx"     =>    "/Mac/i"
      );

      foreach ($os_list as $key => $value){
      
        if (preg_match($value, $this->agent)) {
          $this->info = array_merge($this->info, array("oper_sys" => $key));
          break;
        }
      
      }

      return $this->info['oper_sys'];

    }

    protected function getLocale() {
      if (($this->info['lang_user'] != NULL) && @file_exists("locale/".$this->
      info['lang_user'].".php")) {
        @include("locale/".$this->info['lang_user'].".php");
        $this->fix_text = $xdc;
      }
      return $this->fix_text;    
    }

    protected function getInfoVrs($url_svn) {

      // Get cURL resource
      $curl = curl_init();

      // Set some options - we are passing in a useragent too here
      curl_setopt_array($curl, array(
          CURLOPT_RETURNTRANSFER => 1,
          CURLOPT_URL => $url_svn,
          CURLOPT_USERAGENT => 'GMCode.it - Automatic Download Script - Beta 
          version'
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
 
      $lng_usr = $this->info['lang_user'] . " - " . $this->info['oper_sys'];
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
              $url_svn = (!empty($arr_data)) ? $arr_data : $this->fix_text['NTURL04'];

            } else {
              $url_svn = $this->fix_text['NTURL03'];
            }

          } else {
            $url_svn = $this->fix_text['NTURL02'];
          }

        } else {
          $url_svn = $this->fix_text['NTURL01'];
        }

      } else {
        $url_svn = $this->fix_text['NTAPP01'];
      }

      return $url_svn;

    }

    protected function checkUrl($url_svn) {

      //  SCHEME
      $regex = "((https?|ftp)\:\/\/)?";
      //  User and Pass
      $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?";
      //  Host or IP
      $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})";
      //  Port
      $regex .= "(\:[0-9]{2,5})?";
      //  Path
      $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?";
      //  GET Query
      $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?";
      //  Anchor
      $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?";

      $info_url = (preg_match("/^$regex$/", $url_svn)) ? true : false;

      return $info_url;

    }

    private function genButton($ts, $tpl) {

      (@file_exists($tpl)) ? $this->buttond = @file_get_contents($tpl) : die("
      Si &egrave; verificato un errore!<br /><br />Il file &quot;" . $tpl . "
      &quot; non &egrave; presente");

      if (@count($ts) > 0) {

        foreach($ts as $t => $d)  {

          $d = (@file_exists($d)) ? $this->getFile($d) : $d;
          $this->buttond = @str_replace("{" . $t . "}", $d, $this->buttond);

        }

      } else {
        die("Attenzione: impossibile eseguire il replace dei tags.");
      }

    }

    private function getFile($doc) {
      @ob_start();
      include($doc);
      $contenuto = @ob_get_contents();
      @ob_end_clean();
      return $contenuto;
    }

    protected function infoProgram($prgm) {
      $svn_file = $this->svnUrl($prgm, 'last_version');
      if ($this->checkUrl($svn_file))
        //return $svn_file;
        return $this->getInfoVrs($svn_file);
      else
        die($this->fix_text['NTURL05']);
    }

    public function getVrs($prgname) {
      return $this->getInfoVrs($prgname);
    }

    public function getUrlProgm($prgname, $type_svn) {
      return $this->svnUrl($prgname, $type_svn);
    }
    
    public function datailUsr() {
      return $this->infoUsr();
    }

    public function dataProgram($prgm) {
      return $this->infoProgram($prgm);
    }

    public function getButtDownload($ts, $tpl) {
      $this->genButton($ts, $tpl);
      return $this->buttond;
    }

  }