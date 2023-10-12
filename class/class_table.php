<?php

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Table
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


class HR_Table
{

  /* ----------------- */
  /** PROPERTY */
  /* ----------------- */


  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  function __construct(){}

  //--------------------------------------------

  /**
   * Visualizzazione di tutti gli utenti
   * Tabella USER
   */
  public function get_table_user(){
    global $wpdb;
    $users = "";

    $query = $wpdb->get_results("select * from wpackage_hr_user", ARRAY_A);

    for($a = 0; $a < count($query); $a++){
      $users .= '<tr>
                  <td>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newUser&user=update&id=' . $query[$a]["ID"] . '">
                      <i style="color:#2d2d2d" class="fa fa-pencil fa-fw"></i>
                      <span class="tooltiptext">Modifica</span>
                    </a>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newUser&user=delete&id=' . $query[$a]["ID"] . '">
                      <i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i>
                      <span class="tooltiptext">Elimina</span>
                    </a>
                  </td>
                  <td>' . $query[$a]["nickname"] . '</td>
                  <td>' . $query[$a]["name"] . " " .$query[$a]["surname"] . '</td>
                  <td>' . $query[$a]["email"] . '</td>
                  <td>' . $query[$a]["date_create"] . '</td>
                </tr>';
    }

    return "<table class='myTable'>
              <thead>
                <tr>
                  <td><i class='fa fa-cog4 fa-1x fa-fw'></i></td>
                  <td>Utente</td>
                  <td>Nome</td>
                  <td>Mail</td>
                  <td>Data Creazione</td>
                </tr>
              </thead>
              <tbody>
                $users
              </tbody>
            </table>";
  }


    //--------------------------------------------

  /**
   * Visualizzazione di tutti i Moduli
   * Tabella MODULE
   */
  public function get_table_module(){
    global $wpdb;
    $forms = "";
    $backGround_color;

    $query = $wpdb->get_results("select * from wpackage_hr_module", ARRAY_A);

    for($a = 0; $a < count($query); $a++){
      /** Variabili Iniziali */
      $ToDay = new DateTime("now");
      $DeadLine = new DateTime($query[$a]["deadline"]);
      $Published = new DateTime($query[$a]["published"]);
      /** */

      $ggTotal = $Published->diff($DeadLine); // gg trascorsi dalla pubblicazione fino alla scadenza
      $ggToday = $ToDay->diff($DeadLine); // gg trascorsi da oggi fino alla scadenza
      $ggDiff = $ggToday->days/$ggTotal->days; // $ggToday : $ggTotal = x : 100
      $percent = ($ggDiff*100);

      (date_comparison($query[$a]["deadline"])) ? $backGround_color = "background-color:#64e764" : $backGround_color = "background-color:#da565c" ;

      $forms .= '<tr>
                  <td>
                    <input class="id_select" type="checkbox" name="' . $query[$a]["ID"] . '" value="' . $query[$a]["ID"] . '">
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=update&id=' . $query[$a]["ID"] . '">
                      <i style="color:#2d2d2d" class="fa fa-pencil fa-fw"></i>
                      <span class="tooltiptext">Modifica</span>
                    </a>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=duplicate&id=' . $query[$a]["ID"] . '">
                      <i style="color:#3d7aed" class="fa fa-paper-stack fa-fw"></i>
                      <span class="tooltiptext">Duplica</span>
                    </a>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_reply&id=' . $query[$a]["ID"] . '">
                      <i style="color:#11b523" class="fa fa-mail-reply fa-fw"></i>
                      <span class="tooltiptext">Reply</span>
                    </a>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_newModule&module=delete&id=' . $query[$a]["ID"] . '">
                      <i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i>
                      <span class="tooltiptext">Elimina</span>
                    </a>
                  </td>
                  <td>' . $query[$a]["code"] . '</td>
                  <td>' . $query[$a]["name"] . '</td>
                  <td data-class="copy"><span class="s_Copy">[WPackage_HR id=' . $query[$a]["ID"] . ' title="' . $query[$a]["name"] . '"]</span></td>
                  <td class="tooltipMenu progress">
                    <span style="z-index:9999;top: 0%;" class="tooltiptext">' . $ggToday->days . ' gg</span>
                    <progress value="'.$percent.'" max="100"></progress>' . $query[$a]["deadline"] . '<span style="' . $backGround_color . '" class="date"></span>
                  </td>
                </tr>';
    };

    return "<table id='myTable' class='myTable'>
              <thead>
                <tr>
                  <td><i class='fa fa-cog4 fa-1x fa-fw'></i></td>
                  <td>Codice Identificativo</td>
                  <td>Nome Modulo</td>
                  <td>Shortcode</td>
                  <td>Scadenza</td>
                </tr>
              </thead>
              <tbody>
                $forms
              </tbody>
            </table>";
  }


