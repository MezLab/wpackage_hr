<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Gestione Candidati
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

global $HR_TABLE;
global $HR_CANDIDATE;
global $HR_MODULE;

if(!isset($_GET["pages"])){
  $_GET["pages"] = 0;
}

if(!isset($_GET["candidate"])){
  $_GET["candidate"] = 'default';
}

?>

  <?php echo section_top_myPlugIn( array("h1" => "Candidati", "p" => "Gestione dei candidati")); ?>
    <p><b>Candidati </b> (<?php echo $HR_TABLE->getTotal('wpackage_hr_candidate'); ?>)</p>
    <div class="sel_">
      <span>
        <div><button onclick="checkSelect('delete', 'candidate')">Elimina Candidati <i style="color:#1d2327" class="fa fa-trash2 fa-fw"></i></button></div>
        <div>
          <select name="" id="viewCandidate" onchange="changeSelect(this, 'IDcandidate')">
            <?php echo $HR_CANDIDATE->filterCandidate(); ?>
          </select>
        </div>
        <div>
          <select onchange="packSelect('packet')" name="name" id="downloadPacket">
            <?php echo $HR_MODULE->filterModule('Scarica la cartella'); ?>
          </select>
          <a class="downloadPacket" href="">Scarica</a>
        </div>
        <div>
          <select onchange="packSelect('excel')" name="name" id="downloadExcel">
            <?php echo $HR_MODULE->filterModule('Scarica Excel'); ?>
          </select>
          <a class="downloadExcel" href="">Scarica</a>
        </div>
      </span>
      <span>
        <div>
          <input type="search" name="search" id="" placeholder="Cerca Codice Candidato" onkeyup="_searchDB('candidate')">
          <i style="color:#1d2327" class="fa fa-search fa-fw"></i>
        </div>
      </span>
    </div>
  
  <?php echo $HR_TABLE->get_table_candidate($_GET["pages"]); ?>

  <?php
    switch ($_GET["candidate"]) {
      case 'download':
        echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page">Aggiorna la pagina</a></div>';
        $HR_CANDIDATE->download($_GET["id"]);
        break;
      case 'packet':
        echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page">Aggiorna la pagina</a></div>';
        $HR_CANDIDATE->packet($_GET["name"]);
        break;
      case 'excel':
        $HR_CANDIDATE->excel($_GET["name"]);
        break;
      case 'delete':
        isNull($HR_CANDIDATE->delete($_GET["id"]), "Candidato Eliminato");
        echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_candidate_page">Aggiorna la pagina</a></div>';

        break;
      default:
        # code...
        break;
    }
  ?>