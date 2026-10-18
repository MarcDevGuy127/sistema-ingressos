document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll(".card");

    cards.forEach(function(card, index) {
        const botao = card.querySelector("button");
        const contador = card.querySelector(".contador");
        
        // chave única para cada card (ex: "lugares_card_0", "lugares_card_1", etc.)
        const chaveStorage = `lugares_card_${index}`;

        let valorAtual = localStorage.getItem(chaveStorage);
        
        if (valorAtual === null) {
            valorAtual = 45;
            localStorage.setItem(chaveStorage, valorAtual);
        } else {
            valorAtual = parseInt(valorAtual);
        }

        contador.innerHTML = valorAtual;


        botao.addEventListener("click", function() {
            if (valorAtual > 0) {
                valorAtual--;
                contador.innerHTML = valorAtual;

                localStorage.setItem(chaveStorage, valorAtual);
            }
        });
    });
});