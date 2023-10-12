<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Utenti HR
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

global $HR_TABLE;
?>

  <?php echo section_top_myPlugIn( array("h1" => "Utenti", "p" => "Visualizza Utenti")); ?>
  <a class="btn_hr" href="<?php echo url_my_path()?>wp-admin/admin.php?page=admin_newUser&user=add"><i class="fa fa-user-add-outline fa-fw"></i> Aggiungi Nuovo</a>
  <p><b>Utenti HR</b> (<?php echo $HR_TABLE->getTotal('wpackage_hr_user'); ?>)</p>
  <?php echo $HR_TABLE->get_table_user(); ?>

