window.addEventListener("load", () => {
let date = new Date();
let hours = date.getHours();
let name = $("#inicioMedico h1").text();

if(hours >= 6 && hours < 12) {
    $("#inicioMedico h1").text("Bom dia, Dr. " + name + " 👋");
}else if (hours >= 12 && hours < 18) {
    $("#inicioMedico h1").text("Boa tarde, Dr. " + name + " 👋");
}else {
    $("#inicioMedico h1").text("Boa noite, Dr. " + name + " 👋");
}
});

$(".consultasContainer span").addClass("status");

$('.status:contains("aguardando")').addClass('aguardandoSpan');
$('.status:contains("recusado")').addClass('recusadoSpan');
$('.status:contains("confirmado")').addClass('confirmadoSpan');

$(".editConsultaStatusBtn").on("click", function (event) {
  let clickedElement = $(event.currentTarget);
  const $row = $(this).closest("tr");
  const $status = $row.find(".status").text().trim();
  console.log($status);
  switch ($status) {
    case "recusado":
        clickedElement.toggleClass("hide");
        clickedElement.siblings(".editConsultaConfirmarBtn").toggleClass("hide");
        clickedElement.siblings(".voltarStatusBtn").toggleClass("hide");
      break;
    
    case "confirmado":
        clickedElement.toggleClass("hide");
        clickedElement.siblings(".editConsultaRecusarBtn").toggleClass("hide");
        clickedElement.siblings(".voltarStatusBtn").toggleClass("hide");
    break;

    case "aguardando":
        clickedElement.toggleClass("hide");
        clickedElement.siblings(".editConsultaRecusarBtn").toggleClass("hide");
        clickedElement.siblings(".editConsultaConfirmarBtn").toggleClass("hide");
        clickedElement.siblings(".voltarStatusBtn").toggleClass("hide");
    default:
      break;
  }
  
});

$(".voltarStatusBtn").on("click", function (event) {
  let clickedElement = $(event.currentTarget);
  clickedElement.toggleClass("hide");
  $(this).siblings(".editConsultaStatusBtn").toggleClass("hide");
  clickedElement.siblings(".editConsultaConfirmarBtn").addClass("hide");
  clickedElement.siblings(".editConsultaRecusarBtn").addClass("hide");

});

$('.linkPage').on('click', (event) => {
    
  $(".hideableDiv").removeClass("hide");
  $("#pedidosMedicos, #agendarExames, #agendarVacina, #acessosMedicos, #agendarEspecialidade, #consultaOnline").remove();

});

