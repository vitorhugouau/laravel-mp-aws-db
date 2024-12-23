<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    @include('partials.nav')
    <br><br><br><br><br>
    <style>
        /* Estilos gerais da página */


/* Estilos do container principal */

/* Títulos principais e subtítulos */
h1 {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 20px;
}

h2 {
    font-size: 26px;
    font-weight: 600;
    color: #007bff;
    margin-top: 20px;
    margin-bottom: 10px;
    font-family: "Montserrat", sans-serif;
    font-optical-sizing: auto;
    font-style: normal;
}


    </style>
<br>
    <div class="container">
        <h1>Licença de Uso das Imagens</h1>

        <p>Ao adquirir uma foto em nosso site, você está concordando com as condições de uso descritas abaixo.</p>

        <h2>1. Licença Padrão</h2>
        <p>As fotos adquiridas em nosso site são licenciadas para uso pessoal e comercial, de acordo com as condições a seguir:</p>
        
        <ul>
            <li><strong>Uso Pessoal:</strong> Você pode usar as imagens adquiridas para fins pessoais, como decoração, presentes, ou uso em projetos não comerciais.</li>
            <li><strong>Uso Comercial:</strong> Você pode usar as imagens adquiridas em campanhas publicitárias, websites, blogs e outros materiais comerciais. A venda ou redistribuição das imagens em sua forma original é proibida.</li>
            <li><strong>Modificações:</strong> Você pode editar, redimensionar ou modificar as imagens para atender às suas necessidades, desde que o uso final respeite as condições de uso comercial e pessoal.</li>
        </ul>

        <h2>2. Restrições</h2>
        <p>Embora a licença permita o uso das imagens em várias formas, algumas restrições se aplicam:</p>
        
        <ul>
            <li><strong>Redistribuição:</strong> Não é permitido redistribuir as imagens como elas são adquiridas, seja de forma gratuita ou vendida, sem modificações substanciais.</li>
            <li><strong>Uso Ilegal:</strong> As imagens não podem ser usadas de forma a violar a lei, incluindo, mas não se limitando a, pornografia, discursos de ódio, ou violação de direitos autorais de terceiros.</li>
        </ul>

        <h2>3. Exclusões de Responsabilidade</h2>
        <p>Embora forneçamos as imagens com direitos de uso claros, não nos responsabilizamos por quaisquer violações de direitos autorais de terceiros que possam ocorrer devido ao uso indevido das imagens adquiridas.</p>

        <p>Se você tiver dúvidas sobre os termos da licença ou precisar de uma licença personalizada, entre em contato conosco para mais informações.</p>

        {{-- <a href="{{ back() }}" class="btn btn-primary" style="margin-top: 25px;">Voltar para a loja</a> --}}
        <a href="{{ url()->previous() }}" class="btn btn-primary" style="margin-top: 25px;">Voltar para a compra</a>


    </div>
    
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
