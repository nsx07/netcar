const copy = `Bem-vindo à Netcar! Nós somos uma loja de carros online com um ar jovem e moderno. Aqui, você encontra uma ampla seleção de veículos novos e seminovos a preços acessíveis e condições de pagamento que cabem no seu bolso. Nós nos preocupamos com a qualidade e a segurança dos veículos que vendemos, por isso trabalhamos apenas com marcas renomadas e veículos inspecionados. Navegue em nosso site e encontre o carro dos seus sonhos.`

document.addEventListener("DOMContentLoaded", $ => {
    new TypeIt("#netcar", {
        speed: 77,
        waitUntilVisible: true,
        afterComplete: function (instance) {
            instance.destroy();
          }
      }).type('', {delay: 1000}).go();

      setTimeout(() => {
        new TypeIt("#copy", {
            strings: copy,
            speed: 30,
            waitUntilVisible: true,
            afterComplete: function (instance) {
                instance.destroy();
              }
          }).go();
      }, 3000)


})