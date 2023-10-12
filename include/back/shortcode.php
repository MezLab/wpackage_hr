<?php 

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Creazione Shortcode
 * Version:           1.1
 * Requireds PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

/**
 * Shortcode collegato al DB
 * che cerca il contenuto del Modulo
 * per la visualizzazione
 * nella pagina
 */

function WPackage_HR_Module($atts){

  global $wpdb;

  $path = url_my_path();
  $ID = $atts['id'];

  $response = "<div id='response'></div>";

  $myAtts = shortcode_atts( array(
    'id' => 0,
    'title' => '',
	), $atts );

  // Query al DB per il contenuto del modulo
  // Query al DB per il contenuto del modulo
  $query = $wpdb->get_results("select code, name, content, deadline from wpackage_hr_module where ID=$ID ;", ARRAY_A);
  
  $newName = $query[0]["code"];

  
  $shortCode = "<form action='javascript:void(0);' method='POST' class='WPackage_HR_Module infomobilityModule' onsubmit='sendForm(" . $ID . ",\"" . $path . "hr-send\", \"". $newName . "\")'>";
  // $shortCode = "<form action='javascript:void(0);' method='POST' class='WPackage_HR_Module' onsubmit='sendForm(" . $ID . ",\"" . $path . "wp-admin/admin.php?page=admin_mailSend\", \"". $newName . "\")'>";
  // $shortCode = "<form enctype='multipart/form-data' action='https://www.infomobility.pr.it/ebike/' method='POST' class='WPackage_HR_Module'>";


  // isset($query) || is_null($query)
  if(empty($query) || $query[0]['name'] != $atts['title']){
    return "<p> Il Modulo scelto <b>non esiste</b>.</p>";
  }

  if(date_comparison($query[0]["deadline"])){

    $arrayJson = explode('&', $query[0]['content']);
    
    // echo var_dump($arrayJson);

    if(count($query) > 0){

      for ($i=1; $i < count($arrayJson); $i++) {

        $json = json_decode($arrayJson[$i], true);

        switch ($json['type']) {

          case 'text':
          case 'email':
          case 'date':
          case 'tel':
          case 'submit':

          $shortCode .= "<div class='elem'>" ;
            if($json['placeholder']){
              if($json['required']){
                $shortCode .= "<input type='" . $json['type'] . "' 
                  name='" . $json['name'] . "' 
                  value='" . $json['value'] . "'
                  placeholder='" . $content . "'
                  required=''>";
              }else{
              $shortCode .= "<input type='" . $json['type'] . "' 
                  name='" . $json['name'] . "' 
                  value='" . $json['value'] . "'
                  placeholder='" . $content . "'>";
              }
            }else{
              if($json['required']){
                $shortCode .= "<p>" . $json['title'] . "</p><input 
                  type='" . $json['type'] . "' 
                  name='" . $json['name'] . "' 
                  value='" . $json['value'] . "'
                  required=''>";
              }else{
              $shortCode .= "<p>" . $json['title'] . "</p><input 
                type='" . $json['type'] . "' 
                name='" . $json['name'] . "' 
                value='" . $json['value'] . "'>";
              }
            }
          $shortCode .= "</div>";

            break;
          case 'select':

          $shortCode .= "<div class='elem'>" ;
              $opt = "";

              for ($v = 0; $v < count($json['list']); $v++) { 
                $opt .= "<option value='" . $json['list'][$v] . "'>" . $json['list'][$v] . "</option>"; 
              }

              if($json['required']){
                $shortCode .= "<p>" . $json['title'] . "</p><select name='" . $json['name'] . "' required=''>" . $opt . "</select>";
              }else{
                $shortCode .= "<p>" . $json['title'] . "</p><select name='" . $json['name'] . "'>" . $opt . "</select>";
              }
          $shortCode .= "</div>";

            break;
          case 'checkbox':
          case 'radio':

          $shortCode .= "<div class='elem'>" ;
              $opt = "";

              if($json['type'] == 'radio'){
                if($json['required']){
                  for ($s = 0; $s < count($json['list']); $s++) { 
                    $opt = $opt . "<span><input type='" . $json['type'] . "' name='" . strtolower($json['name']) . "' value='" . $json['list'][$s] . "' required=''><label>" . $json['list'][$s] . "</label></span>"; 
                  } 
                }else{
                  for ($s = 0; $s < count($json['list']); $s++) { 
                    $opt = $opt . "<span><input type='" . $json['type'] . "' name='" . strtolower($json['name']) . "' value='" . $json['list'][$s] . "'><label>" . $json['list'][$s] . "</label></span>"; 
                  }
                }
              }else{
                if($json['required']){
                  for ($s = 0; $s < count($json['list']); $s++) { 
                    $opt = $opt . "<span><input type='" . $json['type'] . "' name='" . strtolower($json['name']) . "' value='" . $json['list'][$s] . "' required=''><label>" . $json['list'][$s] . "</label></span>"; 
                  } 
                }else{
                  for ($s = 0; $s < count($json['list']); $s++) { 
                    $opt = $opt . "<span><input type='" . $json['type'] . "' name='" . strtolower($json['name']) . "' value='" . $json['list'][$s] . "'><label>" . $json['list'][$s] . "</label></span>"; 
                  }
                }
              }
              $shortCode .= "<p>" . $json['title'] . "</p><div class='" . $json['type'] . "'>" . $opt  . "</div>";
            $shortCode .= "</div>";

            break;
          case 'file':

          $shortCode .= "<div class='elem'>" ;
            $opt = "";

            for ($a = 0; $a < count($json['list']); $a++) {
                if($a != count($json['list'])-1){
                  $opt .= $json['list'][$a] . ",";
                }else{
                  $opt .= $json['list'][$a];
                }
            }

            if($json['required']){
              $shortCode .= "<p>" . $json['title'] . "</p><input type='" . $json['type'] . "' name='" . $json['name'] . "' value='' accept='" . $opt . "' required=''>";
            }else{
              $shortCode .= "<p>" . $json['title'] . "</p><input type='" . $json['type'] . "' name='" . $json['name'] . "' value='' accept='" . $opt . "'>";
            }
          $shortCode .= "</div>";

            break;
          default:
            break;
        }
        
      }

      $shortCode .= "</form>" . $response . "<script src=" . plugins_url('wpackage_hr/library/js/my_send.js') . "></script>";
      return $shortCode;

    }else{
      return "<p> Nessun modulo corrisponde a <b>[WPackage_HR id=" . $myAtts['id'] . " title='" . $myAtts['title'] . "']</b></p>";
    }

  }else{
      return "<p> Il Modulo per la compilazione <b>è terminato</b>.</p>";
  }

}

add_shortcode('WPackage_HR', 'WPackage_HR_Module');