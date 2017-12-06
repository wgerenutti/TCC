$(document).ready(function() {
	var tabelaEmp = $("#listaEmpregado").DataTable({
      "bInfo": false,
      "bFilter": false,
      "bLengthChange": false,
      "paging": false,
      "oLanguage": {
      	"sZeroRecords": "",
      	"sEmptyTable": ""
      },
      "columnDefs": [
                 { width: "40%", targets: [0, 1] },
                 { className: "dt-body-center", targets: [2] }
             ]
	});
	$("#capacitacao").selectmenu();
	$("#submit").hide();
	$("#cancelar").button({
		icons: {
			primary: "ui-icon-close",
		},
	text: true,
	});
	$("#salvar").button({
		icons: {
			primary: "ui-icon-disk",
		},
	text: true,
	});

	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/conhecimento";
	});

	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});

	$('button[id^="excluirEmpregado_"]').button({
		icons: {
			primary: "ui-icon-trash",
		},
	text: false,
	}).click(function(e) {
		e.preventDefault();
		if(confirm("Deseja realmente excluir?")) {
			tabelaEmp.row($(this).parents('tr')).remove().draw();
			}
		});
	
	$("#tabs").tabs();
	
	var conhecimentoId = $("#id").val();
	var empregadosSelecionados = [];
	var empregadosMap = [];
	var tabelaSelecaoEmpregados = "<table id='selecaoEmpregados'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
	
	//busca os empregados no banco de dados
	$.ajax({
        type: 'POST',
        dataType: "json",
        async: false,
        url: "/application/empregado/buscaempregados",
        success: function(d) {
        	empregados = $.parseJSON(d.empregados);
        	$.each(empregados, function (index, value){
        		tabelaSelecaoEmpregados += "<tr><td><input type = 'hidden' id='idEmpregado' value='"+value.matricula+"'>"+value.matricula+"</td>" +
				"<td>"+value.nome+"</td>" +
				"</tr>";
        		empregadosMap[value.matricula] = value.matricula +"&&&"+ value.nome;
        	});
        	tabelaSelecaoEmpregados += "</tbody></table>";
        }
	});
	
	if (conhecimentoId > 0) {
		//busca empregados, em caso de edição
		$.ajax({
	        type: 'POST',
	        dataType: "json",
	        async: false,
	        data: {conhecimentoId:conhecimentoId},
	        url: "/application/empregado/buscaempregado",
	        success: function(d) {
	        	var emp = $.parseJSON(d.empregados);
	        	$.each(emp, function (index, value){
	        		empregadosSelecionados.push(value.matricula); //alterado
	        	});
	        	adicionaEmpregado();
	        }
		});
	}	
	
	//janela modal para seleção de empregados
	var dialogEmpregados = $("#modal-participantes").dialog({
		autoOpen : false,
		height : 700,
		width : 950,
		modal : true,
		buttons : {
			"Concluir" : function(e) {
				e.preventDefault();
				adicionaEmpregado();
    			$(this).dialog("close");
			}
		}
	});
	$("#adicionarParticipantes").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();
		empregadosSelecionados = [];
		
		$("#empregados").html(tabelaSelecaoEmpregados);
    	$("#selecaoEmpregados").DataTable({
    		"pageLength": 15,
    		"order": [[ 1, "asc" ]],
    		"bLengthChange": false,
    		"bInfo": false,
    	});
	
    	dialogEmpregados.dialog("open");
		$("#selecaoEmpregados tbody").on('click','tr',function(e){
			 var matricula = $(this).find("#idEmpregado").val();
			 $(this).toggleClass('selected');
			 var indice = empregadosSelecionados.indexOf(matricula); //matricula
			 if(indice === -1){
				 empregadosSelecionados.push(matricula); //matricula
			 }
			 else{
				 empregadosSelecionados.splice(indice, 1);
			 }
		});
	});
	
	function adicionaEmpregado(){	
		$.each(empregadosSelecionados, function (index, value){
			var aux = empregadosMap[value].split("&&&");
			if($("#excluirEmpregado_"+value).length == 0){
				tabelaEmp
				 .row
				 .add (["<input type= 'hidden' id= 'empregado' name= 'matricula[]' value = '"+value+"'>"+aux[0], aux[1], '<button id="excluirEmpregado_'+value+'">Remover empregado</button>'])
				 .draw();
				$("#excluirEmpregado_"+value).button({
					icons: {
						primary: "ui-icon-trash",
				},
				text: false
				}).click(function(e) {
					e.preventDefault();
					if(confirm("Deseja realmente excluir?")) {
						tabelaEmp.row($(this).parents('tr')).remove().draw();
						}
					});
				}
		});
	}
});