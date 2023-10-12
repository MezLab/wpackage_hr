<?php

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Candidate
 * Version:           1.2
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

class HR_Candidate
{
  /* ----------------- */
  /** PROPERTY */
  /* ----------------- */

  /** Nome del candidato */
  public $code;

  /** Cognome del candidato */
  public $mail;

  /** Email del candidato*/
  public $module;

  /** Password del candidato */
  public $PathData;

  /** Password del candidato */
  public $PathFile;


  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  //--------------------------------------------


  /**
   * Codice del candidato
   */
  public function getCode(){
    return $this->code;
  }

  /**
   * Mail del candidato
   */
  public function getMail(){
    return $this->mail;
  }

  /**
   * Module di Iscrizione del candidato
   */
  public function getModule(){
    return $this->module;
  }

  /**
   * Path file dati in txt del candidato
   */
  public function getPathData(){
    return $this->PathData;
  }

  /**
   * Path file allegato del candidato
   */
  public function getPathFile(){
    return $this->PathFile;
  }
  
  /**
   * Path file allegato del candidato
   */
  public function set($id){

    global $wpdb;

    $query = $wpdb->get_results("select * from wpackage_hr_candidate where ID=$id ;", ARRAY_A);

    $idModule = $query[0]['id_module'];

    $query2 = $wpdb->get_results("select name from wpackage_hr_module where ID=$idModule ;", ARRAY_A);

    $way = plugin_dir_path(__DIR__);
    $path = $query[0]['url_directory'];
    $dirPath = url_my_plugin() . "/" . $query[0]['url_directory'];

    $this->code = $query[0]['id_code'];
    $this->mail = $query[0]['mail'];
    $this->module = $query2[0]['name'];
    $this->PathData = $dirPath . $this->searchFileFolder($way . $path)[0];
    $this->PathFile = $dirPath . $this->searchFileFolder($way . $path)[1];

  }
  
  /**
   * Crea il Codice 
   * identificativo del candidato
   */
  public function setCode(int $id){
    global $wpdb;
    //variabili di codifica codice
    $name_module = "";
    $pos_candidate = 0;
    $idModule = "M" . $id;

    $query = $wpdb->get_results("select ID, name from wpackage_hr_module where ID=$id ;", ARRAY_A);

    $query1 = $wpdb->get_results("select * from wpackage_hr_candidate", ARRAY_A);
    $query2 = $wpdb->get_results("select id_module from wpackage_hr_candidate where id_module=$id ;", ARRAY_A);

    if(count($query1) == 0){
      $pos_candidate = 1;
    }else{
      $pos_candidate = count($query2) + 1;
    }

    $nm = explode(' ', $query[0]["name"]);
    
      foreach ($nm as $key => $value) {
        $name_module .= $value[0];
      }
    
      return $name_module . $pos_candidate . $idModule;


  }

  //--------------------------------------------

  /**
   * Crea la Directory
   * contenente i DATI/FILE 
   * del Registrante
   */
  public function DIR_Generator($id_code, $candidato, $files, $dir){

    $myPath = plugin_dir_path(__DIR__) . 'candidate/' . $dir . "/";
    $myDirPath = $myPath . strtolower($id_code);

    // Crea la cartella del candidato
    mkdir($myDirPath, 0777, true);

    // Crea il file con i dati del Modulo
    $openFile = $myDirPath . "/" . $id_code . "_data.txt";
    foreach ($candidato as $key => $value) {
      fwrite(fopen($openFile, 'a'), $value['title'] . " = {" . $value['valore'] . "}\n");
    }
    fclose($openFile);

    // Inserisci il file in allegato
    foreach ($_FILES as $key => $value) {
      foreach ($_FILES[$key] as $param => $val) {
        if($param == 'name'){
          $uploadfile = $myDirPath . "/" . $val;
        }
        
        if($param == 'tmp_name')
          if (move_uploaded_file($val, $uploadfile)) {
            echo "File allegato è valido";
          } else {
            echo "Ops, non siamo riusciti a caricare il file";
          }

      }
    }
    
  }


