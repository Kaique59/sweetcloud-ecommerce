 document.addEventListener('DOMContentLoaded', () => {
            // Código da API de CEP para o formulário de cadastro
            const cepInput = document.getElementById('cep');

            // Verifica se o campo CEP existe nesta página para evitar erros em outras páginas
            if (cepInput) {
                const ruaInput = document.getElementById('rua');
                const bairroInput = document.getElementById('bairro');
                const cidadeInput = document.getElementById('cidade');
                const estadoInput = document.getElementById('estado');

                // Função para limpar os campos de endereço
                const clearAddressFields = () => {
                    ruaInput.value = '';
                    bairroInput.value = '';
                    cidadeInput.value = '';
                    estadoInput.value = '';
                };

                // Função para habilitar/desabilitar campos (readonly)
                const setAddressFieldsReadonly = (isReadonly) => {
                    ruaInput.readOnly = isReadonly;
                    bairroInput.readOnly = isReadonly;
                    cidadeInput.readOnly = isReadonly;
                    estadoInput.readOnly = isReadonly;
                };

                // Listener para o evento 'blur' (quando o campo CEP perde o foco)
                cepInput.addEventListener('blur', async () => {
                    let cep = cepInput.value.replace(/\D/g, ''); // Remove caracteres não numéricos

                    if (cep.length === 8) {
                        clearAddressFields(); // Limpa antes de buscar
                        setAddressFieldsReadonly(true); // Deixa os campos readonly enquanto busca

                        try {
                            const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                            const data = await response.json();

                            if (data.erro) { // CEP não encontrado ou inválido
                                console.error('CEP não encontrado ou inválido.');
                                // Opcional: Adicione aqui uma forma de feedback ao usuário (e.g., uma div de erro)
                                clearAddressFields();
                                setAddressFieldsReadonly(false); // Permite ao usuário digitar manualmente
                            } else {
                                ruaInput.value = data.logradouro || '';
                                bairroInput.value = data.bairro || '';
                                cidadeInput.value = data.localidade || '';
                                estadoInput.value = data.uf || '';
                                setAddressFieldsReadonly(true); // Mantém readonly se encontrado
                            }
                        } catch (error) {
                            console.error('Erro ao buscar CEP:', error);
                            // Opcional: Adicione aqui uma forma de feedback ao usuário
                            clearAddressFields();
                            setAddressFieldsReadonly(false); // Permite ao usuário digitar manualmente
                        }
                    } else {
                        clearAddressFields();
                        setAddressFieldsReadonly(false); // Permite ao usuário digitar se o CEP for incompleto
                    }
                });

                // Opcional: Máscara para o CEP (ex: 99999-999)
                cepInput.addEventListener('input', (e) => {
                    let value = e.target.value.replace(/\D/g, ''); // Remove não-dígitos
                    if (value.length > 5) {
                        value = value.substring(0, 5) + '-' + value.substring(5, 8);
                    }
                    e.target.value = value;
                });

                // Inicializa os campos de endereço como readonly ao carregar a página,
                // caso já existam valores (ex: após um reenvio de formulário com erro)
                setAddressFieldsReadonly(true);
            }
        });