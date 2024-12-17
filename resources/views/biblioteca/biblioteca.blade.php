<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
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
                @foreach ($urlMarcaDaguaBanner as $imagem)
                    <div class="slide" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                        <a href="/pagamento/{{ $imagem->id }}" class="image-link"
                            style="display: block; width: 100%; height: 100%;"></a>
                    </div>
                @endforeach
            </div>
            <!-- Botões de navegação com imagens -->
            <button class="prev" onclick="moveSlide(-1)">
                <img src="{{ asset('assets/left.png') }}" class="icon-seta" alt="Previous" />
            </button>
            <button class="next" onclick="moveSlide(1)">
                <img src="{{ asset('assets/right.png') }}" class="icon-seta" alt="Next" />
            </button>
        </div>



        <div class="banner-container">
            <div class="container-image">
                @foreach ($urlMarcaDaguaMeio as $imagem)
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
    <div class="container-venda-wrapper">
        @foreach ($urlMarcaDaguaVenda as $imagem)
            <div class="container-venda">
                <!-- Desconto -->
                <div class="desconto">-11%</div>

                <!-- Imagem -->
                <div class="image-container-venda">
                    <div class="slide-venda" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                    </div>
                </div>

                <!-- Tags -->
                <div class="tags">
                    <div class="tag destaque">Destaque</div>
                    <div class="tag lancamento">Lançamento</div>
                    <div class="tag black-friday">Black Friday</div>
                </div>

                <!-- Título -->
                <div class="product-title">{{ $imagem->nome }}</div>

                <!-- Avaliação -->
                <div class="rating">★★★★★</div>

                <!-- Preço -->
                <div class="price">
                    <div class="old-price">R$280,00</div>
                    <div class="new-price">R$ {{ number_format($imagem->valor, 2, ',', '.') }}</div>
                </div>

                <!-- Parcelamento -->
                <div class="installments">
                    ou 10x de R$ {{ number_format($imagem->valor_parcelado, 2, ',', '.') }} sem juros no Cartão
                    Crédito.
                </div>

                <!-- Botão de Compra -->
                <a href="#" class="button">COMPRAR</a>
            </div>
        @endforeach
    </div>
    <div class="container">
        <div class="banner-container">
            <div class="container-image">
                @foreach ($urlMarcaDaguaFinal as $imagem)
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
        let currentIndex = 0;

        function moveSlide(direction) {
            const slides = document.querySelectorAll('.slide');
            const totalSlides = slides.length;

            currentIndex = (currentIndex + direction + totalSlides) % totalSlides;
            const newTransformValue = -currentIndex * 100;
            document.querySelector('.slider').style.transform = `translateX(${newTransformValue}%)`;
        }
    </script>


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
                    }, 3000); // Aguarda o término da transição antes de resetar
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
