<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>



# Documentação do Projeto em Laravel
Visão Geral
Este projeto é desenvolvido em Laravel e tem como objetivo vender fotos autorais de maneira segura e intuitiva. O sistema utiliza diversas tecnologias modernas para garantir a eficácia, segurança e escalabilidade da aplicação.
Funcionalidades Principais
•	Cadastro e Login de Usuários:
o	Cadastro com verificação de e-mail (usando API externa).
o	Redirecionamento para tela de verificação após registro.
•	Gerenciamento de Imagens:
o	Upload e armazenamento de imagens no banco de dados como dados binários.
o	Geração de URLs para imagens com e sem marca d'água.
•	Sistema de Pagamento:
o	Integração com a API do Mercado Pago para processamento seguro de pagamentos.
o	Exibição de detalhes do pagamento, incluindo ID da transação e status, após a compra.
Histórico de Compras:
o	Área exclusiva para usuários logados visualizarem suas compras anteriores.


# Utilização de Webhooks para Pagamento via PIX
O sistema utiliza webhooks para gerenciar notificações de pagamentos via PIX, oferecendo uma experiência de pagamento em tempo real e totalmente automatizada. A integração funciona da seguinte forma:
1.	Criação do Pedido:
o	Quando o usuário opta por pagar via PIX, um pedido é criado e enviado para a API do Mercado Pago.
o	Um código QR único é gerado e exibido para o cliente realizar o pagamento.
2.	Recebimento da Notificação:
o	O Mercado Pago envia uma notificação para a URL configurada no sistema sempre que houver uma atualização no status do pagamento (exemplo: "pendente" para "aprovado").
3.	Processamento do Webhook:
o	O Laravel captura os dados enviados pelo webhook e atualiza o status do pagamento na tabela de vendas.
o	Caso o pagamento seja aprovado, o sistema libera automaticamente o download da imagem adquirida pelo cliente.
4.	Segurança:
o	Todas as notificações recebidas pelo webhook são validadas utilizando a assinatura digital fornecida pela API do Mercado Pago.



________________________________________



# Utilização de Cloudinary para Marca d'Água
O sistema utiliza o Cloudinary para adicionar marcas d'água às imagens de forma dinâmica e eficiente. O Cloudinary é uma plataforma de gerenciamento de mídia que permite processar, transformar e entregar imagens com alta performance. A integração funciona da seguinte forma:
1.	Upload da Imagem:
o	Quando uma imagem é enviada pelo usuário, ela é carregada no Cloudinary.
o	A API do Cloudinary retorna uma URL pública para acessar a imagem original.
2.	Aplicação da Marca d'Água:
o	Para cada solicitação de imagem com marca d'água, a URL é gerada dinamicamente adicionando os parâmetros de transformação do Cloudinary.
o	Esses parâmetros permitem sobrepor uma imagem de marca d'água (previamente carregada no Cloudinary) à imagem original, ajustando sua posição, tamanho e transparência.
3.	Entrega da Imagem:
o	A imagem transformada é entregue ao usuário final diretamente via URL, sem necessidade de armazenar múltiplas versões da imagem no sistema.
4.	Vantagens do Uso do Cloudinary:
o	Reduz o consumo de armazenamento local.
o	Oferece entrega otimizada via CDN, garantindo carregamento rápido.
o	Permite ajustes em tempo real sem necessidade de reprocessar imagens manualmente.

________________________________________


# Integrações Externas

•	API de Verificação de E-mail: Usada para garantir que apenas e-mails válidos sejam registrados.
•	Mercado Pago: Utilizado para processar pagamentos de forma segura.
•	AWS: Integração para armazenamento e processamento de dados.
o	O banco de dados é hospedado no Amazon RDS (Relational Database Service), o que garante alta disponibilidade, escalabilidade e backups automáticos. O RDS permite a escolha de instâncias otimizadas para aplicações com alto desempenho e utiliza criptografia para dados em repouso e em trânsito.

# Tecnologias Utilizadas

### •	Laravel: Framework principal.
### •	MySQL: Banco de dados relacional.
### •	Blade: Motor de templates para renderização de views.
### •	Bootstrap: Framework CSS para estilização.
### •	Mercado Pago SDK: Para integração de pagamentos.

# Planejamento Futuro
•	Implementar suporte à API de terceiros para promoções.
•	Criar uma área para revisões e comentários sobre imagens.
•	Melhorar o design responsivo para dispositivos móveis.
•	Adicionar relatórios de vendas para o administrador.
________________________________________



![site-att](https://github.com/user-attachments/assets/f87983ed-8e01-492c-9375-1cc58f86a150)


![site-att-2](https://github.com/user-attachments/assets/60f961fa-0333-407d-bc92-66c7d809d897)


![site-att-2](https://github.com/user-attachments/assets/6d23e10f-e81b-4595-b288-5dabef0a0465)
