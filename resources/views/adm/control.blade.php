<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Controle</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/css/adm/panelcontrol.css">
</head>

<body>

    <div class="container-geral">
        <div class="navbar">
            <div class="container-top">
                <div class="logo">
                    <h1>PAINEL DE CONTROLE</h1>
                </div>
                <div class="panel-content">
                    <ul>
                        <li><a href="{{route('usuarios.index')}}">Gerenciar Usuários</a></li>
                        <!-- <li><a href="upload.php">Adicionar Imagem ao Banco</a></li> -->
                        {{-- <li><a href="consult_img/consult_control.php">Consultar Imagem</a></li> --}}
                        <li><a href="{{route('uploads')}}">Adicionando Imagens na Biblioteca</a></li>
                        <li><a href="{{route('imagens.table')}}">Consultar Imagens</a></li>
                        {{-- <li><a href="add_img/panel_control.php">Adicionando Imagens nos Albuns</a></li> --}}
                        <!-- <li><a href="cliente/crud_serviço.php">Gerenciador de clientes</a></li> -->
                        <!-- <li><a href="artista/crud_artista.php">Artistas</a></li> -->
                        <!-- <li><a href="equipamento/crud_equipamento.php">Equipamentos</a></li> -->
                    </ul>
                </div>
            </div>
            <div class="container-bottom">

                <p><a href="{{ route('biblioteca') }}"><i class="bi bi-box-arrow-right"></i> Biblioteca</a></p>

                <form id="logout-form" action="{{ route('logoutAdm') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                <p>
                    <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                </p>



            </div>
        </div>
        <div class="main-content">
            <img style="height: 115vh; width: 100vw;" src="../../assets/img/ti2.jpg" alt="">
        </div>
    </div>

</body>

</html>