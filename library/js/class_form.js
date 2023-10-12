/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Class Form 
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

/**
 * 
 * Classe per la 
 * creazione degli Input
 */

var _xyz = document.querySelector('section.setInput');
var _abc, wrap, miniwrap, paragrafo, testo, input, span, label;

var masterpiece = document.querySelector('.originalForm');



/**
 * Memorizzazione Variabili di inclusione
 */
var HTMLCode, SHORTCode; 

var objectInput = {
  title: "M",
  type : "M",
  name : "M",
  value : "M",
  list: [],
  placeholder : false,
  required : false
};

var tempObjectInput = objectInput;

/**
 * 
 * Classe per la 
 * creazione dei Shortcode
 */

class _Shortcode{

  constructor() {}

  //Method
  _shortcode(input, arrayObject){

    if(arrayObject.length != 0){
      input.value = this._createJSON(arrayObject);
      return true;
    }else{
      return false;
    }
  }


  _createJSON(array) {

    var shortCode = "";

    for (let index = 0; index < array.length; index++) {

      // var t = array[index].type;

        shortCode += "&" + JSON.stringify(array[index]);

    }

    return shortCode;

  }

  _compiler(txt){
    var aJson = txt.split('&');


    var objectArray = [];
    var a = 0;
    for (let index = 1; index < aJson.length; index++) {
      var obj = aJson[index].replace(/\/+$/, '');
      objectArray[a] = JSON.parse(obj);
      a++;
    }

    
    for (let p = 0; p < objectArray.length; p++) {

      WPackage_form._form(objectArray[p].type);
      objectInput = objectArray[p];
      openBox();
      WPackage_form._upgrade();
      this._searchInput_reference();
      addElement();

    }

  }

}


/**
 * 
 * Classe per la 
 * creazione degli Input
 */

class _Input extends _Shortcode {

  constructor() {
    super(); // chiama il costruttore genitore
  }

  //Method

  /**
   * Attribuisce i 
   * parametri al Tag creato
   * 
   * @param {Nome del tag} tag 
   * @param {Nome dell'attributo} name 
   * @param {Proprietà dell'attributo} property 
   * @returns 
   */
  _setting(tag, name, property) {
    return tag.setAttribute(name, property);
  }


  /**
   * Crea il Settaggio per 
   * il tipo di input che viene creato
   * 
   * @param {Tipo di Input} elem 
   * @returns 
   */
  _type(elem){

    switch (elem) {
      case 'text':
        return this._create(['title', 'name', 'value', 'placeholder', 'required']);
        break;
      case 'number':
        return this._create(['title', 'name', 'value', 'minMax']);
        break;
      case 'tel':
        return this._create(['title', 'name', 'placeholder', 'required']);
        break;
      case 'submit':
        return this._create(['name', 'value']);
        break;
      case 'checkbox':
        return this._create(['title', 'name', 'option']);
        break;
      case 'radio':
        return this._create(['title', 'name', 'option', 'required']);
        break;
      case 'select':
        return this._create(['title', 'name', 'option', 'required']);
        break;
      case 'date':
        return this._create(['title', 'name', 'required']);
        break;
      case 'email':
        return this._create(['title', 'name', 'placeholder', 'required']);
        break;
      case 'file':
        return this._create(['title', 'name', 'option', 'required']);
        break;
      default:
        break;
    }

    return;
  }


  /**
   * Impostazione del valore
   * Minimo e Massimo
   * nell'input NUMBER
   * 
   * @param {Titolo} name 
   * @param {Parametro name} param 
   * @param {Testo paragrafo} txt 
   * @returns 
   */

