<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Page Candidate
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
global $HR_CANDIDATE;

?>

<?php if(isset($_GET["id"])):?>

  <?php echo section_top_myPlugIn( array("h1" => "Anteprima Candidato", "p" => "Stai visualizzando i dati inseriti e il CV")); ?>

  <?php $HR_CANDIDATE->set($_GET["id"]); ?>

  <div class="candidate">
    <div class="wrap">
      <i class="fa fa-user-circle-o fa-1x fa-fw"></i>
        <label for="">Codice Utente</label>
        <p><?php echo $HR_CANDIDATE->getCode(); ?></p>
    </div>
    <div class="wrap">
      <i class="fa fa-mail fa-1x fa-fw"></i>
      <label for="">Email</label>
      <p><?php echo $HR_CANDIDATE->getMail(); ?></p>
    </div>
    <div class="wrap">
      <i class="fa fa-wpforms fa-1x fa-fw"></i>
      <label for="">Modulo di iscrizione</label>
      <p><?php echo $HR_CANDIDATE->getModule(); ?></p>
    </div>
  </div>
  <div class="view_candidate">
    <div class="cand_Preview">
      <div class="data">
        <p>Dati Inseriti</p>
        <embed src="<?php echo $HR_CANDIDATE->getPathData(); ?>"/>
      </div>
      <div class="file">
        <p>File Allegato</p>
        <embed src="<?php echo $HR_CANDIDATE->getPathFile(); ?>"/>
      </div>
    </div>
  </div>

<?php else:?>
 
  <?php echo 'Inpossibile vedere i dati!' ?> 

<?php endif;?> 


