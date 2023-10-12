/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       General Script
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

var iPsw, btnPsw, eyePsw;

/**
 * Istruzioni che 
 * mostrano la password
 */

iPsw = document.getElementById('pass_word');
btnPsw = document.querySelector('button#_btnPsw');
eyePsw = document.querySelector('.fa-eye');

/**
 * Funzioni Booleane
 * che controlla l'attributo
 */

function is_Attribute(elem, attr, name) {
  return elem.getAttribute(attr) == name;
}

function showPSW() {
  if (is_Attribute(eyePsw, 'class', 'fa fa-eye')) {
    eyePsw.setAttribute('class', 'fa fa-eye-slash');
    iPsw.setAttribute('type', 'text');
  }
  else {
    eyePsw.setAttribute('class', 'fa fa-eye');
    iPsw.setAttribute('type', 'password');
  }
}


/**
 * Funzione che genera
 * una password
 */
function charRandom(array) {
  let num = array.length;
  let pos = 0;
  let stringFour = "";
  let def_string = "";

  while (pos < num) {
    stringFour = array[pos];
    stringFour = stringFour[Math.floor(Math.random() * stringFour.length)];
    def_string += stringFour;
    pos++;
  }
  return def_string;
}

function pswGenerate() {

  var alfa_max = "ABCDEFGHILJKMNOPQRSTUVXYZ";
  var alfa_min = "abcdefghiljkmnopqrstuvxyz";
  var number = "0123456789";
  var symbol = "<>@.,+-*$%&()[]{}!";

  var charts = [
    alfa_max,
    alfa_min,
    number,
    symbol
  ]

  var myPassword = "";
  var l = 0;

  while (l < 24) {
    myPassword = myPassword + charRandom(charts);
    l = myPassword.length;
  }

  eyePsw.setAttribute('class', 'fa fa-eye-slash');
  iPsw.setAttribute('type', 'text');

  iPsw.value = myPassword;
}

/**
 * Drag & Drop
 * MetaBox
 */

function dragDrop(){

    var items = document.querySelectorAll('.originalForm .wrapElem');

    function handleDragStart(e) {
      this.style.opacity = '0.4';

      dragSrcEl = this;

      e.dataTransfer.effectAllowed = 'move';
      e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragEnd(e) {
      this.style.opacity = '1';

      items.forEach(function (item) {
        item.classList.remove('over');
      });

      MB_Order();
    }

    function handleDragOver(e) {
      e.preventDefault();
      return false;
    }

    function handleDragEnter(e) {
      this.classList.add('over');
    }

    function handleDragLeave(e) {
      this.classList.remove('over');
    }

    function handleDrop(e) {
      e.stopPropagation();

      if (dragSrcEl !== this) {
        dragSrcEl.innerHTML = this.innerHTML;
        this.innerHTML = e.dataTransfer.getData('text/html');
      }

      return false;
    }

   
    items.forEach(function (item) {
      item.addEventListener('dragstart', handleDragStart);
      item.addEventListener('dragover', handleDragOver);
      item.addEventListener('dragenter', handleDragEnter);
      item.addEventListener('dragleave', handleDragLeave);
      item.addEventListener('dragend', handleDragEnd);
      item.addEventListener('drop', handleDrop);
    });
}



function checkSelect(d, elem){
  
  var intArray = []; var int = 0;
  var select_id = document.querySelectorAll('.id_select');

  for (let index = 0; index < select_id.length; index++) {

    if (select_id[index].checked){
      intArray[int] = select_id[index].value;
      int++;
    }
    
  }

  if(intArray.length == 0){
    alert('Nessun elemento selezionato!');
    return;
  }

  switch (d) {
    case 'delete':
      if(elem == 'module'){
        intArray.forEach(element => {
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function () {
            location.reload();
          }
          xhttp.open("GET", "admin.php?page=admin_newModule&module=delete&id=" + parseInt(element), true);
          xhttp.send();
        });
      }else{
        intArray.forEach(element => {
          const xhttp = new XMLHttpRequest();
          xhttp.onload = function () {
            location.reload();
          }
          xhttp.open("GET", "admin.php?page=admin_candidate_page&candidate=delete&id=" + parseInt(element), true);
          xhttp.send();
        });
      }
      break;
    default:
      break;
  }
  
}


/**
 * Copy Shortcode Modulo
 */

function start_shortcode_copy(){
  var shortCodeElem = document.querySelectorAll('td[data-class="copy"]');

  for (let index = 0; index < shortCodeElem.length; index++) {
    shortCodeElem[index].addEventListener("click", shortcode_copy);
  }
}

start_shortcode_copy();

function shortcode_copy() {
  /* Ottieni il campo dello shortcode */
  var shortcode = this.querySelector(".s_Copy");
  /* Copia lo shortcode all'interno del campo di testo */
  navigator.clipboard.writeText(shortcode.innerHTML);
  /* Avvisa che lo shortcode è stato copiato */
  alert("Shortcode Copiato: " + shortcode.innerHTML);
}



function _searchDB(type){
  var _s = document.querySelector('.sel_ input[type=search]');

  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.querySelector('#myTable tbody').innerHTML =  this.responseText;
    start_shortcode_copy();
  }
  xhttp.open("GET", "?search_value=" + _s.value + "&search_type=" + type , true);
  xhttp.send();

  
}

function _searchPerModule(id, type){
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function () {
    document.querySelector('#myTable tbody').innerHTML = this.responseText;
    start_shortcode_copy();
  }
  xhttp.open("GET", "?search_value=" + id + "&search_type=" + type, true);
  xhttp.send();
}

function changeSelect(x, type){
  _searchPerModule(x.value, type);
}



function packSelect(c) {

  switch (c) {
    case 'packet':

      var selectName_module = document.querySelector('#downloadPacket');
      var btn = document.querySelector(".downloadPacket");
      btn.setAttribute("href", "?page=admin_candidate_page&candidate=packet&name=" + selectName_module.value);

      break;
    case 'excel':

      var selectName_module = document.querySelector('#downloadExcel');
      var btn = document.querySelector(".downloadExcel");
      var PathRest = "/wp-content/plugins/wpackage_hr/admin/excel.php";
      btn.setAttribute("href", window.location.protocol + "//" + window.location.hostname + PathRest + "?name=" + selectName_module.value);

      break;
    default:
      break;
  }

}