  //--------------------------------------------

  /**
   * Cerca file 
   * nella cartella 
   * del candidato
   */
  public function searchFileFolder($folderName) {

    $size = 0;
    $files_ = [];

         if (is_dir($folderName))
           $folderHandle = opendir($folderName);

         if (!$folderHandle)
              return;

         while($file = readdir($folderHandle)) {
               if ($file != "." && $file != "..") {
                $files_[$size] = "/" . $file;
                $size++;
               }
         }
         closedir($folderHandle);
         return $files_;

}

  //--------------------------------------------

  /**
   * Rimuovi cartella 
   * dei candidati
   */
  public function removeFolder($folderName) {

         if (is_dir($folderName))
           $folderHandle = opendir($folderName);

         if (!$folderHandle)
              return false;

         while($file = readdir($folderHandle)) {
               if ($file != "." && $file != "..") {
                    if (!is_dir($folderName."/".$file))
                         unlink($folderName."/".$file);
                    else
                         removeFolder($folderName.'/'.$file);
               }
         }
         closedir($folderHandle);
         rmdir($folderName);
         return true;

}


  //--------------------------------------------

  /**
   * Modifica cartella 
   * dei candidati
   */
  public function modifyFolder($oldName, $newName) {

    if($oldName == $newName){
      return false;
    }else{
      $path = plugin_dir_path(__DIR__) . "candidate/";
      rename($path . $oldName, $path . $newName);
      return true;
    }

}

//--------------------------------------------

  /**
   * Modifica url directory 
   * dei candidati
   */
  public function modifyURL($ID, $Code) {

  global $wpdb;

  $modURL = $wpdb->get_results("select url_directory from wpackage_hr_candidate where id_module=" . $ID . " ;", ARRAY_A);

  foreach ($modURL as $key => $value) {
    $ppp = explode('/', $value['url_directory']);
    $ppp[1] = $Code;
    $ppp = implode('/', $ppp);

    $queryURL = $wpdb->update( 'wpackage_hr_candidate', array("url_directory" => $ppp), array( 'id_module' => $ID ) );

    if(!is_null($queryURL)){
      return true;
    }else{
      return false;
    }

  };
  
}

  //--------------------------------------------

  /**
   * Elimina Candidato
   * nel DATABASE 
   */
  public function delete(int $id){
    global $wpdb;
    
    $q_candidate = $wpdb->get_results("select url_directory from wpackage_hr_candidate where ID=$id ;", ARRAY_A);
    $way = plugin_dir_path(__DIR__);

    if($this->removeFolder($way . $q_candidate[0]['url_directory'])){

      $query = $wpdb->delete( 'wpackage_hr_candidate', array( 'ID' => $id ) );

      if(!is_null($query)){
        return true;
      }else{
        return false;
      }

    }

    return false;



  }


  //--------------------------------------------

  /**
   * Aggiungi Candidato
   * nel DATABASE 
   */
  public function add(array $array){
    global $wpdb;

    $query = $wpdb->insert( 'wpackage_hr_candidate', array(
      "id_code" => $array['id_code'],
      "mail" => $array['mail'],
      "registered" => $array['registered'],
      "url_directory" => $array['url_directory'],
      "id_module" => $array['id_module']
    ) );

    if(!is_null($query)){
      return true;
    }else{
      echo var_dump($wpdb->last_error);
      return false;
    }
  }



  //--------------------------------------------

  /**
   * Invio Mail
   * al candidato
   */
  public function sendMail($mail, $code, $id){
    global $wpdb;

    $query = $wpdb->get_results("select name, reply_object, reply_content from wpackage_hr_module where ID=$id ;", ARRAY_A);

    $object = $query[0]['name'] . ": " . $query[0]['reply_object'];

    $msg = "<p>Codice Utente: <b>" . $code . "</b></p>";

    $stringa = "<p>";

    for ($i=0; $i < strlen($query[0]['reply_content']); $i++) { 
      if($query[0]['reply_content'][$i] == PHP_EOL){
        $stringa .= "<br>";
      }
      $stringa .= preg_replace('/[\\\]/', '', $query[0]['reply_content'][$i]);
    } 

    $msg .= $stringa . "</p>";


    $headers[] = 'Content-Type: text/html; charset=UTF-8';

    if(!is_null($query)){
      /* Invio mail di risposta */
      wp_mail($mail, $object, $msg, $headers);
      return true;
    }else{
      return false;
    }
  }


  

//--------------------------------------------

