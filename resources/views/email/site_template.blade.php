<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo ao Nosso Site</title>
    <style>
        /* Reseta os estilos padrão */
        body, h1, h2, h3, p {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            color: #333333;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            font-size: 24px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            margin-top: 20px;
            border-radius: 8px;
        }
        .content h2 {
            color: #4CAF50;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .content p {
            font-size: 16px;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #ffffff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777777;
            margin-top: 20px;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Cabeçalho -->
        <div class="header">
            <h1>Bem-vindo ao Nosso Site!</h1>
        </div>

        <!-- Conteúdo Principal -->
        <div class="content">
            <h2>Olá, {{ $dados['nome'] }}!</h2>
            <p>{{ $dados['mensagem'] }}</p>
            <p>Estamos muito felizes em ter você conosco. Este é um email de boas-vindas com base no template do nosso site.</p>
            <p>Explore tudo o que temos a oferecer e aproveite os melhores conteúdos e serviços. Se precisar de qualquer ajuda, nossa equipe estará à disposição para ajudar!</p>

            <!-- Botão de Ação -->
            <a href="https://vitorhugo.netlify.app/" class="button">Visite Nosso Site</a>
        </div>

        <!-- Rodapé -->
        <div class="footer">
            <p>Você está recebendo este email porque se cadastrou em nosso site.</p>
            <p>Se você não deseja mais receber nossos emails, <a href="https://zonafantasmanet.wordpress.com/wp-content/uploads/2021/07/the_joker_vol_2_1_exclusive_scorpion_comics_variant_b.jpg?w=660">clique aqui para se descadastrar</a>.</p>
            <p>&copy; 2024 Seu Site. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
