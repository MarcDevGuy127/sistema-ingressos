
const cards = document.querySelectorAll(".card");
const botaoReset = document.querySelector("#resetar");
const LIMITE_CLIQUES = 4;
const LUGARES_INICIAIS = 45;

cards.forEach((card, indice) => {
    const botao = card.querySelector("button");
    const contador = card.querySelector(".contador");
    const disponibilidade = card.querySelector(".disponibilidade");
    const chave = `ingresso_card_${indice}`;

    // recupera o estado salvo ou inicializa o card
    let estado = JSON.parse(localStorage.getItem(chave));

    if (!estado) {
        estado = {
            lugares: LUGARES_INICIAIS,
            cliques: 0
        };

        localStorage.setItem(chave, JSON.stringify(estado));
    }

    // restaura o estado do card
    contador.textContent = estado.lugares;
    botao.disabled = estado.cliques >= LIMITE_CLIQUES;

    disponibilidade.textContent =
        estado.cliques > 0 ? "Vendido" : "Livre";

    botao.addEventListener("click", () => {
        if (estado.cliques >= LIMITE_CLIQUES) {
            disponibilidade.textContent = "Limite alcançado";
            return;
        }

        estado.cliques++;
        estado.lugares = Math.max(0, estado.lugares - 1);

        // atualiza a interface
        contador.textContent = estado.lugares;
        disponibilidade.textContent = "Vendido";

        // desabilita o botão após quatro cliques
        if (estado.cliques >= LIMITE_CLIQUES) {
            botao.disabled = true;
            alert("Não é possível comprar mais de 4 ingressos!")
            disponibilidade.textContent = "Não é possível comprar!";
        }

        // persiste os dados
        localStorage.setItem(chave, JSON.stringify(estado));
    });
});

// reseta todos os contadores
botaoReset.addEventListener("click", () => {
    cards.forEach((card, indice) => {
        const botao = card.querySelector("button");
        const contador = card.querySelector(".contador");
        const disponibilidade = card.querySelector(".disponibilidade");
        const ingresso = card.querySelector(".ingresso");

        const estadoInicial = {
            lugares: LUGARES_INICIAIS,
            cliques: 0
        };

        // restaura os valores iniciais
        contador.textContent = LUGARES_INICIAIS;
        disponibilidade.textContent = "Livre";
        botao.disabled = false;

        if (ingresso) {
            ingresso.textContent = "";
        }

        // atualiza o armazenamento
        localStorage.setItem(
            `ingresso_card_${indice}`,
            JSON.stringify(estadoInicial)
        );
    });
});
