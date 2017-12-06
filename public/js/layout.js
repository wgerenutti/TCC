$(document).ready(function() {
	
//	$("#menuCadastros").menu();
//	$("#menuConsultas").menu();
//	$("#menuConfiguracoes").menu();
	$("#accordion").accordion({
		collapsible: true,
		active: false,
	});
	$("#inicio").button({
		icons: {
			primary: "ui-icon-home",
		},
	text: false,
	});
	$("#preferencias").button({
		icons: {
			primary: "ui-icon-gear",
		},
	text: false,
	});
	$("#sair").button({
		icons: {
			primary: "ui-icon-power",
		},
	text: false,
	});
	
	$("#sair").click(function(e) {
		e.preventDefault();
		window.location ="/admin/auth/logout";
	});
	
	$("#logar").button({
		icons: {
			primary: "ui-icon-key",
		},
	text: false,
	}).click(function(e) {
		e.preventDefault();
		$("#logado").html("");
		window.location ="/admin/auth/logout";
	});

});
