/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Create Form Custom
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

'use strict';

/**
 * Varibili
 */
var _dash = document.getElementById("dash_control");
var _pageForm = document.querySelector(".originalForm");
var _setBox = document.querySelector(".setInput");

var _set_Parameters_Form;

var ID_Meta = undefined;
var typeField = undefined;

var moduleForm = undefined;

/**
 * 
 * Oggetto per la creazione 
 * degli shortcode;
 * Gemello Evoluto della 
 * variabile oggetto objectInput
 */
function _objectInput(title, type, name, value, list, placeholder, required){
  this.title = title,
  this.type = type,
  this.name = name,
  this.value = value,
  this.list = list,
  this.placeholder = placeholder,
  this.required = required
};


// --------------------------
/**
 * Sezione CLASSI
 */


/**
 * 
 * Classe per la 
 * creazione dei Bottoni
 */
class _Button {

  constructor(tag, name, parameter) {
    this.tag = tag;
    this.name = name;
    this.parameter = parameter;
  }

  // Method
  create() {
    var a = document.createElement(this.tag);
    a.setAttribute('onclick', "WPackage_form._form('" + this.parameter + "'), openBox()");
    var b = document.createTextNode(this.name);
    a.appendChild(b);
    if(_dash != null){
    	_dash.appendChild(a);
    }
  }

}



/**
 * Funzione che campiona i 
 * settaggi compilati dal HR
 */
 
if(_setBox != null){
	_setBox.addEventListener('click', setParamaters);
}


function setParamaters(){
  WPackage_form._searchInput_reference();
}


/**
 * Funzione che
 * resetta i settaggi
 * del BOX
 */
function resetParamaters() {
  document.getElementById('formSetInput').reset();
  setParamaters();
}


/**
 * Oggetto di riferimento
 * per i campi del form
 */
const _buttons = {

  checkbox : 'checkbox',
  date : 'date',
  email : 'email',
  file : 'file',
  number : 'number',
  radio : 'radio',
  submit : 'submit',
  tel : 'tel',
  text : 'text',
  select : 'select',
};


/**
 * Inserimento dei bottoni
 * per la creazione dei campi
 */
var _button_object = Object.entries(_buttons);

for (var q = 0; q < _button_object.length; q++) {
  var _b = new _Button("SPAN", _button_object[q][0], _button_object[q][1]);
  _b.create();
}


/**
 * Funzione che controlla se 
 * il box necessita del Titolo
 * oppure No
 */
function crtlTitle(){
  var inputs = _abc.querySelectorAll('.inline .metadata');

  for (let r = 0; r < inputs.length; r++) {
    if (inputs[r].name == "placeholder" && inputs[r].checked) {
      return;
    }

    if (inputs[r].name == "title"){
      var t = true;
    }
  }

  if(!t) return;

  var p = document.createElement("P");
  var txt = document.createTextNode(inputs[0].value);
  p.appendChild(txt);

  
  return p;
}


/**
 * Funzione per sapere
 * con certezza quanti
 * METABOX esistono
 */

function MB_Size(){

  var parsingMeta = document.querySelectorAll('.wrapElem');
  if (parsingMeta.length <= 0) return 0;
  return parsingMeta.length;

}


/**
 * Riordina la sequenza dei campi
 * quando vengono riposizionati
 * o un campo viene cancellato
 */

function MB_Order(){
  var wrap = document.querySelectorAll('.wrapElem');
  var meta;

  for (let p = 0; p < MB_Size(); p++) {
    var spans = wrap[p].querySelectorAll('span');
    wrap[p].setAttribute('meta', p);
    meta = wrap[p].getAttribute('meta');

    var z = 0;
    while (z < 2) {
      var ppp = spans[z].getAttribute('onclick');
      var position = ppp.search(',');
      var string = spans[z].getAttribute('onclick').slice(position++, ppp.length);
      spans[z].setAttribute('onclick', '_mainBox_(' + meta + string);
      z++;

      }    
    }

}


/**
 * Funzione che genera il
 * contenitore per modificare
 * o eliminare il campo inserito
 * METABOX
 */

