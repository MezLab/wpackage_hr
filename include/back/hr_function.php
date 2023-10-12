<?php 


function absolute(){
  $absolute = explode('wp-content/plugins', pathinfo(dirname(__DIR__))["dirname"]);
  return $absolute[0];
}

/**
 * Path del Plugin
 * Corrente
 */

function url_my_plugin(){
  return plugin_dir_url('wpackage_hr');
}

/**
 * Percorso assoluto
 * del sito web
 */

function url_my_path(){
  return site_url('/');
}

function isNull($a, string $w){
  if($a){
    echo "<p class='msg'>" . $w . " Correttamente</p>";
  }else{
    echo "<p class='msg'>Ops! Qualcosa è andato storto</p>";
  }
}


function date_comparison($date){
  if(strtotime($date) > strtotime("now")){
    return true;
  }else{
    return false;
  }
}


?>