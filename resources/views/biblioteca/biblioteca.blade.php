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

@include('partials.nav')

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
            <button class="prev" onclick="moveSlide(-1)">
                <img src="{{ asset('assets/left.png') }}" class="icon-seta" alt="Previous" />
            </button>
            <button class="next" onclick="moveSlide(1)">
                <img src="{{ asset('assets/right.png') }}" class="icon-seta" alt="Next" />
            </button>
        </div>
    </div>

    <div class="container-segundo">
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
        
                <div class="desconto">-11%</div>

                <div class="image-container-venda">
                    <div class="slide-venda" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                    </div>
                </div>

                <div class="tags">
                    <div class="tag destaque">Destaque</div>
                    <div class="tag lancamento">Lançamento</div>
                    <div class="tag black-friday">Exclusiva</div>
                </div>

                <div class="product-title">{{ $imagem->nome }}</div>

                <div class="rating">★★★★★</div>

                <div class="price">
                    <div class="old-price">R$ {{ number_format($discountValue->valores, 2, ',', '.') }}</div>
                    <div class="new-price">R$ {{ number_format($imagem->valor, 2, ',', '.') }}</div>
                </div>


                <div class="installments">
                    ou 10x de R$ {{ number_format($imagem->valor / 10, 2, ',', '.') }} sem juros no Cartão Crédito.
                </div>


                <form action="/pagamento/{{ $imagem->id }}" method="GET">
                    @csrf
                    <button type="submit" id="boton-loja"
                        style=" display: inline-block;
                                width: 90%;
                                margin: 15px auto;
                                padding: 10px 0;
                                background-color: #1f6d40;
                                color: #f5f5f5;
                                font-size: 14px;
                                font-weight: bold;
                                text-decoration: none;
                                border-radius: 5px;
                                cursor: pointer;
                                text-align: center;">COMPRAR</button>
                </form>
            </div>
        @endforeach
    </div>


    <div class="info-section">

        <div class="info-item">
            <img src="{{ asset('assets/guarantee.png') }}" alt="Garantia">
            <h3>Garantia</h3>
            <p>de até 1 ano da loja</p>
        </div>

        <div class="info-item">
            <img src="{{ asset('assets/discount.png') }}" alt="Desconto">
            <h3>5% de desconto</h3>
            <p>no pagamento à vista</p>
        </div>

        <div class="info-item">
            <img src="{{ asset('assets/credit-card.png') }}" alt="Parcelamento">
            <h3>Em até 6x</h3>
            <p>sem juros no cartão</p>
        </div>

        <div class="info-item">
            <img src="{{ asset('assets/camera.png') }}" alt="Parcelamento">
            <h3>Fotos exclusivas</h3>
            <p>imagens aéreas</p>
        </div>
    </div>
    <div class="container-baixo">
        <div class="banner-container">
            <div class="container-image">
                @foreach ($urlMarcaDaguaFinal as $imagem)
                    <div class="image" style="background-image: url('{{ $imagem->url_marca_dagua }}');">
                        <div class="compra">
                            <form action="/pagamento/{{ $imagem->id }}" method="GET">
                                @csrf
                                <input type="hidden" name="redirectTo" value="{{ url()->full() }}">
                                <button type="submit" id="boton">COMPRAR IMAGEM</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <footer class="footer">

        <div class="footer-logo">
            <img src="{{ asset('assets/vitorfilmes2.png') }}" alt="Logout" class="logo-footer">
        </div>
        <div class="footer-copyright">
            © 2024 Company, Inc
        </div>
    </footer>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.querySelector(".slider");
            const slides = document.querySelectorAll(".slide");
            let currentIndex = 0;
            let autoSlideInterval;

            const firstSlide = slides[0].cloneNode(true);
            slider.appendChild(firstSlide);

            const totalSlides = slides.length;

            function moveSlide(direction) {

                currentIndex = (currentIndex + direction + totalSlides) % totalSlides;

                slider.style.transition = "transform 1s ease-in-out";
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;

                if (currentIndex === totalSlides) {
                    setTimeout(() => {
                        slider.style.transition = "none";
                        slider.style.transform = "translateX(0)";
                        currentIndex = 0;
                    }, 1000);
                }

                resetAutoSlide();
            }

            function autoSlide() {
                moveSlide(1);
            }

            function resetAutoSlide() {
                clearInterval(autoSlideInterval);
                autoSlideInterval = setInterval(autoSlide, 4000);
            }

            autoSlideInterval = setInterval(autoSlide, 4000);

            window.moveSlide = moveSlide;
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
