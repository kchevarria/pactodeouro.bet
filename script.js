$(document).ready(function () {
  listarPlataformas();
});

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
    },
    error: function (xhr, status, error) {
      console.error("Erro AJAX:", xhr.responseText || error);
    }
  });
}
