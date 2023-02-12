
function chargeTooltip() {
	const toolTipItems = document.querySelectorAll('[tooltip]')
	const tooltipList = [...toolTipItems].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
}

$(document).ready(function() {
	$('[format="money"]').mask("#.##0,00", {
		reverse: true
	});

	$('[format="decimal"]').mask("#.##0,00", {
		reverse: true
	});

	$('[format="date"]').mask("00/00/0000", {
		reverse: false
	});

	$('[format="zip"]').mask("00/00/0000", {
		reverse: false
	});

	$('[format="cep"]').mask('00.000-000');

	$('[format="cpf"]').mask('000.000.000-00', {reverse: false});
});




$(document).on("click", "[href]", function () {
	location = this.getAttribute("href");
});

function verificaObrigatoriedade(arrayData) {
	var totalObrigatorios = 0;

	if (typeof arrayData != "object") {
		alert("Precisamos de um array para verificar os campos!");
		return;
	}

	for (k in arrayData) {
		if ($(`#${arrayData[k]}`).val() == "") {
			$(`#${arrayData[k]}`).attr("campo_obrigatorio");
			$(`#${arrayData[k]}`).addClass("border-danger");
			totalObrigatorios++;
		} else {
			$(`#${arrayData[k]}`).removeAttr("campo_obrigatorio");
			$(`#${arrayData[k]}`).removeClass("border-danger");
		}
	}

	if(totalObrigatorios) {
		preloaderParar();
	}
	
	return totalObrigatorios;
}

function setDinheiro(valor) {
	valor = parseFloat(valor);

	if (isNaN(valor) || valor == "" || typeof valor == "undefined") {
		return (0.0).toLocaleString("pt-br", {
			minimumFractionDigits: 2,
		});
	}

	return valor.toLocaleString("pt-br", {
		minimumFractionDigits: 2,
	});
}

function setDateFromTimestamp(timestamp) {
	var date = new Date(timestamp);

	if (date == "Invalid Date") {
		return "00/00/0000";
	}

	return date.toLocaleDateString("pt-br");
}

function getTimestampFromDate(date) {
	var date = Date.parse(date);

	if (typeof date != "number" || isNaN(date / 1000)) {
		return 0;
	}

	return date / 1000;
}

function getSqlDate(date) {
	var date = Date.parse(date);
	var dateObject = new Date(date);

	return dateObject.toISOString().slice(0, 19).replace("T", " ");
}

function toFloat(num) {
	if(num == "") {
		return 0;
	}

    dotPos = num.indexOf('.');
    commaPos = num.indexOf(',');

    if (dotPos < 0)
        dotPos = 0;

    if (commaPos < 0)
        commaPos = 0;

    if ((dotPos > commaPos) && dotPos)
        sep = dotPos;
    else {
        if ((commaPos > dotPos) && commaPos)
            sep = commaPos;
        else
            sep = false;
    }

    if (sep == false)
        return parseFloat(num.replace(/[^\d]/g, ""));

    return parseFloat(
        num.substr(0, sep).replace(/[^\d]/g, "") + '.' + 
        num.substr(sep+1, num.length).replace(/[^0-9]/, "")
    );

}


function getDinheiroByElement(elemento) {
	let num = elemento.val();
	num = num.replaceAll(".", "");
	num = num.replaceAll(",", "");
	num = num.split("");
	let ultimosValores = num.slice(-2);
	num.pop();
	num.pop();
	num.push(".");
	num.push(ultimosValores[0]);
	num.push(ultimosValores[1]);
	return num.join("");
}

function getDinheiroById(elemento) {
	let num = $("#" + elemento).val();
	num = num.replaceAll(".", "");
	num = num.replaceAll(",", "");
	num = num.split("");
	let ultimosValores = num.slice(-2);
	num.pop();
	num.pop();
	num.push(".");
	num.push(ultimosValores[0]);
	num.push(ultimosValores[1]);
	return num.join("");
}
// style="position: absolute; top: 50%; left: 50%; z-index: 10000;"
function preloaderIniciar() {
	$("body").append(`
		<div class="modal-glass" style="display: flex;
			flex-direction: row;
			flex-wrap: nowrap;
			align-content: center;
			justify-content: center;
			align-items: center;">
        	<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
				<span class="visually-hidden">Carregando...</span>
			</div>
      	</div>
	`);
}

function preloaderParar() {
	try {
		$("div.modal-glass").remove();
		$("img.spinner").remove();
	} catch {
		alertaErro("Erro ao parar preloader");
	}
}

