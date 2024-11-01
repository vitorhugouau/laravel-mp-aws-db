<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/biblioteca/type.css">
    <title>Document</title>

</head>

@include('partials.nav')

<body background="../../assets/img/rio.jpg">

    
    <style>
        * {
            user-select: none;
        }

        .compra {
            left: 20px;
            align-items: center;
            justify-content: center;
            display: flex;
            /* gap: 15px; */
            padding: 10px;
        }

        #boton {
            background-color: rgb(243, 0, 0);
            color: rgb(255, 255, 255);
            border: 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
            font-size: 14px;
            width: 150px;
            height: 20px;
            left: 20px;
            align-items: center;
            justify-content: center;
            display: flex;

        }

        #boton:hover {
            transform: scale(1.3);
        }
    </style>
    <div class="container">
        <h1 class="heading">BIBLIOTECA DE FOTOS</h1>
        <br><br>

        <div class="container-image">
            @foreach ($imagens as $imagem)
                <div style="background-image: url('data:image/jpeg;base64,{{ $imagem->imagem }}'); background-size: cover; background-position: center; width: auto; height: 300px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important"
                    class="image" data-title="{{ $imagem->nome }}">
                    <!-- <img src="data:image/jpeg;base64,{{ $imagem->imagem }}" alt="{{ $imagem->nome }}" oncontextmenu="bloquearBotaoDireito(event)"> -->
                    <img id="{{ $imagem->id }}" class="imagemaaa" src="{{ asset("assets/image.png") }}"
                        style="height: auto !important; width: 60% !important; opacity: 0.6 !important; user-select: none">
                    <div
                        style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: white; width: 100%; border-radius: 0 0 52% 5%;">
                        {{-- <h3>{{ $imagem->nome }}</h3> --}}
                        <div class="compra">
                            <form action="/pagamento/{{ $imagem->id }}" method="GET">
                                @csrf <!-- Token de segurança necessário em formulários POST no Laravel -->
                                <button type="submit" id="boton">COMPRAR IMAGEM</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>


        const buyImage = (id) => {
            const imagemComprada = document.getElementById(id);
            imagemComprada.style.display = 'none';
        };

    </script>
    <script>
        document.addEventListener('keydown',
            function (e) {
                if (e.key === "F12" || (e.ctrlKey &&
                    e.shiftKey && e.key === 'I')) {
                    e.preventDefault();
                }
            }
        );

        document.addEventListener('contextmenu',
            function (e) {
                e.preventDefault();
            }
        );
    </script>

    <script>
        document.getElementById('sair').addEventListener('click', function () {
            document.getElementById('logout-form').submit();
        });
        function bloquearBotaoDireito(event) {
            event.preventDefault();
        }
    </script>


</body>

</html>