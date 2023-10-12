<?php

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Module
 * Version:           1.2
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


class HR_Module
{

    /* ----------------- */
  /** PROPERTY */
  /* ----------------- */

  /** Nome del Modulo in risposta */
  public $reply_name;

  /** Oggetto della mail del Modulo in risposta */
  public $reply_object;

  /** Messaggio dellla mail del modulo in risposta */
  public $reply_msg;


  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  //--------------------------------------------


  /**
   * Nome del Modulo in risposta
   */
  public function getReply_name(){
    return $this->reply_name;
  }

  /**
   * Oggetto della mail del Modulo in risposta
   */
  public function getReply_object(){
    return $this->reply_object;
  }

  /**
   * Messaggio dellla mail del modulo in risposta
   */
  public function getReply_msg(){
    return $this->reply_msg;
  }
  

  //--------------------------------------------

  /**
   * Settaggio Modulo
   * nel DATABASE 
   */
  public function settingModule(int $id){
    global $wpdb;

    $query = $wpdb->get_results("select * from wpackage_hr_module where ID=$id ;", ARRAY_A);
    return $query;

  }

  
  //--------------------------------------------

  /**
   * Restituisce l'oggetto
   * del MODULO
   */
  public function ObjectMOD(int $id){
    global $wpdb;

    $query = $wpdb->get_results("select content from wpackage_hr_module where ID=$id ;", ARRAY_A);

    if(!is_null($query)){
      return $query[0]['content'];
    }else{
      return;
    }
  }


  //--------------------------------------------

  /**
   * Duplica Modulo
   * nel DATABASE 
   */
  public function duplicate(int $id){
    global $wpdb;

    $alphaNumeric = array(
      array("A", "B", "C", "D", "E", "F", "G", "H", "I", "L"),
      array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9")
    );
    $code_ = "";

    for ($i = 0; $i < 5 ; $i++) { 
      $code_ .= $alphaNumeric[rand(0,1)][rand(0,9)];
    }

    $query = $wpdb->get_results("select * from wpackage_hr_module where ID=$id ;", ARRAY_A);

    $query_1 = $wpdb->insert( 'wpackage_hr_module', array(
      "code" => $code_,
      "name" => '_copy_module_'. $query[0]['ID'],
      "content" => stripslashes($query[0]['content']),
      "reply_object" => $query[0]['reply_object'],
      "reply_content" => $query[0]['reply_content'],
      "deadline" => $query[0]['deadline'],
      "published" => date("Y-m-d")
    ) );

    if(!is_null($query_1)){
      return true;
    }else{
      return false;
    }
  }


  //--------------------------------------------

  /**
   * Modifica Modulo
   * nel DATABASE 
   */
  public function update(int $id, array $array){
    global $wpdb;

    $query = $wpdb->update( 'wpackage_hr_module', array(
      "code" => $array['code'],
      "name" => $array['nameModule'],
      "content" => stripslashes($array['content']),
      "deadline" => $array['deadline']
   ), array( 'ID' => $id ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
  }
      


  //--------------------------------------------

  /**
   * Elimina Modulo
   * nel DATABASE 
   */
  public function delete(int $id){
    global $wpdb;

    $query = $wpdb->delete( 'wpackage_hr_module', array( 'ID' => $id ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }

  }


  //--------------------------------------------

  /**
   * Aggiungi Modulo
   * nel DATABASE 
   */
  public function add(array $array){
    global $wpdb;

    $query1 = $wpdb->get_results("select * from wpackage_hr_module", ARRAY_A);
    $size = count($query1) + 1;


    $query = $wpdb->insert( 'wpackage_hr_module', array(
      "code" => $array['code'],
      "name" => $array['nameModule'],
      "content" => stripslashes($array['content']),
      "deadline" => $array['deadline'],
      "published" => date("Y-m-d")
    ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
  }


  //--------------------------------------------

  /**
   * Cerca Modulo
   * nel DATABASE 
   */
  public function search($string){
    global $wpdb;
    $forms = "";
        
    $query = $wpdb->get_results("select * from wpackage_hr_module where name like '%" . $string . "%'", ARRAY_A);

    if(!is_null($query)){
      if(count($query) == 0){
        echo '<p>Nessun Modulo Trovato</p>';
      }else{
        for($a = 0; $a < count($query); $a++){

          (date_comparison($query[$a]["deadline"])) ? $backGround_color = "background-color:#64e764" : $backGround_color = "background-color:#da565c" ;

          $forms .= '<tr>
                      <td>
                        <input class="id_select" type="checkbox" name="' . $query[$a]["ID"] . '" value="' . $query[$a]["ID"] . '">
                        <a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=update&id=' . $query[$a]["ID"] . '"><i style="color:#2d2d2d" class="fa fa-pencil fa-fw"></i></a>
                        <a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=delete&id=' . $query[$a]["ID"] . '"><i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i></a>
                        <a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=duplicate&id=' . $query[$a]["ID"] . '"><i style="color:#3d7aed" class="fa fa-paper-stack fa-fw"></i></a>
                      </td>
                      <td>' . $query[$a]["code"] . '</td>
                      <td>' . $query[$a]["name"] . '</td>
                      <td data-class="copy"><span class="s_Copy">[WPackage_HR id=' . $query[$a]["ID"] . ' title="' . $query[$a]["name"] . '"]</span></td>
                      <td>' . $query[$a]["deadline"] . '<span style="' . $backGround_color . '" class="date"></span></td>
                    </tr>';
        };

        echo $forms;
      }

    }

  }

  //--------------------------------------------

  /**
   * Filtra Moduli
   */

  public function filterModule($text){
    global $wpdb;

    $query = $wpdb->get_results("select name, code from wpackage_hr_module;", ARRAY_A);

    $select = "<option value=''>" . $text . "</option>";

    for ($i=0; $i < count($query); $i++) {

        $name = explode(" ", $query[$i]["code"]);
        $newName = "";

        for ($d = 0; $d < count($name); $d++) {
          if($d == count($name)-1){
            $newName .= $name[$d];
          }else{
            $newName .= $name[$d] . "_";
          }
          
        }

      $select .= "<option value='" . $newName . "'>" . $query[$i]["name"] . "</option>";
    }

    return $select;
  }


  //--------------------------------------------
  /**
   * Settaggio 
   * Mail di risposta
   */

  public function saveReply($id, $array){
    global $wpdb;

    $query = $wpdb->update( 'wpackage_hr_module', array(
      "reply_object" => $array['object'],
      "reply_content" => $array['contentReply']
   ), array( 'ID' => $id ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
    
  }


  //--------------------------------------------

  /**
   * Settaggio 
   * Mail di risposta
   */

  public function replyModule($id){
    global $wpdb;

    $query = $wpdb->get_results("select name, reply_object, reply_content from wpackage_hr_module where ID=$id;", ARRAY_A);

    $this->reply_name = $query[0]['name'];
    $this->reply_object = $query[0]['reply_object'];
    $this->reply_msg = preg_replace('/[\\\]/', '', $query[0]['reply_content']);
    
  }


}



$HR_MODULE = new HR_Module();