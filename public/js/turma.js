$(document).ready(function() {
	//tabela de empregados
	var tabelaEmp = $("#tabelaParticipantes").DataTable({
		  "bInfo": false,
	      "bFilter": false,
	      "bLengthChange": false,
	      "paging": false,
	      "rowId": 'staffId',
	      "oLanguage": {
	      	"sZeroRecords": "",
	      	"sEmptyTable": "",
	      	
	      },
	      "columnDefs": [
	                 { width: "40%", targets: [1] },
	                 { width: "30%", targets: [0] },
	                 { className: "dt-body-center", targets: [0, 1, 2] }
	             ]
	});	
	//tabela de programação
	var tabelaProg = $('#tabelaProgramacao').DataTable({	
			  "bInfo": true,
		      "bFilter": false,
		      "bLengthChange": true,
		      "paging": false,
		      "oLanguage": {
		      	"sZeroRecords": "",
		      	"sEmptyTable": "",
		      },
		      "columnDefs": [
		                 { width: "18%", targets: [0] },
		                 { width: "18%", targets: [1] },
		                 { width: "18%", targets: [2] },
		                 { width: "36%", targets: [3] },
		                 {"className": "dt-left", "targets": "_all"},
		             ]
		});	
	//tabs
	$("#tabs").tabs();
	$("#selecoes").tabs();
	
	//variaveis referentes a empregado
	var listaId = $("#id").val();
	var empregadosSelecionados = [];
	var empregadosMap = [];
	var tabelaSelecaoEmpregados = "<table id='selecaoEmpregados'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
	var tabelaSelecaoParticipantes = "<table id='selecaoParticipantes'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";

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
	// botões salvar e cancelar
	$("#cancelar").click(function(e) {
		e.preventDefault();
		window.location ="/application/turma";
	});
	$("#salvar").click(function(e) {
		e.preventDefault();
		$("#submit").click();
	});
	//botão "novo" com sinal de +
	$("button[id^='nov']").button({
		icons: {
			primary: "ui-icon-plus",
		},
});
	//botão "remover" com sinal de -
	$("button[id^='remover']").button({
		icons: {
			primary: "ui-icon-trash",
		},
		text: true,
	});
	
	//botão "novoProfessor" com sinal de +
	$("button[id^='novoProfessor']").button({
		icons: {
			primary: "ui-icon-plus",
		},
		text: true,
});
	//aplicando js e definindo função.
	$("#curso").selectmenu({
				change: function(e, ui) {
					e.preventDefault();
					$("#tabelaQuestionario tbody").html("");
					tabelaSelecaoParticipantes = "<table id='selecaoParticipantes'><thead><tr><th>Matricula</th><th>Nome</th></tr></thead><tbody>";
					//busca listas de esperas
					$.ajax({
				        type: 'POST',
				        dataType: "json",
				        data: {idCurso:$(this).val()},
				        async: false,
				        url: "/application/lista-espera/buscalistaespera",
				        success: function(d) {
				        	var	empregados = $.parseJSON(d.empregados);
				        	$.each(empregados, function (index, value){
				        		tabelaSelecaoParticipantes += "<tr><td><input type = 'hidden' id='idParticipante' value='"+value.matricula+"'>"+value.matricula+"</td>" +
								"<td>"+value.nome+"</td></tr>";
				        		empregadosMap[value.matricula] = value.matricula +"&&&"+ value.nome;
				        	});
				        	tabelaSelecaoParticipantes += "</tbody></table>";
				        }
					});
				}
});
	//aplicando js nos selects menus
	$("#instituicao").selectmenu();
	$("select[id^='professor_").selectmenu();
	$("#aplicacao").selectmenu();
	$('#valor').priceFormat({
         prefix: 'R$ ',
         centsSeparator: ',',
         thousandsSeparator: '.'
     });

	//aplicando js nos selects menus futuros
	$("select[id^='professor_").selectmenu();
	$("#aplicacao").selectmenu();
	$("#instituicao").selectmenu();
	$('#valor').priceFormat({
         prefix: 'R$ ',
         centsSeparator: ',',
         thousandsSeparator: '.'
});

//	$("#instituicao").html(instituicao).selectmenu({
//		change: function(e, ui) {
//			e.preventDefault();
//			$.ajax({
//				type: 'POST',
//				dataType: "json",
//				async: false,
//				data: {instituicao:$(this).val()},
//				url: "/application/instituicao/buscainstituicao",
//				success: function(d) {
//					$("#instituicao_0").html(d.institicuicao)
//						.val("")
//						.selectmenu("refresh");
//				}
//			});
//		}
//});
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
	$("#novoParticipante").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();
		var cursoID = $("#curso").val();
		if(cursoID == ""){
			alert("Selecione um curso no menu acima");
			return false;
		}
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
			 var indice = empregadosSelecionados.indexOf(matricula); 
			 if(indice === -1){
				 empregadosSelecionados.push(matricula); 
			 }
			 else{
				 empregadosSelecionados.splice(indice, 1);
			 }
		});
}); 
	
