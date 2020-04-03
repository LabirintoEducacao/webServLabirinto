@extends('vendor.menu')

@section('content')

<form>
     <div class="form-check">
        <label class="form-check-label">

            <input class="form-check-input" type="checkbox" id="qntdeRespPerg" checked>
            Quantidade de respostas por pergunta
            <span class="form-check-sign">
                <span class="check"></span>
            </span>
        </label>
    </div>
    <br>
     <div class="form-check">
        <label class="form-check-label">

            <input class="form-check-input" type="checkbox" id="qntdeTentativas" checked>
            Tentativas para acerto das perguntas por alunos
            <span class="form-check-sign">
                <span class="check"></span>
            </span>
        </label>
    </div>

</form>



<!--
<div style="display:none" id="qntdeRespPergDiv">
    
    <h4>Quantidade de respostas por pergunta</h4>

    <div style="width: 50%">
        {!! $usersChart->container() !!}
    </div>
    
</div>
-->



<div class="row">
    <div style="display:block" id="qntdeRespPergDiv" class="col-5">

        <h4 style="text-align:center">Quantidade de respostas por pergunta</h4>

        <div style="width: 95%">
            {!! $usersChart->container() !!}
        </div>

    </div>
    
     <div style="display:block" id="qntdeTentativasDiv" class="col-5 offset-1">
        <h4 style="text-align:center">Tentativas para acerto das perguntas por alunos</h4>
        <canvas id="graficoTentativa0" width="400" height="400"></canvas>   
    </div>

</div>



@endsection

@section('myscript')

<script>

    
        var salas = <?php echo $acertos; ?>;
        console.log(salas);

        var perguntas = new Array();
        var qtd0 = new Array();
        var qtd1 = new Array();
        var qtd2 = new Array();
        let grafico;
        
        
        for(var i = 0; i < salas.length; i++){
            sala = salas[i].sala_nome;
            console.log("sala " + salas[i].sala_nome)
            for(var j = 0; j<salas[i].sala_pergs.length; j++){
                perguntas[j] = salas[i].sala_pergs[j].pergunta;
                
                qtd0[j] = salas[i].sala_pergs[j].wrong_count.qtd0;
                
                console.log("qtd0 " + qtd0[j])
                
                qtd1[j] = salas[i].sala_pergs[j].wrong_count.qtd1;
                
                console.log("qtd1 " + qtd1[j])
                
                qtd2[j] = salas[i].sala_pergs[j].wrong_count.qtd2;
                
                console.log("qtd2 " + qtd2[j])
                
            }
            
//            document.getElementById("graficosTentativa").append('<canvas id="graficoTentativa'+i+'" width="400" height="400"></canvas>');
            
            grafico = 'graficoTentativa' + i;
            
            console.log("\n\n\n\n\n\n\n\n\n\nGrafico "+grafico+"\n\n\n\n\n\n\n\n")
            
            var barChartData = {
			labels: perguntas,  //perg nomes
			datasets: [{
				label: '1ª tentativa',
				backgroundColor: 'rgba(0, 131, 25, 0.79)',
				data: qtd0
			}, {
				label: '2ª tentativa',
				backgroundColor: 'rgba(245, 255, 0, 0.74)',
				data: qtd1
			}, {
				label: '3ª tentativa',
				backgroundColor: 'rgba(255, 0, 0, 0.67)',
				data: qtd2
			}]

		};
		window.onload = function() {
			var ctx = document.getElementById('graficoTentativa0').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'horizontalBar',
				data: barChartData,
				options: {
					title: {
						display: true,
						//text: 'Tentativas para acerto das perguntas por alunos'
						text: 'Sala ' + sala
					},
					tooltips: {
						mode: 'index',
						intersect: false
					},
					responsive: true,
					scales: {
						xAxes: [{
							stacked: true,
						}],
						yAxes: [{
							stacked: true
						}]
					}
				}
			});
		};
            
            
            
            
            
        }
//        salas.forEach(function(sala, index){
//    
//            var sala = sala.sala_nome;
//            (sala.sala_pergs).forEach(function(perguntas, index){
//    
//                perguntas[i] = perguntas.pergunta;
//                
//                qtd0[i] = perguntas.wrong_count.qtd0;
//                qtd1[i] = perguntas.wrong_count.qtd1;
//                qtd2[i] = perguntas.wrong_count.qtd2;
//
//            });
//
//        });
    
   


</script>


@endsection