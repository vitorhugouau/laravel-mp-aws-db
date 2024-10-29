<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/serviço.css">
    <title>Document</title>
    
</head>
<body background="../../assets/img/rio.jpg">
    <nav>
        <ul class="menu">
            <li><a href="{{ route('biblioteca') }}">HOME</a></li>
            {{-- <li><a href="#">SOBRE</a> --}}
            </li>
            {{-- <li><a href="album.php">ÁLBUM</a> --}}
            </li>
            <li><a href="#">CONTATO</a>
                <ul><a
                        href="https://www.instagram.com/vitor_filmes?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">INSTAGRAM</a>
                </ul>
            </li>
            <li><a href="#">SERVIÇOS</a>
                <ul>
                    <li><a href="cliente/serviço.php">CONTRATAR SERVIÇO</a></li>
                </ul>
            </li>
            <li><a href="{{ route('adm.login') }}">PAINEL DE CONTROLE</a>
            <li class="logout">
                <div class="carde">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <button type="button" class="submit" id="sair">SAIR</button>
                </div>
            </li>
        </ul>
    </nav>

    <h1>FORMULÁRIO</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <div class="meio">
        <div id="login">
            <form action="{{ route('clientes.store') }}" method="POST" class="card">
                <h3>Preencha com suas informações pessoais</h3>
                @csrf
                    <div class="card-header"> 
                        <div class="card-content">
                            <div class="card-content-area">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="card-content-area">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" required onblur="validarCPF()">
                                <small id="cpf-error" style="color: red; display: none;">CPF inválido!</small>
                            </div>                                                     
                            <div class="card-content-area">
                                <label for="datadenascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control" id="datadenascimento" name="datadenascimento" required>
                            </div>
                            <div class="card-content-area">
                                <label for="sexo" class="form-label">Sexo</label>
                                <select class="form-control" id="sexo" name="sexo" required>
                                    <option value="">Selecione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                            </div>
                            <div class="card-content-area">
                                <label for="estadocivil" class="form-label">Estado Civil</label>
                                <select id="estadocivil" name="estadocivil" class="form-control" required>
                                    <option value="">Selecione</option>
                                    <option value="solteiro">Solteiro(a)</option>
                                    <option value="casado">Casado(a)</option>
                                    <option value="divorciado">Divorciado(a)</option>
                                    <option value="viuvo">Viúvo(a)</option>
                                    <option value="separado">Separado(a)</option>
                                    <option value="uniao_estavel">União Estável</option>
                                </select>
                            </div>
                            
                            {{-- <div class="card-content-area">
                                <label for="estado" class="form-label">Estado</label>
                                <select id="estado" name="estado" class="form-control" onchange="getCidades(this.value, 'cidade')" required>
                                    <option value="">Selecione um Estado</option>
                                </select>
                            </div>
                            <div class="card-content-area">
                                <label for="cidade" class="form-label">Cidade</label>
                                <select id="cidade" name="cidade" class="form-control" required>
                                    <option value="">Selecione uma Cidade</option>
                                </select>
                            </div> --}}
                           {{-------------------------------------------------------------------------------- teste --}}
                           <div class="card-content-area">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" required onblur="buscarEndereco()">
                            <small id="cep-error" style="color: red; display: none;">CEP inválido!</small>
                        </div>
                        
                        <div class="card-content-area">
                            <label for="logradouro" class="form-label">Logradouro</label>
                            <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                        </div>
                        <div class="card-content-area">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" id="numero" name="numero" required>
                        </div>
                        <div class="card-content-area">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" id="complemento" name="complemento">
                        </div>
                        <div class="card-content-area">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" name="bairro" required>
                        </div>
                        <div class="card-content-area">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="#" class="form-control" id="cidade" name="cidade" required>
                        </div>
                        <div class="card-content-area">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="#" class="form-control" id="estado" name="estado" required>
                        </div>
                        
                            {{-- <div class="card-content-area">
                                <label for="logradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control" id="logradouro" name="logradouro" required>
                            </div>
                            <div class="card-content-area">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control" id="numero" name="numero" required>
                            </div> --}}
                            
                            <div class="card-content-area">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                               
                            </div>
                            
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="submit" name="submit" id="enviar">ENVIAR</button>
                    </div>
            </form>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


    
  <script>
        document.getElementById('sair').addEventListener('click', function() {
                document.getElementById('logout-form').submit();
            });
            function bloquearBotaoDireito(event){
                event.preventDefault();
            }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    {{-----------------------------------------ESTADO---CIDADE--------------------------------}}
    <script> 
        async function getEstados() {
            try {
                const response = await axios.get('https://servicodados.ibge.gov.br/api/v1/localidades/estados?orderBy=nome');
                const estados = response.data;
    
                const estadoSelect = document.getElementById('estado');
                estadoSelect.innerHTML = '<option value="">Selecione um Estado</option>';
    
                estados.forEach((estado) => {
                    const option = document.createElement('option');
                    option.value = estado.id;
                    option.textContent = estado.nome;
                    estadoSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erro ao buscar estados: ', error);
            }
        }
    
        async function getCidades(estadoId, cidadeSelectId) {
            if (!estadoId) return;
    
            try {
                const response = await axios.get(
                    `https://servicodados.ibge.gov.br/api/v1/localidades/estados/${estadoId}/municipios?orderBy=nome`
                );
                const cidades = response.data;
    
                const cidadeSelect = document.getElementById(cidadeSelectId);
                cidadeSelect.innerHTML = '<option value="">Selecione uma Cidade</option>';
    
                cidades.forEach((cidade) => {
                    const option = document.createElement('option');
                    option.value = cidade.nome;
                    option.textContent = cidade.nome;
                    cidadeSelect.appendChild(option);
                });
            } catch (error) {
                console.error('Erro ao buscar cidades: ', error);
            }
        }
    
        // Chamar a função para preencher os estados ao carregar a página
        document.addEventListener('DOMContentLoaded', getEstados);
    </script>
    {{-----------------------------------------VALIDAÇÃO-DE-CPF--------------------------------}}
    <script>
        function validarCPF() {
            const cpfInput = document.getElementById('cpf');
            const cpfError = document.getElementById('cpf-error');
            const cpf = cpfInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos

            if (!isValidCPF(cpf)) {
                cpfError.style.display = 'inline'; // Mostra mensagem de erro
                cpfInput.classList.add('is-invalid'); // Adiciona classe de erro
                document.getElementById('enviar').disabled = true; // Desabilita o botão de envio
            } else {
                cpfError.style.display = 'none'; // Esconde mensagem de erro
                cpfInput.classList.remove('is-invalid'); // Remove classe de erro
                document.getElementById('enviar').disabled = false; // Habilita o botão de envio
            }
        }

        function isValidCPF(cpf) {
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false; // Verifica se tem 11 dígitos e se não é um número repetido

            let sum = 0;
            let remainder;

            // Valida o primeiro dígito verificador
            for (let i = 1; i <= 9; i++) {
                sum += parseInt(cpf[i - 1]) * (11 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) {
                remainder = 0;
            }
            if (remainder !== parseInt(cpf[9])) {
                return false;
            }

            // Valida o segundo dígito verificador
            sum = 0;
            for (let i = 1; i <= 10; i++) {
                sum += parseInt(cpf[i - 1]) * (12 - i);
            }
            remainder = (sum * 10) % 11;
            if (remainder === 10 || remainder === 11) {
                remainder = 0;
            }
            if (remainder !== parseInt(cpf[10])) {
                return false;
            }

            return true; // CPF é válido
    }       

    </script>
    {{--------------------------------------------VERIFICAÇÃO-DE-CEP-----------------------------------------------------}}
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            function buscarEndereco() {
            const cepInput = document.getElementById('cep');
            const cepError = document.getElementById('cep-error');
            const cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos

            // Verifica se o CEP é válido
            if (!isValidCEP(cep)) {
                cepError.style.display = 'inline'; // Mostra mensagem de erro
                cepInput.classList.add('is-invalid'); // Adiciona classe de erro
                document.getElementById('enviar').disabled = true; // Desabilita o botão de envio
                return;
            } else {
                cepError.style.display = 'none'; // Esconde mensagem de erro
                cepInput.classList.remove('is-invalid'); // Remove classe de erro
                document.getElementById('enviar').disabled = false; // Habilita o botão de envio
            }

            // Se o CEP for válido, busque o endereço (opcional)
            fetchEndereco(cep);
        }

        function isValidCEP(cep) {
            // O CEP deve ter 8 dígitos
            return cep.length === 8;
        }

        // Exemplo de função para buscar o endereço (usando uma API fictícia ou real)
        async function fetchEndereco(cep) {
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    // Caso o CEP não exista
                    document.getElementById('cep-error').innerText = 'CEP não encontrado!';
                    document.getElementById('cep-error').style.display = 'inline';
                    document.getElementById('enviar').disabled = true; // Desabilita o botão de envio
                } else {
                    // Preencha os campos de endereço conforme a resposta da API
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                    // Adicione outros campos conforme necessário
                }
            } catch (error) {
                console.error('Erro ao buscar endereço:', error);
            }
        }

    </script>

</body>
</html>