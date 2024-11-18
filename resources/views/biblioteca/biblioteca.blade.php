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

    <div class="container">
        <h1 class="heading">BIBLIOTECA DE IMAGENS</h1>
        <br><br>

        <div class="container-image">
            @foreach ($urlMarcaDagua as $imagem)
                <div class="image" 
                    style="background-image: url('{{ $imagem->url_marca_dagua }}'); background-size: cover; background-position: center; width: auto; height: 300px; display: flex; align-items: center; justify-content: flex-end; flex-direction: column; user-select: none !important">
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
        function bloquearBotaoDireito(event) {
            event.preventDefault();
        }
    </script>


</body>

</html>