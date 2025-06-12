$(document).ready(function () {
  listarPlataformas();
  $("#termos").modal("show");
});

function listarPlataformas() {
  $.ajax({
    url: "controller/backend.php",
    type: 'POST',
    data: {
      action: 'listarPlataformas'
    },
    dataType: 'json',
    success: function (plataformas) {
      console.log(plataformas);
      // Agrupar por top baseado na ordem
      const grupos = {};

      plataformas.forEach(p => {
        // Define o grupo top: arredonda a ordem para cima na dezena mais próxima
        // Exemplo: ordem 1-10 => 10, 11-20 => 20, 21-30 => 30
        const grupo = Math.ceil(p.ordem / 10) * 10;

        if (!grupos[grupo]) {
          grupos[grupo] = [];
        }
        grupos[grupo].push(p);
      });

      // Agora monta o HTML para cada grupo
      let htmlCompleto = '';

      Object.keys(grupos).sort((a,b) => a-b).forEach(grupo => {
        htmlCompleto += `
        <section class="top-section mb-5" id="top${grupo}">
          <p class="card h1 text-center fw-bold">TOP ${grupo}</p>
          <div class="icon-scroll-wrapper d-flex">
        `;

        grupos[grupo].forEach(p => {
          htmlCompleto += `
            <div class="col-custom-5">
              <a href="${p.link}" target="_blank" class="link card text-center">
                <img src="./images/${p.logo}" alt="${p.nome}">
              </a>
            </div>
          `;
        });

        htmlCompleto += `
            </div>
          </section>
        `;
      });

      // Insere o conteúdo na div/container que desejar
      $('#containerPlataformas').html(htmlCompleto);
      console.log(htmlCompleto);
    },
    error: function (xhr, status, error) {
      console.error("Erro AJAX:", xhr.responseText || error);
    }
  });
}