$('.cardContainer').on('click', (event) => {
  var button = event.currentTarget;
    $('.hideableDiv').addClass("hide");
    $(".dynamicSection").removeClass("hide");
    
  switch (true) {
    case $(button).hasClass('pedidosMedicos'):
       
        $(".dynamicSection").append(`
            <div id="pedidosMedicos">
                <button type=button class="backToInicio">
                  <i class="bi bi-arrow-left-circle"></i>
                </button>
                <h1>Pedidos Médicos</h1>
                <div class="alterPacientContainer">
                    <button type="button" id="alterPacientBtn4" class="alterPacientBtn">
                        <strong>Nome</strong>
                        <span>• Alterar</span>
                        <i class="fa-solid fa-angle-down"></i>
                    </button>
                    <div class="pacienteContainer">
                        <h3>Selecione um paciente</h3>
                        <div class="paciente">
                            <strong>Nome Completo</strong>
                            <span>Você, idade</span>
                        </div>
                        <button type="button" class="dependenteBtn">
                            <span>+Cadastrar paciente</span>
                        </button>
                    </div>
                </div>

                <div class="centralizado pedidosMedicosText">
                    <h2>Nenhum pedido médico encontrado</h2>
                    <p>No momento, você não tem pedidos médicos disponíveis.</p>
                </div>
                
            </div>`);
          
        $('.toggleableDiv').removeClass("hide");  
      break;
      case $(button).hasClass('agendarExames'):
        $(".dynamicSection").append(`
          <div id="agendarExames">
            <button type=button class="backToInicio">
              <i class="bi bi-arrow-left-circle"></i>
            </button>
            <h1 class="naoCentralizado">Escolha o Paciente</h1>
            <button type="button" class="pacienteBox">
              <h3>Nome do paciente</h3>
              <span>Você, idade</span>
              <div class="arrowRightIconContainer">
                <i class="fa-solid fa-angle-right"></i>
              </div>
            </button>
            <button class="addPacienteContainer">
              <i class="bi bi-plus-lg"></i>
              <span>Adicionar Paciente</span>
            </button>
          </div>
          
          `);
         $('.toggleableDiv').removeClass("hide"); 

      break;

      case $(button).hasClass('agendarVacina'):
      $(".dynamicSection").append(`
        <div id="agendarVacina">
          <button type=button class="backToInicio">
            <i class="bi bi-arrow-left-circle"></i>
          </button>
          <h1 class="naoCentralizado">Escolha o Paciente</h1>
          <button type="button" class="pacienteBox">
            <h3>Nome do paciente</h3>
            <span>Você, idade</span>
            <div class="arrowRightIconContainer">
              <i class="fa-solid fa-angle-right"></i>
            </div>
          </button>
        <button class="addPacienteContainer">
          <i class="bi bi-plus-lg"></i>
          <span>Adicionar Paciente</span>
        </button>
        </div>
      `);
      $('.toggleableDiv').removeClass("hide"); 
      
      break;

      case $(button).hasClass('acessosMedicos'): 
      $(".dynamicSection").append(`
        <div id="acessosMedicos">
          <button type=button class="backToInicio">
            <i class="bi bi-arrow-left-circle"></i>
          </button>
          <div class="centralizado">
            <h2>Gerenciamento de autorizações</h2>
            <p>Aqui você pode gerenciar e autorizar acesso do seu histórico completo de exames a profissionais de saúde da sua escolha.</p>
            <button type="button" class="historyAcess">
              <span>Autorizar acesso ao histórico</span>
            </button>
          </div>
        </div>
      
      `);
      $('.toggleableDiv').removeClass("hide"); 
      break;

      case $(button).hasClass('consultas_prescricoes_atestados'):
        window.location.replace('./pages/consultas.html');
      break; 
      
      case $(button).hasClass('agendarConsultas'):
        window.location.replace('./pages/consultas.html');
      break;

      case $(button).hasClass('resultado_de_exames'):
        window.location.replace('./pages/exames.html');
      break;

      case $(button).hasClass('agendarEspecialidade'):
        $(".dynamicSection").append(`
          <div id="agendarEspecialidade" class="agendarEspecialidadeContainer">
            <div class="topContent">
              <button type=button class="backToInicio">
                <i class="bi bi-arrow-left-circle"></i>
              </button>
              <h1>Agendar consulta</h1>
            </div>
            <p>Por aqui, vou te ajudar a encontrar os melhores especialistas</p>
            <h2>Para quem será o atendimento?</h2>
            <button type="button" class="pacienteBox">
              <h3>Nome do paciente</h3>
              <span>Você, idade</span>
              <div class="arrowRightIconContainer">
                <i class="fa-solid fa-angle-right"></i>
              </div>
            </button>
            <button class="addPacienteContainer">
              <i class="bi bi-plus-lg"></i>
              <span>Adicionar Paciente</span>
            </button>
          </div>  
        `); 
      break;

      case $(button).hasClass('consultaOnline'):
        $(".dynamicSection").append(`
          <div id="consultaOnline">
            <div class="topContent">
              <button type=button class="backToInicio">
                <i class="bi bi-arrow-left-circle"></i>
              </button>
              <h1>Tudo certo para consulta?</h1>
            </div>

            <span>Quem será consultado ?</span>
            <div class="alterPacientContainer">
              <button type="button" id="alterPacientBtn4" class="alterPacientBtn">
                <strong>Nome</strong>
                <span>• Alterar</span>
                <i class="fa-solid fa-angle-down"></i>
              </button>
              <div class="pacienteContainer">
                <h3>Selecione um paciente</h3>
                <div class="paciente">
                  <strong>Nome Completo</strong>
                  <span>Você, idade</span>
                </div>
                <button type="button" class="dependenteBtn">
                <span>+Cadastrar paciente</span>
                </button>
              </div>
            </div>

            <span>Como será o pagamento ?</span>
            <div class="pagamentoCardsContainer">
              <button type="button" class="pagamentoParticularCards">
                <span class="styledSpan">Particular</span>
                <strong>Cartão de crédito</strong>
                <span>Valor</span>
              </button>
              <button type="button" class="pagamentoPlanoCards">
                <i class="bi bi-plus"></i>
                <span>Adicionar plano <br> de saúde</span>
              </button>
            </div>
          </div>  
        `);

      case $(button).hasClass('compartilharExames'):
        $('.hideableDiv').removeClass("hide");
        $(".dynamicSection").addClass("hide");
      break;

      default:
        console.log("Botão não encontrado");
      break;
  }
  
});

$(document).on("click", ".backToInicio", () => {
  $("#pedidosMedicos, #agendarExames, #agendarVacina, #acessosMedicos, #agendarEspecialidade,#consultaOnline").remove();
  $("#linkInicio").click();
  $("section").removeClass("hide");
  $(".dynamicSection").addClass("hide");
});

$(document).on("click", ".alterPacientBtn", function() {
  const id = $(this).attr("id");

  $(this).toggleClass("showDropdown");
});

window.addEventListener("resize", () => {

if ($("#sidebar").is(":checked")  && window.innerWidth <= 980) {
    $("#sidebar").trigger("click");
}
});

  let baseFontSize = 25;   

  let maxIncrease = 5;     

  let currentIncrease = 0; 

