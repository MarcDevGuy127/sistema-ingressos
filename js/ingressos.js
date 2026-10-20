document.addEventListener("DOMContentLoaded", function () {
    const cards = document.querySelectorAll(".card");

    cards.forEach(function (card, index) {
        const botao = card.querySelector("button");
        const contador = card.querySelector(".contador");
        const disponibilidade = card.querySelector(".disponibilidade");

        let valorAtual = 45;

        if (valorAtual === null) {
            valorAtual = 45;
        } else {
            valorAtual = parseInt(valorAtual);
        }

        if (valorAtual === 0) {
            disponibilidade.id = "ocupado";      // Muda o ID do elemento para 'ocupado'
            disponibilidade.innerHTML = "Esgotado"; // Atualiza o texto para o usuário
            botao.disabled = true;               // Opcional: desativa o botão de compra
        }

        contador.innerHTML = valorAtual;

        botao.addEventListener("click", function () {
            if (valorAtual > 0) {
                valorAtual--;
                contador.innerHTML = valorAtual;

                if (valorAtual === 0) {
                    disponibilidade.id = "ocupado";      // Muda o ID do elemento para 'ocupado'
                    disponibilidade.innerHTML = "Esgotado"; // Atualiza o texto para o usuário
                    botao.disabled = true;               // Opcional: desativa o botão de compra

                    alert("Compra indisponível. Todo os ingressos foram vendidos!");
                }
            }
        });
    });
});