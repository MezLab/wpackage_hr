/**
 * Plugin Name:       WPackage HR
 * Plugin URI:        https://developer.unsocials.com/
 * Description:       Send Form Compilate
 * Version:           1.0
 * Author:            Mez
 */

/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */

var mailObject = [];

var _BoxCheck_ = {
  title: "",
  type: "",
  name: "",
  value: "[ "
}

function request(title, type, name, value){
  this.title = title,
  this.type = type;
  this.name = name,
  this.value = value
}

async function sendForm(id, path, dir){
  
  var form = document.querySelector(".WPackage_HR_Module");
  var formData = new FormData(form);
  formData.append("id", id);
  formData.append("dir", dir);

  var msgResponse = document.querySelector('#response');
  msgResponse.style.padding = "20px";
  msgResponse.style.color = "#fff";
  msgResponse.style.fontSize = "20px";
  msgResponse.style.fontWeight = "700";
  msgResponse.style.backgroundColor = "#393939";
  msgResponse.innerHTML = "Stiamo processando l'invio...";


  await fetch(
    path, 
    {
      method: "POST",
      body: formData,
    }

  )
  .then(response => {
    if(response.status == 404){
      msgResponse.style.backgroundColor = "#922E22";
      msgResponse.innerHTML = "La richiesta è stata respinta. Riprova più tardi";
    } else if (response.status == 200){
      form.reset();
      msgResponse.style.backgroundColor = "#2bb73a";
      msgResponse.innerHTML = "Invio avvenuto con successo.";
    }
  })
  .catch(error => {
    msgResponse.style.backgroundColor = "#922E22";
    msgResponse.innerHTML = error;
  });
}
