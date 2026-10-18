document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll(".card");

    cards.forEach(function(card, index) {
        const botao = card.querySelector("button");
        const contador = card.querySelector(".contador");

        const disponibilidade = card.querySelector(".disponibilidade");
        
        // chave única para cada card (ex: "lugares_card_0", "lugares_card_1", etc.)
        const chaveStorage = `lugares_card_${index}`;

        let valor = localStorage.getItem(chaveStorage);
        
        if (valor === null) {
            valor = 45;
            localStorage.setItem(chaveStorage, valor);
        } else {
            valor = parseInt(valor);
        }

        if (valor === 0) {
            disponibilidade.id = "ocupado";      // Muda o ID do elemento para 'ocupado'
            disponibilidade.innerHTML = "Esgotado"; // Atualiza o texto para o usuário
            botao.disabled = true;               // Opcional: desativa o botão de compra
        }

        contador.innerHTML = valor;


        botao.addEventListener("click", function() {
            if (valor > 0) {
                valor--;
                contador.innerHTML = valor;

                localStorage.setItem(chaveStorage, valor);

                if (valor === 0) {
                    disponibilidade.id = "ocupado";      // Muda o ID do <p> para 'ocupado'
                    disponibilidade.innerHTML = "Esgotado"; // Altera o texto exibido
                    botao.disabled = true;               // Desativa o botão para evitar cliques extras
                }
            }
        });
    });
});