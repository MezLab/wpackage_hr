<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Function Design Front End
 * Version:           1.1
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

/**
 * @param $x => array()
 * (Associazione => [h1, p])
 * Heading delle Pagine
 */

function section_top_myPlugIn($x = array()){
  $html_ = "<section class='header_wpckage_hr'>
              <div class='topLane'>
                <img src='" . plugin_dir_url(__DIR__) . "../admin/media/img/cube_admin.png' alt='Unsocials TheLaboratory'>
                <h1><b>WP</b>ackage HR<sup>unsocials&copy;</sup></h1>
              </div>
              <div class='midLane'>
                <h1>" . $x["h1"] . "</h1>
                <p>" . $x["p"] . "</p>
              </div>  
            </section>";

  return $html_;
}
?>