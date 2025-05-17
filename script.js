$(document).ready(function () {
  // $("#termos").modal("show");
  listarPlataformas();
})

function discordar() {
  window.location.href = 'https://www.google.com';
}

function listarPlataformas() {
  console.log("listando");
  $.ajax({
    url: "controller/backend.php",
    type: 'POST',
    data: {
      action: 'listarPlataformas'
    },
    dataType: 'json',
    success: function (retorno) {
      console.log(retorno);
    }
  });
}