function MB(){


  var wrapElem = document.createElement('DIV');
  WPackage_form._setting(wrapElem, 'class', 'wrapElem');
  WPackage_form._setting(wrapElem, 'meta', MB_Size());
  WPackage_form._setting(wrapElem, 'draggable', 'true');

  for (let m = 0; m < 2; m++) {
    if(m == 0){
      var span = document.createElement('SPAN');
      WPackage_form._setting(span, 'class', 'modify');
      WPackage_form._setting(span, 'onclick', "_mainBox_(" + MB_Size() + ", 'update', '" + typeField + "')");
      var icon = document.createElement('I');
      WPackage_form._setting(icon, 'class', 'fa fa-pencil fa-fw');
      WPackage_form._setting(icon, 'style', "color:#2d2d2d");
      span.appendChild(icon);
    }else{
      var span = document.createElement('SPAN');
      WPackage_form._setting(span, 'class', 'delete');
      WPackage_form._setting(span, 'onclick', "_mainBox_(" + MB_Size() + ", 'delete')");
      var icon = document.createElement('I');
      WPackage_form._setting(icon, 'class', 'fa fa-trash2 fa-fw');
      WPackage_form._setting(icon, 'style', "color:#ed503d");
      span.appendChild(icon);
    }

    wrapElem.appendChild(span);

  }

  var title = crtlTitle();


  var Elem = document.createElement('DIV');
  WPackage_form._setting(Elem, 'class', 'elem');
  WPackage_form._setting(Elem, 'type', typeField);


  if(title != undefined)
    Elem.appendChild(title);

  
  wrapElem.appendChild(Elem);
  Elem.appendChild(HTMLCode);

  return wrapElem;

}

/**
 * Cerca il MetaDato di
 * riferimento e ritorna
 * l'elemento trovato
 * @param {Identificativo} id 
 * @returns 
 */

function searchMeta(id){
  var wrap = document.querySelectorAll('.wrapElem');
  var n = 0;
  while (n < wrap.length) {
    if (wrap[n].getAttribute('meta') == id) {
      return wrap[n];
    }
    n++;
  }

  return console.log('Non Trovato');
}

/**
 * Settaggio sul tipo 
 * di oggetto
 */
function typeObject(type, e){

  // Controlla che nel contenitore (e) esista una tag p
  if (e.contains(e.querySelector('p'))) {
    // Se esiste associa al parametro (title) dell'oggetto in valore/testo del paragrafo 
    objectInput.title = e.querySelector('p').innerHTML;
  }else{
    objectInput.title = "";
  };


  switch (type) { // Sceglie tra i vari tipi di campi
    case 'select':

      var select = e.querySelector('select');
      var options = select.querySelectorAll('option');

      //Controllo esistano opzioni
      if (options.length > 0) {
        var opt = [];
        var i = 0;

        options.forEach(element => {
          opt[i] = element.value;
          i++;
        });

        objectInput.list = opt;
        
      }

      recreates_Object(select);

      break;
    case 'radio':

      var radio = e.querySelectorAll('input');
      var radioList = [];

      for (let o = 0; o < radio.length; o++) {
        radioList[o] = radio[o].value;
      }

      recreates_Object(radio[0]);

      objectInput.list = radioList;

      break;
    case 'checkbox':

      var checkbox = e.querySelectorAll('input');
      var checkboxList = [];

      for (let o = 0; o < checkbox.length; o++) {
        checkboxList[o] = checkbox[o].value;
      }

      recreates_Object(checkbox[0]);

      objectInput.list = checkboxList;

      break;
    case 'file':
      var file = e.querySelector('input');
      recreates_Object(file);

      objectInput.list = file.getAttribute("accept").split(',');

      break;
    case 'text':
    case 'tel':
    case 'email':
    case 'submit':
    case 'date':

      recreates_Object(e.querySelector('input'));

      break;
    default:
      console.log('Nessun Campo è valido');
      break;
  }
  
}


/**
 * Funzione che ricrea
 * objectInput del campo selezionato
 */
function recreates_Object(path){

  var n = 0; // Variabile d'incremento
  var arrays = new Array();
  var _key = Object.keys(objectInput);

  // Controlla che il campo abbia degli attributi 
  if (path.hasAttributes()) {

    /**
     * Per ogni attributo presente nel campo
     * salva in (arrays) un nuovo array con nome e valore
     */
    for (let name of path.getAttributeNames()) {
      let value = path.getAttribute(name);

      arrays[n] = [name, value];

      if (arrays[n][0] == "placeholder"){
        objectInput.placeholder = true;
        objectInput.title = arrays[n][1];
      } 
      if (arrays[n][0] == "required") 
        objectInput.required = true;
      else
        objectInput.required = false;

      n++;

    }

    for (let r = 0; r < _key.length; r++) {
      for (let v = 0; v < arrays.length; v++) {
        if (arrays[v][0] == _key[r]) {

          if(arrays[v][0] != "placeholder" && arrays[v][0] != "required") {
            objectInput[_key[r]] = arrays[v][1];
          }
          
        }

      }
    }

    console.log(objectInput);
  }

}