function alertaAviso(frase) {
	$("body").append(`
		<div class="alert show showAlert aviso">
			<span class="fas fa-exclamation-circle icon"></span>
			<span class="msg">${frase}</span>
			<div class="close-btn">
				<span class="fas"></span>
			</div>
		</div>
	`);
	setTimeout(function () {
		$(".alert.show.showAlert").fadeOut();
		setTimeout(function () {
			$(".alert.show.showAlert").eq(0).remove();
		}, 700);
	}, 2000);
}

function alertaSucesso(frase) {
	// $(".alert.show.showAlert").remove();
	$("body").append(`
		<div class="alert show showAlert sucesso">
			<span class="fas fa-check icon"></span>
			<span class="msg">${frase}</span>
			<div class="close-btn">
				<span class="fas"></span>
			</div>
		</div>
	`);
	setTimeout(function () {
		$(".alert.show.showAlert").fadeOut();
		setTimeout(function () {
			$(".alert.show.showAlert").eq(0).remove();
		}, 1000);
	}, 2000);
}

function alertaErro(frase) {
	// $(".alert.show.showAlert").remove();
	$("body").append(`
		<div class="alert show showAlert erro">
			<span class="fas fa-exclamation-triangle icon"></span>
			<span class="msg">${frase}</span>
			<div class="close-btn">
				<span class="fas"></span>
			</div>
		</div>
  	`);
	setTimeout(function () {
		$(".alert.show.showAlert").fadeOut();
		setTimeout(function () {
			$(".alert.show.showAlert").eq(0).remove();
		}, 1000);
	}, 2000);
}

function alertaInfo(frase) {
	// $(".alert.show.showAlert").remove();
	$("body").append(`
		<div class="alert show showAlert info">
			<span class="fas fa-info-circle icon"></span>
			<span class="msg">${frase}</span>
			<div class="close-btn">
				<span class="fas"></span>
			</div>
		</div>
	`);
	setTimeout(function () {
		$(".alert.show.showAlert").fadeOut();
		setTimeout(function () {
			$(".alert.show.showAlert").eq(0).remove();
		}, 1000);
	}, 2000);
}

async function requestPost(
	url,
	dados,
	ok,
	err,
	progressId = "",
	ready = () => {}
) {
	await $.ajax({
		xhr: function () {
			var xhr = new window.XMLHttpRequest();

			xhr.upload.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			// Download progress
			xhr.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			return xhr;
		},
		url: url,
		data: dados,
		type: "POST",
		done: (result) => {
			ready(result);
		},
		success: (result) => {
			$(`#${progressId}`).attr("aria-valuenow", "100");
			$(`#${progressId}`).css("width", "100%");
			ok(result);
		},
		error: (error) => {
			err(error);
		},
	});
}

async function requestDelete(
	url,
	dados,
	ok,
	err,
	progressId = "",
	ready = () => {}
) {
	await $.ajax({
		xhr: function () {
			var xhr = new window.XMLHttpRequest();

			xhr.upload.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			// Download progress
			xhr.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			return xhr;
		},
		url: url,
		data: dados,
		type: "DELETE",
		done: (result) => {
			ready(result);
		},
		success: (result) => {
			$(`#${progressId}`).attr("aria-valuenow", "100");
			$(`#${progressId}`).css("width", "100%");
			ok(result);
		},
		error: (error) => {
			err(error);
		},
	});
}

async function requestPut(
	url,
	dados,
	ok,
	err,
	progressId = "",
	ready = () => {}
) {
	await $.ajax({
		xhr: function () {
			var xhr = new window.XMLHttpRequest();

			xhr.upload.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;
						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			// Download progress
			xhr.addEventListener(
				"progress",
				function (evt) {
					if (evt.lengthComputable) {
						var percentComplete = evt.loaded / evt.total;

						$(`#${progressId}`).attr("aria-valuenow", percentComplete);
						$(`#${progressId}`).css("display", "flex");
						$(`#${progressId}`).css("width", percentComplete + "%");
					}
				},
				false
			);

			return xhr;
		},
		url: url,
		data: dados,
		type: "PUT",
		done: (result) => {
			ready(result);
		},
		success: (result) => {
			$(`#${progressId}`).attr("aria-valuenow", "100");
			$(`#${progressId}`).css("width", "100%");
			ok(result);
		},
		error: (error) => {
			err(error);
		},
	});
}