  /**
   * Filtra Candidati
   * per Modulo
   */
  public function filterCandidate(){
    global $wpdb;

    $query = $wpdb->get_results("select ID, name, deadline from wpackage_hr_module;", ARRAY_A);

    $select = "<option value=''>Visualizza Candidati</option>";

    for ($i=0; $i < count($query); $i++) {
      $query2 = $wpdb->get_results("select * from wpackage_hr_candidate where id_module=" . $query[$i]["ID"], ARRAY_A);
      $select .= "<option value='" . $query[$i]["ID"] . "'>" . $query[$i]["name"] . " (" . count($query2) . ")</option>";
    }

    return $select;
  }


  //--------------------------------------------

  /**
   * Cerca Modulo
   * nel DATABASE 
   */
  public function search($string){
    global $wpdb;

    $forms = "";

    $query = $wpdb->get_results("select * from wpackage_hr_candidate where id_code like '%" . $string . "%'", ARRAY_A);

    if(!is_null($query)){
      if(count($query) == 0){
        echo '<p>Nessun Candidato Trovato</p>';
      }else{
        for($a = 0; $a < count($query); $a++){

          $_ID = $query[$a]["id_module"];

          $module = $wpdb->get_results("select name from wpackage_hr_module where ID=$_ID;", ARRAY_A);

      $forms .= '<tr>
                  <td>
                    <input class="id_select" type="checkbox" name="' . $query[$a]["ID"] . '" value="' . $query[$a]["ID"] . '">
                    <a href="' . url_my_path() . 'wp-admin/admin.php?view_candidate&id=' . $query[$a]["ID"] . '"><i style="color:#2d2d2d" class="fa fa-open fa-fw"></i></a>
                    <a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=delete&id=' . $query[$a]["ID"] . '"><i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i></a>
                  </td>
                  <td>' . $query[$a]["id_code"] . '</td>
                  <td>' . $query[$a]["mail"] . '</td>
                  <td>' . $module[0]["name"] . '</td>
                  <td>' . $query[$a]["registered"] . '</td>
                  <td><a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=download&id=' . $query[$a]["ID"] . '"><i style="color:#6a4cf2;" class="fa fa-folder-open-o fa-fw"></i></a></td>
                </tr>';
        };
        
        echo $forms;

      }
    }

  }


  //--------------------------------------------

  /**
   * Cerca Modulo
   * nel DATABASE 
   * in base a ID
   */
  public function searchID($ID){
    global $wpdb;

    $forms = "";

    $query = $wpdb->get_results("select * from wpackage_hr_candidate where id_module like '%" . $ID . "%'", ARRAY_A);

    if(!is_null($query)){
      if(count($query) == 0){
        echo '<p>Nessun Candidato Trovato</p>';
      }else{
        for($a = 0; $a < count($query); $a++){

          $_ID = $query[$a]["id_module"];

          $module = $wpdb->get_results("select name from wpackage_hr_module where ID=$_ID;", ARRAY_A);

      $forms .= '<tr>
                  <td>
                    <input class="id_select" type="checkbox" name="' . $query[$a]["ID"] . '" value="' . $query[$a]["ID"] . '">
                    <a href="' . url_my_path() . 'wp-admin/admin.php?page=view_candidate&id=' . $query[$a]["ID"] . '"><i style="color:#2d2d2d" class="fa fa-open fa-fw"></i></a>
                    <a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=delete&id=' . $query[$a]["ID"] . '"><i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i></a>
                  </td>
                  <td>' . $query[$a]["id_code"] . '</td>
                  <td>' . $query[$a]["mail"] . '</td>
                  <td>' . $module[0]["name"] . '</td>
                  <td>' . $query[$a]["registered"] . '</td>
                  <td><a href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=download&id=' . $query[$a]["ID"] . '"><i style="color:#6a4cf2;" class="fa fa-folder-open-o fa-fw"></i></a></td>
                </tr>';
        };
        
        echo $forms;

      }
    }

  }