//contador de elementos na tabela de participantes
	function adicionaEmpregado(){
		$.each(empregadosSelecionados, function (index, value){
			var aux = empregadosMap[value].split("&&&");
			if($("#excluirEmpregado_"+value).length == 0){
				tabelaEmp
				 .row
				 .add (["<input type= 'hidden' id= 'empregado' name= 'matricula[]' value = '"+value+"'>"+aux[0], aux[1], '<button id="excluirEmpregado_'+value+'">Remover empregado</button>'])
				 .draw();
				numeroParticipantes();
				$("#excluirEmpregado_"+value).button({
					icons: {
						primary: "ui-icon-trash",
				},
				text: false
				}).click(function(e) {
					e.preventDefault();
					if(confirm("Deseja realmente excluir?")) {
						tabelaEmp.row($(this).parents('tr')).remove().draw();
						numeroParticipantes();
						}
					});
				}
		});
}
	//Janela modal lista de espera
	var dialogEsperas = $("#modal-listaEspera").dialog({
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

	$("#novalistaEspera").button({
		icons : {
			primary : "ui-icon-plus",
		},
	}).on('click', function( e ) {
		e.preventDefault();	
		var cursoID = $("#curso").val();
		if (cursoID == ""){
			alert("Selecione um Curso no menu acima");
			return false;
		}
		empregadosSelecionados = [];
		$("#esperas").html(tabelaSelecaoParticipantes);
    	$("#selecaoParticipantes").DataTable({
    		"pageLength": 15,
    		"order": [[ 1, "asc" ]],
    		"bLengthChange": false,
    		"bInfo": false,
    	});
	
    	dialogEsperas.dialog("open");
    	
		$("#selecaoParticipantes tbody").on('click','tr',function(e){
			 var participanteID = $(this).find("#idParticipante").val();
			 $(this).toggleClass('selected');
			 var indice = empregadosSelecionados.indexOf(participanteID); 
			 if(indice === -1){
				empregadosSelecionados.push(participanteID);
			 }
			 else{
				empregadosSelecionados.splice(indice, 1);
			 }
		});
	});	
	$("#novaProgramacao").on('click',function(e){
		e.preventDefault();
		var cursoID = $("#curso").val();
		if (cursoID == ""){
			alert("Selecione um Curso no menu acima");
			return false;
		}
		var id = $("#tabelaProgramacao").dataTable().fnSettings().aoData.length + 1;
		tabelaProg.row.add([
			"<td><input type='text' style='width: 190px' id='dataRealizacao_"+id+"' name='dataRealizacao[]'></td>",
			"<td><input type='text' style='width: 250px' id='horaInicial_"+id+"' name='horaInicial[]'></td>",
			"<td><input type='text' style='width: 250px' id='horaFinal_"+id+"' name='horaFinal[]'></td>",
			"<td><input type='text' style='width: 500px' id='local_"+id+"' name='local[]'></td>",
			"<td><button id='removerProgramacao_"+id+"'>Remover</button>"
		]).draw();
		$("#removerProgramacao_"+id).button({
			icons: {
				primary: "ui-icon-trash",
			},
		text: false,
		});
		//calenadário
		$("#dataRealizacao_"+id).datepicker({
		    dateFormat: 'dd-mm-yy',
		    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
		    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
		    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
		    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
		    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
		    nextText: 'Próximo',
		    prevText: 'Anterior',			
		    showOn : "button",
			buttonImage : "/images/calendar.gif",
			buttonImageOnly : true,
			buttonText : "Selecione a data",
			showOtherMonths : true,
			selectOtherMonths : true,
			DateFormat : ["mm-dd-yyyy"]
		});
		//mascara da aba programação:
		 $('#dataRealizacao_'+id).mask('00-00-0000');
		 $('#horaInicial_'+id).mask('00:00');
		 $('#horaFinal_'+id).mask('00:00');
		var removerProg = $("#removerProgramacao_"+id).on('click',function(e){
			e.preventDefault();
			if(confirm("Deseja realmente excluir?")){
			var row = tabelaProg.row($(this).parents('tr')).remove().draw();
			atualizaId();
			}
		});
	});
	function atualizaId(){
		$.each($('input[id^="dataRealizacao_"]'), function (index, value){
			var arr = ($(this).attr('id')).split('_');
			var ind = (index + 1);
			if(arr[1] != ind){
				$(this).attr('id', 'dataRealizacao_'+ind);
				$("#horaInicial_"+arr[1]).attr('id', 'horaInicial_'+ind);
				$("#horaFinal_"+arr[1]).attr('id', 'horaFinal_'+ind);
				$("#local_"+arr[1]).attr('id', 'local_'+ind);
				$("#removerProgramacao_"+arr[1]).attr('id', 'removerProgramacao_'+ind);
			}
		});
		
	}
	$("button[id^='excluirEmpregado_']").button({
		icons: {
			primary: "ui-icon-trash",
	},
	text: false
	}).click(function(e) {
		e.preventDefault();
		if(confirm("Deseja realmente excluir?")) {
			tabelaEmp.row($(this).parents('tr')).remove().draw();
			numeroParticipantes();
			}
		});
	
	$("input[id^='dataRealizacao_']").datepicker({
	    dateFormat: 'dd-mm-yy',
	    dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
	    dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
	    dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
	    monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
	    monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
	    nextText: 'Próximo',
	    prevText: 'Anterior',			
	    showOn : "button",
		buttonImage : "/images/calendar.gif",
		buttonImageOnly : true,
		buttonText : "Selecione a data",
		showOtherMonths : true,
		selectOtherMonths : true,
		DateFormat : ["mm-dd-yyyy"]
	});
	

	 $("input[id^='dataRealizacao_']").mask('00-00-0000');
	 $("input[id^='horaInicial_']").mask('00:00');
	 $("input[id^='horaFinal_']").mask('00:00');
	
	$("button[id^='excluirProgramacao_']").button({
		icons: {
			primary: "ui-icon-trash",
	},
	text: false
	}).click(function(e){
		e.preventDefault();
		if(confirm("Deseja realmente excluir?")){
			tabelaProg.row($(this).parents('tr')).remove().draw();
			atualizaId();
		} 
	});
	function numeroParticipantes(){
		var contadorParticipantes = $("#tabelaParticipantes").dataTable().fnSettings().aoData.length;
		$("#contadorParticipante").html('<font size="4"> Numero de participantes: '+contadorParticipantes+'</font>');
	}
	
	$("#novoProfessor").on("click", function(e) {
		e.preventDefault();
		$("#professor_0").selectmenu("destroy");
		var novoProfessor = $("#professor_0").clone();
		novoProfessor.prop('selectedIndex', 0);
		var id = $("select[id^='professor_']").last().attr("id").split("_");
		var novoId = parseInt(id[1])+1;
		$(".professores").append("<br /><br />");
		novoProfessor.attr("id", "professor_"+novoId).appendTo(".professores").selectmenu();
		novoProfessor.attr("name", "professores[]");
		$("#professor_0").selectmenu();
	});
	
	$("#removerProfessor").on("click", function(e) {
		e.preventDefault();
		if ( $("select[id^='professor_']").length > 1) {
			$("select[id^='professor_']").last().remove();
			$(".professores").find('br').last().remove();
			$(".professores").find('br').last().remove();
		}
	});
});