@extends('vendor.menu')

@section('content')


<div class="container-fluid" style="margin-bottom:2%;">
    <div class="row">
        <div class="col-md-8 ">
            <h1>Estatísticas</h1>
</div>

  
</div>
</div>
<div class="container-fluid">
    <div class="animated fadeIn">
      <div class="card-columns cols-2">
          @if(Auth::user()->hasAnyRole('professor'))
        <div class="card">
          <div class="card-header">
            Acertos e erros por sala
            <div class="card-actions">
              <a href="http://www.chartjs.org">
                <small class="text-muted">docs</small>
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="chart-wrapper">
              <canvas id="salas"></canvas>
            </div>
          </div>
        </div>
          @endif
      </div>
    </div>
  </div>

  

@endsection

@section('myscript')
<script>

    
        var dados = <?php echo $dados; ?>;
        console.log(dados);
    
        var salas = new Array();

        var perguntas = new Array();
        var acertos = new Array();
        var erros = new Array();
        
        let grafico;
        
        for(let i = 0; i < dados.length; i++){
            salas[i] = dados[i].sala_nome;
            console.log("sala " + dados[i].sala_nome)
            
            acertos[i] = dados[i].acertos;
            erros[i] = dados[i].erros;

            console.log("acertos " + acertos[i] + "\n erros "+erros[i])
            
            grafico = 'graficoTentativa' + i;
            
            console.log("\n\n\n\n\n\n\n\n\n\nGrafico "+grafico+"\n\n\n\n\n\n\n\n")
            
            var barChartData = {
			labels: salas,  //salas nomes
			datasets: [{
				label: 'Acertos',
				backgroundColor: 'rgba(0, 131, 25, 0.79)',
				data: acertos
			},{
				label: 'Erros',
				backgroundColor: 'rgba(255, 0, 0, 0.67)',
				data: erros
			}]

		};
		window.onload = function() {
			var ctx = document.getElementById('salas').getContext('2d');
			window.myBar = new Chart(ctx, {
				type: 'horizontalBar',
				data: barChartData,
				options: {
					title: {
						display: true,
						//text: 'Tentativas para acerto das perguntas por alunos'
						text: 'Acertos e erros na 1ª tentativa por sala '
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