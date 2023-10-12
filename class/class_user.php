
<?php

/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class User
 * Version:           1.2
 * Requires PHP:      7
 * Author:            Mez
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

// ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^


class HR_User
{

  /* ----------------- */
  /** PROPERTY */
  /* ----------------- */

  /** ID Utente */
  public $ID;

  /** Nome dell'utente */
  public $name;

  /** Cognome dell'utente */
  public $surname;

  /** Email dell'utente*/
  public $email;

  /** Password dell'utente */
  public $password;


  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  function __construct(){}

    //--------------------------------------------

  /**
   * ID Gestore HR 
   */

   public function getID(){
    return $this->ID;
   }

  //--------------------------------------------

  /**
   * Nome Gestore HR 
   */

   public function getName(){
    return $this->name;
   }

   //--------------------------------------------

    /**
   * Cognome Gestore HR 
   */

   public function getSurname(){
    return $this->surname;
   }

  //--------------------------------------------
   
  /**
   * Nome Intero Gestore HR 
   */

   public function getFullName(){
    return $this->name . " " . $this->surname;
   }


  //--------------------------------------------

  /**
   * Settaggio del Gestore HR
   */
  public function setUser(int $id){
    global $wpdb;

    $query = $wpdb->get_results("select ID, name, surname, email, password from wpackage_hr_user where ID=$id ;", ARRAY_A);

    $this->ID = intval($query[0]["ID"]);
    $this->name = $query[0]["name"];
    $this->surname = $query[0]["surname"];
    $this->email = $query[0]["email"];
    $this->password = $query[0]["password"];

  }

  //--------------------------------------------

  /**
   * Controlla se l'utente che accede
   * risiede nel Database Utenti HR 
   */
  public function userExist(string $mail, string $psw){
    global $wpdb;

    $query = $wpdb->get_results("select ID, email, password from wpackage_hr_user where email='" . $mail . "';", ARRAY_A);

    if(!is_null($query)){
      if($query[0]["password"] == $psw){
        $this->ID = intval($query[0]["ID"]);
        return true;
      } 
      else return false;
    }

    return false;
  }


  //--------------------------------------------

  /**
   * Modifica Utente
   * nel DATABASE 
   */
  public function settingUser(int $id){
    global $wpdb;

    $query = $wpdb->get_results("select * from wpackage_hr_user where ID=$id ;", ARRAY_A);

    if(count($query) > 0){
      $user = "<form class='formHR' action='' method='post'>
                <label>Nickname</label>
                <input type='text' name='nickname' id='' value='" . $query[0]["nickname"] . "'>
                <label>Nome</label>
                <input type='text' name='name' id='' value='" . $query[0]["name"] . "'>
                <label>Cognome</label>
                <input type='text' name='surname' id='' value='" . $query[0]["surname"] . "'>
                <label>Email</label>
                <input type='email' name='email' id='' value='" . $query[0]["email"] . "'>
                <label>Password</label>
                <div class='passwd _relative'>
                  <input id='pass_word' type='password' name='password' id='' value='" . $query[0]["password"] . "'>
                  <button id='_btnPsw' type='button' name='button' data-button='Mostra Password' onclick='showPSW()'>
                    <span class='eyes'><i class='fa fa-eye'></i></span>
                  </button>
                </div>
                <button class='btn_' id='_pswGenerated' type='button' name='button' data-button='Genera Password' onclick='pswGenerate()'>Genera Password</button>
                <button type='submit' name='btn_'>Modifica Utente</button>
              </form>";
    }else{
      $user = "<p class='err_empty'>Nessun Utente trovato</p>";
    }



    return $user;

  }

  //--------------------------------------------