  _minMax(name, param, txt){

    wrap = document.createElement('DIV');
    this._setting(wrap, 'class', 'inline');

    miniwrap = document.createElement('DIV');

    paragrafo = document.createElement('P');
    testo = document.createTextNode(name);
    paragrafo.appendChild(testo);

    span = document.createElement('SPAN');
    span.style.color = "#fff";
    label = document.createTextNode(txt);
    span.appendChild(label);

    miniwrap.appendChild(paragrafo);
    miniwrap.appendChild(span);


    wrap.appendChild(miniwrap);

    var _miniwrap = document.createElement('DIV');
    this._setting(_miniwrap, 'class', 'minMax');

    var label_1 = document.createElement('LABEL');
    var label_txt = document.createTextNode('Min');
    label_1.appendChild(label_txt);

    input = document.createElement('INPUT');
    this._setting(input, 'class', 'metadata');
    this._setting(input, 'type', 'number');
    this._setting(input, 'name', param[0]);

    var label_2 = document.createElement('LABEL');
    var label_txt_2 = document.createTextNode('Max');
    label_2.appendChild(label_txt_2);


    var _input = document.createElement('INPUT');
    this._setting(_input, 'class', 'metadata');
    this._setting(_input, 'type', 'number');
    this._setting(_input, 'name', param[1]);


    _miniwrap.appendChild(label_1);
    _miniwrap.appendChild(input);
    _miniwrap.appendChild(label_2);
    _miniwrap.appendChild(_input);
    wrap.appendChild(_miniwrap);

    return wrap;

  }


/**
 * Creazione della Selezione
 * delle varie Opzioni
 * in formato Multiplo
 * 
 * @param {Titolo} name 
 * @param {Parametro name} param 
 * @param {testo Paragrafo} txt 
 * @returns 
 */
  _option(name, param, txt){

    wrap = document.createElement('DIV');
    this._setting(wrap, 'class', 'inline');

    miniwrap = document.createElement('DIV');

    paragrafo = document.createElement('P');
    testo = document.createTextNode(name);
    paragrafo.appendChild(testo);

    span = document.createElement('SPAN');
    span.style.color = "#fff";
    label = document.createTextNode(txt);
    span.appendChild(label);

    miniwrap.appendChild(paragrafo);
    miniwrap.appendChild(span);

    wrap.appendChild(miniwrap);

    input = document.createElement('TEXTAREA');
    this._setting(input, 'class', 'metadata');
    this._setting(input, 'cols', '30');
    this._setting(input, 'name', param);
    this._setting(input, 'rows', "10");

    wrap.appendChild(input);

    return wrap;

  }


  /**
   * Creazione della Selezione
   * delle varie Opzioni 
   * in formato RADIO
   * 
   * @param {Titolo} name 
   * @param {Parametro name} param 
   * @param {Testo Paragrafo} txt 
   * @param {Valore di settaggio} value 
   * @returns 
   */
  _check(name, param, txt, value){

    wrap = document.createElement('DIV');
    this._setting(wrap, 'class', 'inline');

    miniwrap = document.createElement('DIV');

    paragrafo = document.createElement('P');
    testo = document.createTextNode(name);
    paragrafo.appendChild(testo);

    span = document.createElement('SPAN');
    span.style.color = "#fff";
    label = document.createTextNode(txt);
    span.appendChild(label);

    miniwrap.appendChild(paragrafo);
    miniwrap.appendChild(span);
    

    wrap.appendChild(miniwrap);
    

    input = document.createElement('INPUT');
    this._setting(input, 'class', 'metadata');
    this._setting(input, 'type', 'checkbox');
    this._setting(input, 'name', param);
    this._setting(input, 'value', value);

    wrap.appendChild(input);

    return wrap;

  }

  /**
   * Creazione del campo Testo
   * 
   * @param {Titolo} name 
   * @param {Parametro name} param 
   * @returns 
   */
  _text(name, param){

    wrap = document.createElement('DIV');
    this._setting(wrap, 'class', 'inline');

    paragrafo = document.createElement('P');
    testo = document.createTextNode(name);
    paragrafo.appendChild(testo);

    wrap.appendChild(paragrafo);

    input = document.createElement('INPUT');
    this._setting(input, 'class', 'metadata');
    this._setting(input, 'type', 'text');
    this._setting(input, 'name', param);
    this._setting(input, 'required', '');

    wrap.appendChild(input);

    return wrap;

  }


