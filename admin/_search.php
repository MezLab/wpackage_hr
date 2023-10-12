<?php
/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Cerca Moduli
 * Version:           1.0
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */


if(isset($_GET['search_value'])){
  switch ($_GET['search_type']) {
    case 'module':
      $HR_MODULE->search($_GET['search_value']);
      break;
    case 'candidate':
      $HR_CANDIDATE->search($_GET['search_value']);
      break;
    case 'IDcandidate':
      $HR_CANDIDATE->searchID($_GET['search_value']);
      break;
    default:
      break;
  }
  
}else{
  $_GET['search_value'] = null;
}

?>