  /**
   * Modifica Utente
   * nel DATABASE 
   */
  public function update(int $id, array $array){
    global $wpdb;

    $query = $wpdb->update( 'wpackage_hr_user', array( 
      'nickname' => $array["nickname"],
      'name' => $array["name"],
      'surname' => $array["surname"],
      'email' => $array["email"],
      'password' => $array["password"]
    ), array( 'ID' => $id ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
      
  }


  //--------------------------------------------

  /**
   * Elimina Utente
   * nel DATABASE 
   */
  public function delete(int $id){
    global $wpdb;

    $query = $wpdb->delete( 'wpackage_hr_user', array( 'ID' => $id ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }

  }


  //--------------------------------------------

  /**
   * Aggiungi Utente
   * nel DATABASE 
   */
  public function add(array $array){
    global $wpdb;

    $query = $wpdb->insert( 'wpackage_hr_user', array( 
      'nickname' => $array["nickname"],
      'name' => $array["name"],
      'surname' => $array["surname"],
      'email' => $array["email"],
      'password' => $array["password"],
      'date_create' => gmdate("Y-m-d")
    ) );

    if(!is_null($query)){
      return true;
    }else{
      return false;
    }
  }

}



class HR_Login extends HR_User
{

  /* ----------------- */
  /** METHOD */
  /* ----------------- */

  function __construct(){
    parent::__construct();
  }

  public function login(string $x, string $y, string $z){
    /**
    * Controllore del form 
    * e compilazione dei campi
    */

    $err = ""; // Errore
    
    if (isset($z)) {
      if(empty($x) && empty($y))
        $err = '&admin=empty';
      else if (empty($x))
        $err = '&admin=noName';
      else if (empty($y))
        $err = '&admin=noPsw';  
    }

    /**
     * Reindirizzamento della pagina
     * in base alla risultato della chiamata
     * sull'accesso dell'utente
     */
    if(!empty($x) && !empty($y)){
      $r = $this->verifyLogin($x, $y);
    ?>
      <script type="text/javascript">
        window.location.href = "<?php echo url_my_path() . 'wp-admin/admin.php?page=wpackage_hr' . $r['message'] ?>" ;
      </script>
    <?php
    }else{
      ?>
        <script type="text/javascript">
          window.location.href = "<?php echo url_my_path() . 'wp-admin/admin.php?page=wpackage_hr' . $err ?>";
        </script>
      <?php
    }
  }

  //--------------------------------------------
  /**
   * Verifica di 
   * veridicità dell'utente
   * all'accesso delle 
   * Risorse Umane
   */

  public function verifyLogin(string $a, string $b){
    // **********************************
    // Controllo della validita della mail
    $a = filter_var($a, FILTER_VALIDATE_EMAIL);
    if (!$a) {
      $result = [
        'message' => '&admin=noMail',
        'success' => false
      ];
      return $result;
    }

    // **********************************
    // Controllo della password
    if (strlen($b) < 6) {
      $result = [
        'message' => '&admin=shortPsw',
        'success' => false
      ];
      return $result;
    }

    // **********************************
    // Controllo dell'utente nel Database
    if($this->userExist($a, $b)){
      $result = [
        'message' => '&admin=login',
        'success' => true,
        'id_user' => $this->getID(),
      ];
      $_SESSION['access'] = $result['success'];
      $_SESSION['ID_User'] = $result['id_user'];
    }else{
      $result = [
        'message' => '&admin=invalid',
        'success' => false
      ];
    }
    
    return $result;
  }

  //--------------------------------------------

  /**
  * Gestione dell'errore|successo
  * con opportuno messaggio
  */

  public function getError(string $request){
    try {
      switch ($request) {
        case 'empty': // Campi Vuoti
           throw new Exception("Spiacente, non hai inserito nè il [NOME] nè la [PASSWORD]");
            break;
        case 'noName': // Campo mail/nome vuoto
          throw new Exception("Spiacente, non hai inserito il [NOME/MAIL]");
            break;
        case 'noPsw': // campo password vuoto
          throw new Exception("Spiacente, non hai inserito la [PASSWORD]");
            break;
        case 'invalid': // Utente non trovato
          throw new Exception("Spiacente, [UTENTE] non confermato!");
            break;
        case 'noAccess': // Utente non ha effettuato ancora l'accesso
          throw new Exception("Accedi");
            break;
        case 'logout': // Utente Disconnesso
          session_destroy();
          ?>
          <script type="text/javascript">
            window.location.href = "<?php echo url_my_path() . 'wp-admin/admin.php?page=wpackage_hr&admin=noAccess' ?>" ;
          </script>
          <?php
          throw new Exception("Disconnessione avvenuta con successo");
            break;
        case 'login': // Utente connesso
          throw new Exception("Benvenuto");
            break;
        case 'noMail': // Mail non valida
          throw new Exception("Non hai inserito una [MAIL] valida");
            break;
        case 'shortPsw': // Password non valida/corta
          throw new Exception("[PASSWORD] Debole");
            break;
        default:
        return;
            break;
      };
    } catch (Exception $e) {
      print("<p class='err_empty'>" . $e->getMessage() . "</p>");
    }
  }
}


$HR_LOGIN = new HR_Login();
$HR_USER = new HR_User();