  /**
   * Inserisce gli elementi 
   * per l'impostazione del'input
   * 
   * @param {Elenco dei Campi delle impostazioni} array 
   */
  _create(array){
    
    for (let index = 0; index <= array.length-1; index++) {

      switch (array[index]) {
        case 'title':
          _abc.appendChild(this._text('Titolo', 'title'));
          break;
        case 'name':
          _abc.appendChild(this._text('Nominativo', 'name'));
          break;
        case 'value':
          _abc.appendChild(this._text('Valore', 'value'));
          break;
        case 'placeholder':
          _abc.appendChild(this._check('Segnaposto', 'placeholder', 'Vuoi che il titolo diventi il segnaposto?', 1));
          break;
        case 'required':
          _abc.appendChild(this._check('Campo Obbligatorio', 'required', 'Vuoi che il campo sia obbligatorio?', 1));
          break;
        case 'minMax':
          _abc.appendChild(this._minMax('Minimo e Massimo', ['min', 'max'], 'Scegli un Minimo e un Massimo'));
          break;
        case 'option':
          _abc.appendChild(this._option('Inserisci le opzioni', 'list', 'Scrivi un\'opzione per riga'));
          break;
        default:
          break;
      }

    }

  }


  _createHTMLCode(parameter){

    var result = document.getElementById('result');

    if(result != null){

      switch (objectInput.type) {
        case 'select':
          HTMLCode = document.createElement('SELECT');
          this._assignItems(parameter, false, objectInput.type);
          break;
        case 'file':
          HTMLCode = document.createElement('INPUT');
          this._assignItems(parameter, true, objectInput.type);
          break;
        case 'radio':
          HTMLCode = document.createElement('DIV');
          this._setting(HTMLCode, 'class', objectInput.type);
          for (let c = 0; c < objectInput.list.length; c++) {

            var span = document.createElement('SPAN');
            var lb = document.createElement('LABEL');
            lb.innerHTML = objectInput.list[c];
            var opt = document.createElement('INPUT');
            this._setting(opt, 'type', objectInput.type);
            this._setting(opt, 'name', objectInput.name);
            this._setting(opt, 'value', objectInput.list[c]);
            HTMLCode.appendChild(span);
            span.appendChild(opt);
            span.appendChild(lb);
          }
          break;
        case 'checkbox':
          HTMLCode = document.createElement('DIV');
          this._setting(HTMLCode, 'class', objectInput.type);
          for (let c = 0; c < objectInput.list.length; c++) {

            var span = document.createElement('SPAN');
            var lb = document.createElement('LABEL');
            lb.innerHTML = objectInput.list[c];
            var opt = document.createElement('INPUT');
            this._setting(opt, 'type', objectInput.type);
            this._setting(opt, 'name', objectInput.name);
            this._setting(opt, 'value', objectInput.list[c]);
            HTMLCode.appendChild(span);
            span.appendChild(opt);
            span.appendChild(lb);
          }
          break;
        case 'number':
          
        default:
          HTMLCode = document.createElement('INPUT');
          this._assignItems(parameter, true);
          break;
      }

      return result.value = HTMLCode.outerHTML;

    }
    
    return('Campo HTMLCode Nullo');

  }


  _assignItems(parameter, bool, type){

    for (const [key] of Object.entries(parameter)) {

      switch (`${key}`) {
        case 'type':
          if(bool) this._setting(HTMLCode, 'type', objectInput.type);
          break;
        case 'name':
          this._setting(HTMLCode, 'name', objectInput.name);
          break;
        case 'value':
          if (bool) this._setting(HTMLCode, 'value', objectInput.value);
          break;
        case 'placeholder':
          if (objectInput.placeholder)
            this._setting(HTMLCode, 'placeholder', objectInput.title);
          break;
        case 'required':
          if (objectInput.required)
            this._setting(HTMLCode, 'required', '');
          break;
        case 'list':
          if (objectInput.list.length > 0) {
            switch (type) {
              case 'select':
                for (let c = 0; c < objectInput.list.length; c++) {

                  var opt = document.createElement('OPTION');
                  this._setting(opt, 'value', objectInput.list[c]);
                  opt.innerHTML = objectInput.list[c];

                  HTMLCode.appendChild(opt);
                }
                break;
              case 'file':
                this._setting(HTMLCode, 'accept', objectInput.list);
                break;
              default:
                break;
            }
          }
          break;
        default:
          break;
      }

    }

  }


