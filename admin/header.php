<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Header
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
?>

<?php
/**
 * Controllo della Sessione
 * di Accesso al Software
 * 
 * La sezione rende visibili i componenti
 * per utente Admin HR
 */
?>

<h1 class="n"><b>Responsabile HR: </b><?php echo $HR_LOGIN->getFullName();?></h1>
<nav class="navigation">
  <a class="btn_close" href="<?php echo url_my_path()?>wp-admin/admin.php?page=wpackage_hr&admin=logout">Esci</a>
</nav> 

