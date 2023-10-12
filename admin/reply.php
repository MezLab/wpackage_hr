<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Gestione Risposta Mail
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
global $HR_MODULE;
?>

  <?php 
  if(!isset($_GET["update"])){
    $_GET["update"] = null;
  }else{
    if($_GET["update"] == "save"){

      $replyData = array(
        "object" => $_POST['object'],
        "contentReply" => $_POST['contentReply']
      );

      isNull($HR_MODULE->saveReply($_GET['id'], $replyData), "Risposta Salvata");
      echo '<a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_module_page">Torna Indietro</a>';
    }
  }
    
  ?>

  <?php echo section_top_myPlugIn( array("h1" => "Reply", "p" => "Mail di Risposta")); ?>

  <?php $HR_MODULE->replyModule($_GET['id']); ?>

  <form class="create_module" action="admin.php?page=admin_reply&update=save&id=<?php echo $_GET['id']; ?>" method="post">
    <div class="setting">
      <div class="style">
        <label for="">Nome Modulo</label>
        <h1><?php echo $HR_MODULE->getReply_name(); ?></h1>
      </div>
      <div class="style">
        <label for="">Oggetto della Mail</label>
        <input type="text" name="object" id="obj" value="<?php echo $HR_MODULE->getReply_object(); ?>">
      </div>
      <button onclick="" type='submit' name='btn_'>Salva Risposta</button>
    </div>
    <div class="canvas">
      <div class="formPreview">
        <div>
          <h2>Contenuto <b>della risposta</b></h2>
          <p>quando la <em>bozza</em> è pronta <b>salva</b></p>
        </div>
      </div>
      <?php wp_editor($HR_MODULE->getReply_msg() , 'contentReply'); ?>
    </div>
  </form>