  _searchInput_reference(){
    var inputs = _abc.querySelectorAll('.inline .metadata');
    var _key = Object.keys(objectInput);

    var int = 0;

    while (int < inputs.length) {

        for (let w = 0; w < Object.entries(objectInput).length; w++) {

          if(inputs[int].name == _key[w]){
            if(inputs[int].value == 1){
              if(inputs[int].name == "placeholder" && inputs[int].checked){
                objectInput[_key[w]] = true;
              } else if (inputs[int].name == "required" && inputs[int].checked) {
                objectInput[_key[w]] = true;
              }else{
                objectInput[_key[w]] = false;
              }
              // break;
            }else{
              if (inputs[int].name == "list"){
                objectInput[_key[w]] = inputs[int].value.split("\n");
                break;
              }
              objectInput[_key[w]] = inputs[int].value;
            }
          }
        }
      int++;
    }
  
  this._createHTMLCode(objectInput);

  }


  _upgrade() {

    var _metadata = document.querySelectorAll('.inline .metadata');
    var _key = Object.keys(objectInput);

    for (let d = 0; d < _metadata.length; d++) {
      for (let c = 0; c < _key.length; c++) {
        if (_metadata[d].name == _key[c]) {

          if (_metadata[d].name == "placeholder") {
            if (objectInput[_key[c]]) _metadata[d].checked = true;
            _metadata[d].value = 1;
            break;
          }

          if (_metadata[d].name == "required") {
            if (objectInput[_key[c]]) _metadata[d].checked = true;
            _metadata[d].value = 1;
            break;
          }

          if (_metadata[d].name == "list") {
            var s = "";
            
            for (var b = 0; b < objectInput[_key[c]].length; b++) {
              if (b != (objectInput[_key[c]].length - 1)){
                s += objectInput[_key[c]][b] + "\n";
              }else{
                s += objectInput[_key[c]][b];
              }
            }

            _metadata[d].value = s;
            break;
          }

          _metadata[d].value = objectInput[_key[c]];
          break;
        }

      }
    }
  }


}

/**
 * 
 * Classe per la 
 * creazione del Form
 */

class _Form extends _Input{

  constructor() {
    super(); // chiama il costruttore genitore
  }

  //Method ---------->

  /**
   * Tipo di settaggio basato 
   * sul tipo di input
   * 
   * @param {Tipo dell'input} type 
   * @returns 
   */

  _form(type) {

    if (_abc != undefined){
      this._remove();
    }

    typeField = type;

    var formSetInput = document.createElement('FORM');
    this._setting(formSetInput, 'id', 'formSetInput')
    _xyz.appendChild(formSetInput);

    _abc = document.querySelector('form#formSetInput');

    this._type(type);
    this._code();

    // Primo parametro
    objectInput.type = type;

    this._createHTMLCode(objectInput);

    return;


  }


  /**
   * Creazione della sezione
   * Codifica del codice per la
   * programmazione del Shortcode
   */

  _code(){

    var sectionCode = document.createElement('DIV');
    this._setting(sectionCode, 'class', 'sectionCode');

    var p1 = document.createElement('P');
    var p1_txt = document.createTextNode('HTML');
    p1.appendChild(p1_txt);

    var i1 = document.createElement('INPUT');
    this._setting(i1, 'type', 'text');
    this._setting(i1, 'name', 'result');
    this._setting(i1, 'id', 'result');
    this._setting(i1, 'readonly', 'readonly');

    var a = document.createElement("A");
    this._setting(a, "onclick", "addElement()");

    var a_txt = document.createTextNode('Inserisci');
    a.appendChild(a_txt);

    sectionCode.appendChild(p1);
    sectionCode.appendChild(i1);

    _abc.appendChild(sectionCode);
    _abc.appendChild(a);

  }

  /**
   * Rimuove il Form 
   * dell'impostazione
   * 
   * @returns 
   */
  _remove(){
    return _abc.remove();
  }

}


var WPackage_form = new _Form();