  //--------------------------------------------


    /**
   * Visualizzazione di tutti i candidati
   * Tabella CANDIDATE
   */
  public function get_table_candidate($page){
    global $wpdb;
    $forms = "";

    $postPerPage = 20;
    $number = $page * $postPerPage;

    
    $queryTot = $wpdb->get_results("select * from wpackage_hr_candidate", ARRAY_A);
    $query = $wpdb->get_results("select * from wpackage_hr_candidate limit " . $number . ", " . $postPerPage, ARRAY_A);

    for($a = 0; $a < count($query); $a++){

      $_ID = $query[$a]["id_module"];

      $module = $wpdb->get_results("select name from wpackage_hr_module where ID=$_ID;", ARRAY_A);

      $forms .= '<tr>
                  <td>
                    <input class="id_select" type="checkbox" name="' . $query[$a]["ID"] . '" value="' . $query[$a]["ID"] . '">
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=view_candidate&id=' . $query[$a]["ID"] . '">
                      <i style="color:#2d2d2d" class="fa fa-open fa-fw"></i>
                      <span class="tooltiptext">Anteprima</span>
                    </a>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=delete&id=' . $query[$a]["ID"] . '">
                      <i style="color:#ed503d" class="fa fa-trash2 fa-fw"></i>
                      <span class="tooltiptext">Elimina</span>
                    </a>
                  </td>
                  <td>' . $query[$a]["id_code"] . '</td>
                  <td>' . $query[$a]["mail"] . '</td>
                  <td>' . $module[$a]["name"] . '</td>
                  <td>' . $query[$a]["registered"] . '</td>
                  <td>
                    <a class="tooltipMenu" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page&candidate=download&id=' . $query[$a]["ID"] . '">
                      <i style="color:#6a4cf2;" class="fa fa-folder-open-o fa-fw"></i>
                      <span class="tooltiptext">Scarica File</span>
                    </a>
                  </td>
                </tr>';
    };

    return "<table id='myTable' class='myTable'>
              <thead>
                <tr>
                  <td><i class='fa fa-cog4 fa-1x fa-fw'></i></td>
                  <td>Codice Candidato</td>
                  <td>Mail</td>
                  <td>Modulo</td>
                  <td>Invio Candidatura</td>
                  <td>File</td>
                </tr>
              </thead>
              <tbody>
                $forms
              </tbody>
            </table>" . $this->perPagePost($page, $number, count($query), count($queryTot), "admin.php?page=admin_candidate_page", $postPerPage);
            
  }


  //--------------------------------------------

  /**
   * Visualizzazione Totale Inseriti
   */
  public function getTotal(string $tableDB){
    global $wpdb;

    $query = $wpdb->get_results("select * from " . $tableDB, ARRAY_A);

    return count($query);
  }


  /**
   * Page for Post
   */

   public function perPagePost($page, $num, $limit, $total, $link, $perPage){

    $ppp = "<div class='perPages'><span>" . ($num + 1) . " - " . ($num + $limit) . " di <b>(" . $total . " elementi)</b></span>";

    if($num == 0){
      $ppp .= "<a style='opacity:0.5;' class='pageLink' href='javascript:void(0)'><i class='fa fa-chevron-left fa-fw'></i></a>";
    }else{
      $ppp .= "<a class='pageLink' href='" . $link . "&pages=" . ($page - 1) . "'><i class='fa fa-chevron-left fa-fw'></i></a>";
    }
    
    if(($page+1) > ($total/$perPage)){
      $ppp .= "<a style='opacity:0.5;' class='pageLink' href='javascript:void(0)'><i class='fa fa-chevron-right fa-fw'></i></a>";
    }else{
      $ppp .= "<a class='pageLink' href='" . $link . "&pages=" . ($page + 1) . "'><i class='fa fa-chevron-right fa-fw'></i></a>";
    }

    $ppp .= "</div>";

    return $ppp;

   }

}


$HR_TABLE = new HR_Table();