/**
 * @param {Identificativo} id 
 * @param {Modifica / Elimina} _s 
 */

function _mainBox_(id, _s, type) {

  var meta = searchMeta(id); // Cerca se esiste questo tipo di Metadato

  switch (_s) { // Sceglie tra "Modifica" o "Elimina"

    case 'update': // scelta => "Modifica"

      var e = meta.querySelector('.elem'); //salva il contenitore dell'input del Metadato
      
      typeObject(type, e);

      WPackage_form._form(type); // crea il form di settaggio in base al tipo selezionato
      openBox(); // Apre il setBox
      WPackage_form._upgrade();// Mostra i valori del campo nel setBox

      /**
       * Cambia il bottone
       * in Modifica
       */
      var _a = _setBox.querySelector('a');
      _a.textContent = "Modifica";
      WPackage_form._setting(_a, 'onclick', 'updateElement(' + id + ', "' + type + '")');


      break;
    case 'delete': // scelta => "Elimina"
      meta.remove();
      MB_Order();
      break;
    default:
      break;
  }

}


/**
 * Parsing dei campi
 * creati nel modulo 
 * e salvataggio in My_Object_Form
 */

function parsForm(){

  var My_Object_Form = new Array(); // Array degli oggetti del Form 
  var singleMeta = document.querySelectorAll('.wrapElem .elem');

  for (let index = 0; index < singleMeta.length; index++) {

    Object.keys(objectInput).forEach(key => {
      if (key == "list") objectInput[key] = [];
      else objectInput[key] = "";
    });

    var type = singleMeta[index].getAttribute('type');

    objectInput.type = type;

    typeObject(type, singleMeta[index]);

    My_Object_Form.push(new _objectInput(
      objectInput.title,
      objectInput.type,
      objectInput.name,
      objectInput.value,
      objectInput.list,
      objectInput.placeholder,
      objectInput.required,
    ));
  }

  return My_Object_Form;
}

/**
 * Crea gli shortcode
 * e li salva nell'input #moduleForm
 */
function saveForm(){
  moduleForm = document.getElementById("moduleForm");

  /** Creazione del messaggio di risposta */
  var response = document.querySelector('.header_wpckage_hr');
  var p = document.createElement('P');
   

  if(WPackage_form._shortcode(moduleForm, parsForm())){
    WPackage_form._setting(p, 'class', 'veryGood');
    var msg = document.createTextNode('Salvato correttamente');
    p.appendChild(msg);
    response.appendChild(p);
  }else{
    WPackage_form._setting(p, 'class', 'err_empty');
    var msg = document.createTextNode('Ops...qualcosa è andato storto');
    p.appendChild(msg);
    response.appendChild(p);
  }

  console.log(moduleForm);
  
}

/**
 * Apertura del BOX Form
 */
function openBox(){
  _setBox.style.display = "block"; // Rende visibile il _setBox
}


/**
 * Chiusura del BOX Form
 */
function closeBox() {
  resetParamaters(); // Reset dei Parametri
  WPackage_form._remove(); // Rimuove il setBox
  _setBox.style.display = "none"; // Rende invisibile il _setBox
}

/**
 * Modifica il campo
 * nella cornice anteprima
 */
function updateElement(id, type) {
  var metadato = document.querySelector(".wrapElem[meta='" + id + "']");
  var e = metadato.querySelector('.elem');

  if (objectInput["placeholder"] == true) {
    if (e.contains(e.querySelector('p')))
      metadato.querySelector('.elem p').remove();
  } else if (!e.contains(e.querySelector('p'))) {
    if (!e.querySelector('input[type=submit]')) {
      var p = document.createElement('P');
      var txt = document.createTextNode(objectInput.title);
      p.appendChild(txt);
      e.appendChild(p);
    }
  } else {
    metadato.querySelector('.elem p').textContent = objectInput.title;
  }

  switch (type) {
    case 'select':
      metadato.querySelector('.elem select').remove();
      break;
    case 'radio':
      metadato.querySelector('.elem .radio').remove();
      break;
    case 'checkbox':
      metadato.querySelector('.elem .checkbox').remove();
      break;
    default:
      metadato.querySelector('.elem input').remove();
      break;
  }
  
  e.appendChild(HTMLCode);
  closeBox(); // Chiusura del box
}


/**
 * Aggiunge il campo compilato
 * nella cornice in anteprima
 */
function addElement(){

  var _Result_Html = MB();

  _pageForm.innerHTML += _Result_Html.outerHTML;

  dragDrop();

  closeBox(); // Chiusura del box
}