  //--------------------------------------------

  /**
   * Scarica Documenti
   * singolo candidato
   */
  public function download($ID){
    global $wpdb;

    $forms = "";

    $query = $wpdb->get_results("select url_directory, id_code from wpackage_hr_candidate where ID=$ID;", ARRAY_A);

    /**
    * Aggiunge una cartella e le sue sottocartelle e i file contenuti a un archivio
    * se l'archivio non esiste, lo crea
    */

    //creazione dell'oggetto di classe
    $zip = new ZipArchive();

    //cartella generale
    $dir = untrailingslashit(plugin_dir_path(__DIR__)) . DIRECTORY_SEPARATOR . "candidate" . DIRECTORY_SEPARATOR;

    $name = "candidato_" . $query[0]['id_code'] . ".zip"; //nome dell'archivio
    $filename = $dir.$name; //indirizzo completo dell'archivio

    $zip->open($filename, ZipArchive::CREATE); 

    $dir_path = plugin_dir_path(__DIR__) . $query[0]['url_directory']; //indirizzo completo della cartella da zippare

    if(!is_dir($dir_path)){ 
        echo '<p>La cartella non esiste</p>';
        return;
    } 

    //aggiunge lo slash finale (o corrispettivo) se non presente nel nome cartella
    if(substr($dir_path, -1) != DIRECTORY_SEPARATOR){ 
        $dir_path.= DIRECTORY_SEPARATOR; 
    } 

    $dirStack = array($dir_path); 

    //trova l'indice da cui inizia l'ultima cartella
    $cutFrom = strrpos(substr($dir_path, 0, -1), DIRECTORY_SEPARATOR)+1;

    while(!empty($dirStack)){

        $currentDir = array_pop($dirStack); 
        $filesToAdd = array(); 

        $dir_folder = dir($currentDir); 
        while( false !== ($node = $dir_folder->read()) ){ 

            if( ($node == '..') || ($node == '.') ){ 
                continue; 
            } 

            if(is_dir($currentDir . $node)){ 
                array_push($dirStack, $currentDir . $node . DIRECTORY_SEPARATOR); 
            } 

            if(is_file($currentDir . $node)){ 
                $filesToAdd[] = $node; 
            } 

        } 

        $localDir = substr($currentDir, $cutFrom); 
        $zip->addEmptyDir($localDir); 

        foreach($filesToAdd as $file){ 
            $zip->addFile($currentDir . $file, $localDir . $file); 
        } 

    } 

    $zip->close();

    // Download dello Zip contenente i file del candidato
    if(file_exists($filename)){
      ?>
      <script type="text/javascript">
        window.location.href = "<?php echo url_my_plugin()."/admin/download.php?name=".$name."&filename=".$filename ?>" ;
      </script>
      <?php
    }

  }


  //--------------------------------------------

