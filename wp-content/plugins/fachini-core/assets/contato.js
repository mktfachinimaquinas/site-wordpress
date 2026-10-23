/**
 * Formulário de orçamento (página Contato) e página de confirmação.
 *
 * O formulário é montado pelo plugin (includes/contato.php) e enviado para
 * /wp-json/fachini/v1/pedido (includes/pedidos.php), que confere tudo de
 * novo. Aqui ficam só a ajuda ao preencher: campos de empresa, lista de
 * modelos por categoria, máscaras, mensagens de erro e o envio sem recarregar.
 */
(function () {
	'use strict';

	var AJUDA = 'Ainda não sei, quero ajuda para escolher';

	var form = document.querySelector('.fachini-form');
	if (form) {
		iniciarFormulario(form);
	}

	var whatsapp = document.querySelector('.fachini-confirmacao__whatsapp[data-auto]');
	if (whatsapp) {
		iniciarConfirmacao(whatsapp);
	}

	/* CNPJ numérico ou alfanumérico (Receita Federal, julho de 2026). */
	function cnpjValido(valor) {
		var c = String(valor).toUpperCase().replace(/[^0-9A-Z]/g, '');
		if (!/^[0-9A-Z]{12}[0-9]{2}$/.test(c) || /^(.)\1{13}$/.test(c)) {
			return false;
		}
		for (var tamanho = 12; tamanho <= 13; tamanho++) {
			var soma = 0;
			var peso = tamanho - 7;
			for (var i = 0; i < tamanho; i++) {
				soma += (c.charCodeAt(i) - 48) * peso;
				peso = peso === 2 ? 9 : peso - 1;
			}
			var resto = soma % 11;
			if (Number(c.charAt(tamanho)) !== (resto < 2 ? 0 : 11 - resto)) {
				return false;
			}
		}
		return true;
	}

	function mascaraCnpj(valor) {
		var c = valor.toUpperCase().replace(/[^0-9A-Z]/g, '').slice(0, 14);
		var s = c.slice(0, 2);
		if (c.length > 2) { s += '.' + c.slice(2, 5); }
		if (c.length > 5) { s += '.' + c.slice(5, 8); }
		if (c.length > 8) { s += '/' + c.slice(8, 12); }
		if (c.length > 12) { s += '-' + c.slice(12, 14); }
		return s;
	}

	/* (45) 99999-9999. Número de outro país (começando com + e sem 55) fica livre. */
	function mascaraTelefone(valor) {
		if (/^\s*\+/.test(valor) && !/^\s*\+\s*55/.test(valor)) {
			return valor;
		}
		var d = valor.replace(/\D/g, '');
		if (d.length > 11 && d.indexOf('55') === 0) {
			d = d.slice(2);
		}
		d = d.slice(0, 11);
		if (d.length <= 2) { return d.length ? '(' + d : ''; }
		if (d.length <= 6) { return '(' + d.slice(0, 2) + ') ' + d.slice(2); }
		if (d.length <= 10) { return '(' + d.slice(0, 2) + ') ' + d.slice(2, 6) + '-' + d.slice(6); }
		return '(' + d.slice(0, 2) + ') ' + d.slice(2, 7) + '-' + d.slice(7);
	}

	/* Origem da visita, guardada na chegada por assets/rastreamento.js, e o
	   cookie de origem do RD Station, quando o script dele estiver ativo. */
	function origemDaVisita() {
		var origem = {};
		try {
			origem = JSON.parse(window.sessionStorage.getItem('fachini-origem') || '{}') || {};
		} catch (e) {
			origem = {};
		}
		var rd = document.cookie.match(/(?:^|; )__trf\.src=([^;]*)/);
		if (rd) {
			origem.rd_src = decodeURIComponent(rd[1]).slice(0, 300);
		}
		return origem;
	}

	function iniciarFormulario(form) {
		var inicio = Date.now();
		var categorias = [];
		try {
			categorias = JSON.parse(document.getElementById('fachini-form-maquinas').textContent) || [];
		} catch (e) {
			categorias = [];
		}

		var campos = form.elements;
		var aviso = form.querySelector('.fachini-form__aviso');
		var enviar = form.querySelector('.fachini-form__botao--enviar');

		function tipo() {
			var marcado = form.querySelector('input[name="tipo"]:checked');
			return marcado ? marcado.value : '';
		}

		/* Empresa: CNPJ, empresa e cargo. Escondidos e desligados para pessoa física. */
		function atualizarEmpresa() {
			var pj = tipo() === 'pj';
			form.querySelectorAll('.fachini-campo--empresa').forEach(function (bloco) {
				bloco.hidden = !pj;
				bloco.querySelectorAll('input').forEach(function (input) {
					input.disabled = !pj;
				});
			});
		}

		function preencherModelos(categoriaId, escolhido) {
			var modelo = campos.modelo;
			var categoria = categorias.filter(function (c) { return String(c.id) === String(categoriaId); })[0];
			modelo.length = 0;
			var vazio = new Option('', '', true, true);
			vazio.disabled = true;
			vazio.hidden = true;
			modelo.add(vazio);
			if (!categoria) {
				var antes = new Option('Escolha primeiro a categoria', '');
				antes.disabled = true;
				modelo.add(antes);
				return;
			}
			categoria.maquinas.forEach(function (m) {
				modelo.add(new Option(m.nome, String(m.id)));
			});
			modelo.add(new Option(AJUDA, 'ajuda'));
			if (escolhido) {
				modelo.value = String(escolhido);
			}
		}

		function mostrarErro(nome, mensagem) {
			var bloco = form.querySelector('[data-campo="' + nome + '"]');
			if (!bloco) {
				return;
			}
			var texto = bloco.querySelector('.fachini-campo__erro');
			bloco.classList.toggle('is-erro', !!mensagem);
			if (texto) {
				texto.textContent = mensagem || '';
				texto.hidden = !mensagem;
			}
			bloco.querySelectorAll('input, select, textarea').forEach(function (el) {
				if (mensagem) {
					el.setAttribute('aria-invalid', 'true');
				} else {
					el.removeAttribute('aria-invalid');
				}
			});
		}

		function avisar(mensagem) {
			aviso.textContent = mensagem || '';
			aviso.hidden = !mensagem;
		}

		function limparErros() {
			form.querySelectorAll('[data-campo]').forEach(function (bloco) {
				mostrarErro(bloco.getAttribute('data-campo'), '');
			});
			avisar('');
		}

		/* As mesmas regras do servidor, para a pessoa saber antes de enviar. */
		function validar() {
			var e = {};
			if (!tipo()) { e.tipo = 'Escolha como deseja prosseguir.'; }
			if (campos.nome.value.trim().length < 3) { e.nome = 'Informe seu nome completo.'; }
			if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campos.email.value.trim())) { e.email = 'Informe um e-mail válido.'; }
			var digitos = campos.whatsapp.value.replace(/\D/g, '').length;
			if (digitos < 10 || digitos > 15) { e.whatsapp = 'Informe o WhatsApp com DDD.'; }
			if (tipo() === 'pj' && !cnpjValido(campos.cnpj.value)) { e.cnpj = 'Informe um CNPJ válido.'; }
			if (!campos.categoria.value) { e.categoria = 'Escolha uma categoria.'; }
			else if (!campos.modelo.value) { e.modelo = 'Escolha um modelo.'; }
			if (!campos.aceite_contato.checked) { e.aceite_contato = 'Para responder ao seu pedido, precisamos da sua autorização de contato.'; }
			return e;
		}

		/* Mostra os erros e leva o foco ao primeiro, na ordem da página. */
		function mostrarErros(erros) {
			var primeiro = null;
			Object.keys(erros || {}).forEach(function (nome) {
				mostrarErro(nome, erros[nome]);
			});
			form.querySelectorAll('.is-erro').forEach(function (bloco) {
				if (!primeiro) {
					primeiro = bloco.querySelector('input:not([type="hidden"]), select, textarea');
				}
			});
			if (primeiro) {
				primeiro.focus();
				return true;
			}
			return false;
		}

		function enviando(sim) {
			enviar.disabled = sim;
			enviar.textContent = sim ? 'Enviando...' : 'Enviar';
			form.classList.toggle('is-enviando', sim);
		}

		form.addEventListener('change', function (ev) {
			var alvo = ev.target;
			if (alvo.name === 'tipo') {
				atualizarEmpresa();
			}
			if (alvo.name === 'categoria') {
				preencherModelos(alvo.value);
				mostrarErro('modelo', '');
			}
			var bloco = alvo.closest('[data-campo]');
			if (bloco && bloco.classList.contains('is-erro')) {
				mostrarErro(bloco.getAttribute('data-campo'), '');
			}
		});

		form.addEventListener('input', function (ev) {
			var alvo = ev.target;
			if (alvo.name === 'whatsapp') {
				alvo.value = mascaraTelefone(alvo.value);
			} else if (alvo.name === 'cnpj') {
				alvo.value = mascaraCnpj(alvo.value);
			}
			var bloco = alvo.closest('[data-campo]');
			if (bloco && bloco.classList.contains('is-erro')) {
				mostrarErro(bloco.getAttribute('data-campo'), '');
			}
		});

		form.addEventListener('reset', function () {
			/* O navegador limpa os campos depois deste evento. */
			setTimeout(function () {
				limparErros();
				atualizarEmpresa();
				preencherModelos('');
			}, 0);
		});

		form.addEventListener('submit', function (ev) {
			ev.preventDefault();
			if (form.classList.contains('is-enviando')) {
				return;
			}
			limparErros();
			if (mostrarErros(validar())) {
				avisar('Confira os campos destacados.');
				return;
			}
			campos.t.value = String(Date.now() - inicio);
			campos.pagina.value = window.location.href;
			campos.referencia.value = document.referrer;
			enviando(true);

			var dados = new FormData(form);
			dados.append('origem', JSON.stringify(origemDaVisita()));

			fetch(form.getAttribute('data-endpoint'), { method: 'POST', body: dados, credentials: 'omit' })
				.then(function (resposta) {
					return resposta.json().catch(function () { return {}; });
				})
				.then(function (r) {
					if (r && r.ok && r.destino) {
						window.location.href = r.destino;
						return;
					}
					enviando(false);
					mostrarErros(r && r.erros);
					avisar(r && r.mensagem ? r.mensagem : 'Não foi possível enviar agora. Tente de novo em instantes ou fale conosco pelo WhatsApp.');
				})
				.catch(function () {
					enviando(false);
					avisar('Não foi possível enviar agora. Confira sua conexão e tente de novo.');
				});
		});

		atualizarEmpresa();
		preencherModelos(campos.categoria.value);

		/* Vindo do "Solicite seu orçamento" de uma máquina (?orcamento=ID). */
		var maquina = new URLSearchParams(window.location.search).get('orcamento');
		if (maquina) {
			categorias.some(function (c) {
				var achou = c.maquinas.some(function (m) { return String(m.id) === maquina; });
				if (achou) {
					campos.categoria.value = String(c.id);
					preencherModelos(c.id, maquina);
				}
				return achou;
			});
		}
	}

	/* Confirmação: depois da barra encher, abre o WhatsApp. Uma vez por pedido,
	   para não abrir de novo quando a pessoa volta para esta página. */
	function iniciarConfirmacao(bloco) {
		var url = bloco.getAttribute('data-url');
		var chave = 'fachini-whatsapp-' + bloco.getAttribute('data-auto');
		var jaFoi = false;
		try {
			jaFoi = window.sessionStorage.getItem(chave) === '1';
		} catch (e) {
			jaFoi = false;
		}
		function marcar() {
			try {
				window.sessionStorage.setItem(chave, '1');
			} catch (e) {
				/* Sem armazenamento: só não lembra. */
			}
		}
		var botao = bloco.querySelector('.fachini-confirmacao__botao');
		if (botao) {
			botao.addEventListener('click', marcar);
		}
		if (jaFoi || !url) {
			bloco.classList.add('is-parado');
			return;
		}
		bloco.classList.add('is-contando');
		window.setTimeout(function () {
			marcar();
			window.location.href = url;
		}, 5000);
	}
})();