function increaseFont() {
  if (currentIncrease < maxIncrease) {
    currentIncrease++;
    document.body.style.fontSize = (baseFontSize + currentIncrease) + "px";
    $("span:not(.h1Span)").css("font-size", (baseFontSize + currentIncrease) + "px");
    $("p").css("font-size", (baseFontSize + currentIncrease) + "px");
    $("a").css("font-size", (baseFontSize + currentIncrease) + "px");  
  }
  
}

function decreaseFont() {
  if (currentIncrease > -5) {
    currentIncrease--;
    document.body.style.fontSize = (baseFontSize + currentIncrease) + "px";
    $("span:not(.h1Span)").css("font-size", (baseFontSize + currentIncrease) + "px");
    $("p").css("font-size", (baseFontSize + currentIncrease) + "px");
    $("a").css("font-size", (baseFontSize + currentIncrease) + "px");
  }
}

let isDark = JSON.parse(localStorage.getItem("isDark")) || false;

if(isDark) {
  $('html').addClass("dark");
}

function darkMode () {
  if(isDark) {
    $('html').removeClass("dark");
    isDark = false;
  }else {
    $('html').addClass("dark");
    isDark = true;
  }
  localStorage.setItem("isDark", JSON.stringify(isDark));
}

$(".editBtn").on('click', function() {
  const container = $(this).closest('.dadosContainerContent');

  container.find('.inputsContainer').toggleClass('hide');
  container.find('.infoSpan').toggleClass('hide');

});

function consultarCep() {
    return new Promise((resolve) => {
        const cep = document.getElementById('cepcliente').value.replace(/\D/g, '');

        if (cep.length !== 8) {
            $("#cepSpan").text("CEP deve conter 8 dígitos !");
            resolve(false);
            return;
        }

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('ruacliente').value = data.logradouro;
                    document.getElementById('bairrocliente').value = data.bairro;
                    document.getElementById('cidadecliente').value = data.localidade;
                    document.getElementById('estadocliente').value = data.uf;
                    document.getElementById('complementocliente').value = data.complemento;
                    $("#cepSpan").text("");
                    resolve(true);
                } else {
                    $("#cepSpan").text('CEP não encontrado.');
                    resolve(false);
                }
            })
            .catch(error => {
                console.error('Erro ao consultar o CEP:', error);
                alert('Erro ao consultar o CEP.');
                resolve(false);
            });
    });
}

  function phoneMask(event) {
    let value = event.target.value;

    value = value.replace(/\D/g, "");

    if (value.length > 0) value = value.replace(/^(\d{0,2})/, "($1");
    if (value.length > 2) value = value.replace(/\((\d{2})/, "($1) ");
    if (value.length > 7) value = value.replace(/(\d{4,5})(\d{4})$/, "$1-$2");

    event.target.value = value;
}

function soLetras (event) {
    var value = event.target.value;

    value = value.replace(/[^A-Za-zÀ-ÖØ-öø-ÿ ]/g, "");
    
    event.target.value = value;

}

function cepMask(event) {
    let value = event.target.value;

    value = value.replace(/\D/g, "");

    if (value.length > 5) value = value.replace(/^(\d{5})(\d)/, "$1-$2");

    event.target.value = value;
}

$(document).ready(function(){
  $("#rg").inputmask("99.999.999-9");
  $("#telefone").inputmask("(99) 9999-99999");
});


$(".deletarContaBtn").on("click", () => {
  $(".deletarContaDiv").addClass("showDeletarDiv");
});

$(".naoDeletarContaBtn").on("click", () => {
  $(".deletarContaDiv").removeClass("showDeletarDiv");
});


$('.resultadosConsultas').each(function() {

    let status = $(this).find('.status').text().trim().toLowerCase();
    let irParaConsulta = $(this).find('.irParaConsultaForm');

    if (status === "confirmado") {

    // ✔ get hour from the CURRENT item, not from the entire document
    const consultaHora = $(this).find('.horaConsulta').text().trim();

    function toMinutes(hhmm) {
      const [h, m] = hhmm.split(":").map(Number);
      return h * 60 + m;
    }

    const now = new Date();
    const hour = String(now.getHours()).padStart(2, "0");
    const minute = String(now.getMinutes()).padStart(2, "0");
    const formattedTime = `${hour}:${minute}`;

    const diff = toMinutes(consultaHora) - toMinutes(formattedTime);
    
    const agora = new Date(); // Creates a Date object for the current date and time
    const dataAgora = agora.toLocaleDateString('pt-BR'); 
    console.log(dataAgora); 

    const dataConsulta = $(this).find('.dataConsulta').text().trim();
    console.log(dataConsulta);
    // Show button when 10 minutes before or during the time
    if (diff <= 10 && dataAgora === dataConsulta) { 
      irParaConsulta.removeClass('hide');
    }
  }/* else if (status === "finalizado") {
    statusBox.addClass('finalizadoSpan');
    compartilhar.removeClass('hide');
    mostrarResultados.removeClass('hide');
  } */

    
});
