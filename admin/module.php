<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Creazione Moduli
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
global $HR_TABLE;

?>

  <?php echo section_top_myPlugIn( array("h1" => "Moduli", "p" => "Gestione dei Moduli")); ?>
    <a class="btn_hr" href="<?php echo url_my_path()?>wp-admin/admin.php?page=admin_newModule&module=add"><i class="fa fa-wpforms fa-1x fa-fw"></i> Aggiungi Nuovo</a>
    <p><b>Moduli </b> (<?php echo $HR_TABLE->getTotal('wpackage_hr_module'); ?>)</p>
    <div class="sel_">
      <div><button onclick="checkSelect('delete', 'module')">Elimina Moduli <i style="color:#1d2327" class="fa fa-trash2 fa-fw"></i></button></div>
      <div>
        <input type="search" name="search" id="" placeholder="Cerca Modulo" onkeyup="_searchDB('module')">
        <i style="color:#1d2327" class="fa fa-search fa-fw"></i>
      </div>
    </div>

  <?php echo $HR_TABLE->get_table_module(); ?>