<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/serviço.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" media="screen"
        href="https://cpwebassets.codepen.io/assets/editor/themes/twilight-123214b13ed2699670d09785cc8ac3cbc46ebf6eeb43e268f0bb1a1e07c69684.css"
        id="cm-theme">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <title>Serviço</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <style>
        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            /* background-color: #000; */
            overflow: hidden;
            z-index: -1;
            /* filter: invert(1); */
        }
    </style>

</head>

@include('partials.nav')

<body>
    {{-- <div id="particles-js"></div> --}}


    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST" class="form-horizontal">
            @csrf
            <fieldset>
                <legend>
                    <center>
                        <h1 class="teste-h2"><b>Formulário de Serviços</b></h1>
                    </center>
                </legend><br>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="nome">Nome</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="nome" name="nome" placeholder="Nome" class="form-control" required
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="cpf">CPF</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="cpf" name="cpf" placeholder="CPF" class="form-control" required
                                type="text" onblur="validarCPF()">
                        </div>
                    </div>
                    <small id="cpf-error" style="color: red; display: none;">CPF inválido!</small>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="datadenascimento">Data de Nascimento</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            <input id="datadenascimento" name="datadenascimento" class="form-control" required
                                type="date">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="sexo">Sexo</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                            <select id="sexo" name="sexo" class="form-control" required>
                                <option value="">Selecione</option>
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="estadocivil">Estado Civil</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
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
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="cep">CEP</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="cep" name="cep" placeholder="CEP" class="form-control" required
                                type="text" onblur="buscarEndereco()">
                        </div>
                    </div>
                    <small id="cep-error" style="color: red; display: none;">CEP inválido!</small>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="logradouro">Logradouro</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                            <input id="logradouro" name="logradouro" placeholder="Logradouro" class="form-control"
                                required type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="numero">Número</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="numero" name="numero" placeholder="Número" class="form-control" required
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="complemento">Complemento</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="complemento" name="complemento" placeholder="Complemento"
                                class="form-control" type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="bairro">Bairro</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="bairro" name="bairro" placeholder="Bairro" class="form-control" required
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="cidade">Cidade</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="cidade" name="cidade" placeholder="Cidade" class="form-control" required
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="estado">Estado</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span>
                            <input id="estado" name="estado" placeholder="Estado" class="form-control" required
                                type="text">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label" for="email">Email</label>
                    <div class="col-md-4 inputGroupContainer">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                            <input id="email" name="email" placeholder="E-Mail" class="form-control" required
                                type="email">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label"></label>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-warning">ENVIAR <span
                                class="glyphicon glyphicon-send"></span></button>
                    </div>
                </div>

            </fieldset>
        </form>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


</body>

<script>
    document.getElementById('sair').addEventListener('click', function() {
        document.getElementById('logout-form').submit();
    });

    function bloquearBotaoDireito(event) {
        event.preventDefault();
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

{{-- ---------------------------------------VALIDAÇÃO-DE-CPF------------------------------ --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enviarButton = document.getElementById('enviar');

        function validarCPF() {
            const cpfInput = document.getElementById('cpf');
            const cpfError = document.getElementById('cpf-error');
            const cpf = cpfInput.value.replace(/\D/g, '');

            if (!isValidCPF(cpf)) {
                cpfError.style.display = 'inline';
                cpfInput.classList.add('is-invalid');
                if (enviarButton) {
                    enviarButton.disabled = true;
                }
            } else {
                cpfError.style.display = 'none';
                cpfInput.classList.remove('is-invalid');
                if (enviarButton) {
                    enviarButton.disabled = false;
                }
            }
        }

        function isValidCPF(cpf) {
            if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

            let sum = 0;
            let remainder;

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

            return true;
        }

        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('blur', validarCPF);
        }
    });
</script>

{{-- ------------------------------------------VERIFICAÇÃO-DE-CEP--------------------------------------------------- --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const enviarButton = document.getElementById('enviar');

        function buscarEndereco() {
            const cepInput = document.getElementById('cep');
            const cepError = document.getElementById('cep-error');
            const cep = cepInput.value.replace(/\D/g, '');

            if (!isValidCEP(cep)) {
                cepError.style.display = 'inline';
                cepInput.classList.add('is-invalid');
                if (enviarButton) {
                    enviarButton.disabled = true;
                }
                return;
            } else {
                cepError.style.display = 'none';
                cepInput.classList.remove('is-invalid');
                if (enviarButton) {
                    enviarButton.disabled = false;
                }
            }

            fetchEndereco(cep);
        }

        function isValidCEP(cep) {
            return cep.length === 8;
        }

        async function fetchEndereco(cep) {
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();

                if (data.erro) {
                    document.getElementById('cep-error').innerText = 'CEP não encontrado!';
                    document.getElementById('cep-error').style.display = 'inline';
                    if (enviarButton) {
                        enviarButton.disabled = true;
                    }
                } else {
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                }
            } catch (error) {
                console.error('Erro ao buscar endereço:', error);
            }
        }

        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('blur', buscarEndereco);
        }
    });
</script>


<script>
    particlesJS('particles-js', {
        particles: {
            number: {
                value: 100
            },
            size: {
                value: 3
            },
            move: {
                speed: 1
            },
            shape: {
                type: "circle"
            },
            line_linked: {
                enable: true,
                distance: 150
            }
        }
    });
</script>
</body>

<script src="particles.js"></script>
<script>
    particlesJS.load('particles-js', 'particles.json', function() {
        console.log('particles.js loaded');
    });
</script>

</body>

</html>