  /**
   * Scarica Documenti
   * singolo candidato
   */
  public function packet($dirPacket){
    /**
    * Aggiunge una cartella e le sue sottocartelle e i file contenuti a un archivio
    * se l'archivio non esiste, lo crea
    */

    //creazione dell'oggetto di classe
    $zip = new ZipArchive();

    //cartella generale
    $dir = untrailingslashit(plugin_dir_path(__DIR__)) . DIRECTORY_SEPARATOR . "candidate" . DIRECTORY_SEPARATOR;

    $name = "packet_" . $dirPacket . ".zip"; //nome dell'archivio
    $filename = $dir.$name; //indirizzo completo dell'archivio

    $zip->open($filename, ZipArchive::CREATE); 

    $dir_path = untrailingslashit(plugin_dir_path(__DIR__)) . DIRECTORY_SEPARATOR . $query[0]['url_directory']; //indirizzo completo della cartella da zippare

    if(!is_dir($dir_path)){ 
        echo '<p>La cartella non esiste</p>';
        return;
    } 

    //aggiunge lo slash finale (o corrispettivo) se non presente nel nome cartella
    if(substr($dir_path, -1) != DIRECTORY_SEPARATOR){ 
        $dir_path.= DIRECTORY_SEPARATOR; 
    } 

    $dirStack = array($dir_path); 

    //trova l'indice da cui inizia l'ultima cartella
    $cutFrom = strrpos(substr($dir_path, 0, -1), DIRECTORY_SEPARATOR)+1;

    while(!empty($dirStack)){

        $currentDir = array_pop($dirStack); 
        $filesToAdd = array(); 

        $dir_folder = dir($currentDir); 
        while( false !== ($node = $dir_folder->read()) ){ 

            if( ($node == '..') || ($node == '.') ){ 
                continue; 
            } 

            if(is_dir($currentDir . $node)){ 
                array_push($dirStack, $currentDir . $node . DIRECTORY_SEPARATOR); 
            } 

            if(is_file($currentDir . $node)){ 
                $filesToAdd[] = $node; 
            } 

        } 

        $localDir = substr($currentDir, $cutFrom); 
        $zip->addEmptyDir($localDir); 

        foreach($filesToAdd as $file){ 
            $zip->addFile($currentDir . $file, $localDir . $file); 
        } 

    } 

    $zip->close();

    // Download dello Zip contenente i file del candidato
    if(file_exists($filename)){
      ?>
      <script type="text/javascript">
        window.location.href = "<?php echo url_my_plugin()."/admin/download.php?name=".$name."&filename=".$filename ?>" ;
      </script>
      <?php
    }

  }

    //--------------------------------------------

  /**
   * Scarica Excel
   * dei candidati
   * in Real Time
   */

    public function excel($name){
      global $wpdb;

      $name_ = str_replace("_", " ", $name);
      $ID = $wpdb->get_results("select ID from wpackage_hr_module where code='" . $name_ . "';", ARRAY_A);

      $candidati = $wpdb->get_results("select id_code from wpackage_hr_candidate where id_module=" . intval($ID[0]['ID']) . ";", ARRAY_A);

      $arrayTemp = array();
      $arrayTitolazioni = array();
      $arrayDatiCandidati = array();
      $size_2 = 0;
      

      // $name Nome Cartella FTP
      // $candidati[$i]["id_code"] . "_data.txt"; Nome File txt del candidato
      for ($i=0; $i < count($candidati); $i++) {
        $testo = file_get_contents(plugin_dir_path(__DIR__) . "candidate/" . $name . "/" . strtolower($candidati[$i]["id_code"]) . "/" . $candidati[$i]["id_code"] . "_data.txt");
        $c = "";
        $size = 0;

        // Inserimento dati Candidato nell'array
        for ($b=0; $b < strlen($testo); $b++) { 
          if($testo[$b] == "\n"){
            $arrayTemp[$size] = $c;
            $c = "";
            $size++;
          }else{
            $c .= $testo[$b];
          }
        }
        
        for ($a=0; $a < count($arrayTemp); $a++) {
          $d = explode(" = ", $arrayTemp[$a]);
          $arrayTitolazioni[$a] = $d[0];
          $arrayDatiCandidati[$size_2] = str_replace(['{', '}'], '', $d[1]);
          $size_2++;
        }
      }

      // echo var_dump($arrayTitolazioni);
      // echo var_dump($arrayDatiCandidati);

      $stringTitle = implode(',', $arrayTitolazioni);
      $stringCandidati = implode(',', $arrayDatiCandidati);

      // Inserisco i dati in un Excel
      ?>
      <script type="text/javascript">
        window.location.href = "<?php echo url_my_plugin()."/admin/excel.php?titolazioni=".$stringTitle."&datiCandidati=".$stringCandidati."&nameFile=".$name ?>" ;
      </script>
      <?php
    }

}



$HR_CANDIDATE = new HR_Candidate();