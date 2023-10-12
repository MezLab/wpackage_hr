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
global $HR_MODULE;
global $HR_CANDIDATE;
global $wpdb;

?>

<?php if(isset($_GET["id"])):?>

  <?php echo section_top_myPlugIn( array("h1" => "Gestione Moduli", "p" => "Pagina gestione moduli")); ?>

  <?php 

    switch ($_GET["module"]) {
      case 'update':
        if(isset($_POST['btn_'])){

          $moduleData = array(
            "nameModule" => $_POST['nameModule'],
            "code" => $_POST['code'],
            "deadline" => $_POST['deadline'],
            "content" => $_POST['content'],
          );

          $modFolder = $wpdb->get_results("select code from wpackage_hr_module where ID=" . intval($_GET["id"]) . " ;", ARRAY_A);

          $HR_CANDIDATE->modifyFolder($modFolder[0]['code'], $_POST['code']);
          $HR_CANDIDATE->modifyURL($_GET["id"], $_POST['code']);
          
          ?>
            <div class="_msg_">
            <?php
            isNull($HR_MODULE->update(intval($_GET["id"]), $moduleData), "Modulo Modificato");
            echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_module_page">Aggiorna la pagina</a></div>';
            ?>
            </div>
          <?php
        }else{
          
          $set_Module = $HR_MODULE->settingModule(intval($_GET["id"]));
          if(count($set_Module) > 0){
            ?>
              <form class="create_module" action="" method="post">
                <div class="setting">
                  <input type="text" name="nameModule" id="" placeholder="Aggiungi Nome Modulo" value="<?php echo $set_Module[0]['name']; ?>">
                  <!-- Sezione nella creazione del form tramite i Shortcode  -->
                  <div class="boxModel">
                    <h2>Personalizza il tuo <b>FORM</b></h2>
                    <p><b>clicca</b> sul campo che desideri <em>aggiungere</em></p>
                    <div id="dash_control" class="dash_control"></div>
                  </div>
                  <div class="style">
                    <label for="">Inserisci il codice del modulo</label>
                    <input type="text" name="code" id="" placeholder="Codice Univoco" value="<?php echo $set_Module[0]['code']; ?>">
                  </div>
                  <div class="style">
                    <label for="">Inserisci la scadenza</label>
                    <input type="date" name="deadline" id="" placeholder="Scadenza" value="<?php echo $set_Module[0]['deadline']; ?>">
                  </div>
                  <input type="hidden" name="content" id="moduleForm" value='<?php echo str_replace("'", "&#039;", $set_Module[0]['content']);?>'>
                  <button onclick="" type='submit' name='btn_'>Modifica Modulo</button>
                </div>
              </form>
              <div class="canvas">
                <div class="formPreview">
                  <div>
                    <h2>Gestisci l'anteprima</b></h2>
                    <p>quando la <em>bozza</em> è pronta <b>salva il Form</b></p>
                  </div>
                  <div>
                    <a class="saveForm" onclick="saveForm()">Salva il <b>form</b></a>
                  </div>
                </div>
                <div class="masterpiece">
                  <div class="originalForm"></div>
                </div>
              </div>
              <section class="setInput">
                <div class="heading">
                  <div>
                    <h2>Box personalizza <b>CAMPO</b></h2>
                    <p><b>compila</b> i vari campi <em>e inserisci l'input</em></p>
                  </div>
                  <div>
                    <button style="margin:0px;" onclick="closeBox()">Chiudi box</button>
                  </div>
                </div>
              </section>

              <script>
                var vIn = document.querySelector('input#moduleForm').value;

                setTimeout(() => {
                  WPackage_form._compiler(vIn);
                }, 1000);
                
                
              </script>

            <?php   
          }else{
            echo "<p class='err_empty'>Nessun Modulo trovato</p>";
          }

        }

        break;
      case 'delete':

        isNull($HR_MODULE->delete($_GET["id"]), "Modulo Eliminato");
        echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_module_page">Aggiorna la pagina</a></div>';

        break;
      case 'duplicate':

        isNull($HR_MODULE->duplicate($_GET["id"]), "Modulo Duplicato");
        echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_module_page">Aggiorna la pagina</a></div>';

        break;
      default:
        echo '<p>Nulla in programma</p>';
        break;
    }
    
  ?>

<?php elseif($_GET["module"] == "add"): ?>

  <?php echo section_top_myPlugIn( array("h1" => "Nuovo Modulo", "p" => "Inserisci un nuovo modulo")); ?>

  <form class="create_module" action="" method="post">
    <div class="setting">
      <input type="text" name="nameModule" id="" placeholder="Aggiungi Nome Modulo">
      <!-- Sezione nella creazione del form tramite i Shortcode  -->
      <div class="boxModel">
        <h2>Personalizza il tuo <b>FORM</b></h2>
        <p><b>clicca</b> sul campo che desideri <em>aggiungere</em></p>
        <div id="dash_control" class="dash_control"></div>
      </div>
      <div class="style">
        <label for="">Inserisci il codice del modulo</label>
        <input type="text" name="code" id="" placeholder="Codice Univoco">
      </div>
      <div class="style">
        <label for="">Inserisci la scadenza</label>
        <input type="date" name="deadline" id="" placeholder="Scadenza">
      </div>
      <input type="hidden" name="content" id="moduleForm">
      <button onclick="" type='submit' name='btn_'>Inserisci Modulo</button>
    </div>
  </form>
    <div class="canvas">
      <div class="formPreview">
        <div>
          <h2>Gestisci l'anteprima</b></h2>
          <p>quando la <em>bozza</em> è pronta <b>salva il Form</b></p>
        </div>
        <div>
          <a class="saveForm" onclick="saveForm()">Salva il <b>form</b></a>
        </div>
      </div>
      <div class="masterpiece">
        <div class="originalForm"></div>
      </div>
    </div>
  <section class="setInput">
    <div class="heading">
      <div>
        <h2>Box personalizza <b>CAMPO</b></h2>
        <p><b>compila</b> i vari campi <em>e inserisci l'input</em></p>
      </div>
      <div>
        <button style="margin:0px;" onclick="closeBox()">Chiudi box</button>
      </div>
    </div>
  </section>

<?php

if(isset($_POST['btn_'])){

  $newModule = array(
    "nameModule" => $_POST['nameModule'],
    "code" => $_POST['code'],
    "deadline" => $_POST['deadline'],
    "content" => $_POST['content'],
  );
  
  isNull($HR_MODULE->add($newModule), "Modulo Inserito");
  
  echo '<div class="up"><a class="btn_hr" href="' . url_my_path() . 'wp-admin/admin.php?page=admin_module_page">Aggiorna la pagina</a></div>';

}

?>

<?php endif;?>