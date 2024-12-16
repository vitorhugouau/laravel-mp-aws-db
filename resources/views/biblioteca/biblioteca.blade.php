<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <title>Document</title>

</head>

@include('partials.teste-nav')

<!-- <body background="../../assets/img/rio.jpg"> -->

<body>
    <div class="container">
        <!-- <h1 class="heading">BIBLIOTECA DE IMAGENS</h1>
        <br><br> -->

        <!-- <div class="container-image">
            @foreach ($urlMarcaDagua as $imagem)
                <div class="image" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                    <div class="compra">
                        <form action="/pagamento/{{ $imagem->id }}" method="GET">
                            @csrf
                            <button type="submit" id="boton">COMPRAR IMAGEM</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div> -->
        <div class="banner-container-1">
            <div class="slider">
                @foreach ($urlMarcaDagua2 as $imagem)
                <div class="slide" style="background-image: url('{{ $imagem->url_marca_dagua }}');">

                </div>
                @endforeach
            </div>
        </div>

        <div class="banner-container">
            <div class="container-image">
                @foreach ($urlMarcaDagua as $imagem)
                <div class="image" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                    <div class="compra">
                        <form action="/pagamento/{{ $imagem->id }}" method="GET">
                            @csrf
                            <button type="submit" id="boton">COMPRAR IMAGEM</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.querySelector(".slider");
            const slides = document.querySelectorAll(".slide");
            let index = 0;

            // Clonar o primeiro slide e adicionar no final
            const firstSlide = slides[0].cloneNode(true);
            slider.appendChild(firstSlide);

            function moveSlider() {
                index++;
                slider.style.transition = "transform 1s ease-in-out";
                slider.style.transform = `translateX(-${index * 100}%)`;

                // Verificar se chegou ao último slide
                if (index === slides.length) {
                    setTimeout(() => {
                        slider.style.transition = "none";
                        slider.style.transform = "translateX(0)";
                        index = 0;
                    }, 2000); // Aguarda o término da transição antes de resetar
                }
            }

            setInterval(moveSlider, 3000);
        });
    </script>





    <script>
        const buyImage = (id) => {
            const imagemComprada = document.getElementById(id);
            imagemComprada.style.display = 'none';
        };
    </script>
    <script>
        document.addEventListener('keydown',
            function(e) {
                if (e.key === "F12" || (e.ctrlKey &&
                        e.shiftKey && e.key === 'I')) {
                    e.preventDefault();
                }
            }
        );

        document.addEventListener('contextmenu',
            function(e) {
                e.preventDefault();
            }
        );
    </script>

    <script>
        function bloquearBotaoDireito(event) {
            event.preventDefault();
        }
    </script>


</body>

</html>