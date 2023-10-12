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

global $HR_USER;

?>

<?php if(isset($_GET["id"])):?>

  <?php echo section_top_myPlugIn( array("h1" => "Gestione Utente", "p" => "Pagina gestione utente")); ?>

  <?php 

    switch ($_GET["user"]) {
      case 'update':
        if(isset($_POST['btn_'])){

          $userData = array(
            "nickname" => $_POST['nickname'],
            "name" => $_POST['name'],
            "surname" => $_POST['surname'],
            "email" => $_POST['email'],
            "password" => $_POST['password']
          );

          ?>
            <div class="_msg_">
            <?php
            isNull($HR_USER->update(intval($_GET["id"]), $userData), "Utente Modificato");
            echo '<a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_user_page">Torna Indietro</a>';
            ?>
            </div>
          <?php
          
        }else{
          echo $HR_USER->settingUser(intval($_GET["id"]));
        }
        
        break;
      case 'delete':

        isNull($HR_USER->delete($_GET["id"]), "Eliminato");

        echo '<a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_user_page">Torna Indietro</a>';

        break;
      default:
        echo '<p>Nulla in programma</p>';
        break;
    }
    
  ?>

<?php elseif($_GET["user"] == "add"): ?>

  <?php echo section_top_myPlugIn( array("h1" => "Nuovo Utente", "p" => "Inserisci un nuovo utente")); ?>

  <form class='formHR' action='' method='post'>
    <label>Nickname</label>
    <input type='text' name='nickname' id='' value=''>
    <label>Nome</label>
    <input type='text' name='name' id='' value=''>
    <label>Cognome</label>
    <input type='text' name='surname' id='' value=''>
    <label>Email</label>
    <input type='email' name='email' id='' value=''>
    <label>Password</label>
    <div class="passwd _relative">
      <input id="pass_word" type="password" name='password' id="" value="" required>
      <button id="_btnPsw" type="button" name="button" data-button="Mostra Password" onclick="showPSW()">
        <span class="eyes"><i class="fa fa-eye"></i></span>
      </button>
    </div>
    <button class="btn_" id="_pswGenerated" type="button" name="button" data-button="Genera Password" onclick="pswGenerate()">Genera Password</button>
    <button type='submit' name='btn_'>Inserisci Utente</button>
  </form>


<?php

if(isset($_POST['btn_'])){

  $newUser = array(
    "nickname" => $_POST['nickname'],
    "name" => $_POST['name'],
    "surname" => $_POST['surname'],
    "email" => $_POST['email'],
    "password" => $_POST['password']
  );
  
  isNull($HR_USER->add($newUser), "Utente Inserito");
  
  echo '<a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_user_page">Torna Indietro</a>';

}

?>

<?php endif;?> 