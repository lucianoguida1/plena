<?php
class AjaxController extends Controller{
	public function EquipAction($tag=""){
		if($tag=="" && $_REQUEST['tag'] !=""){ $tag=$_REQUEST['tag'];}
		if(!empty(Equipamento::find_by_tag($tag))){
			echo Equipamento::find_by_tag($tag)->descricao;
		}
	}
	public function VerificaAction($tag=""){
		if($tag=="" && $_REQUEST['tag'] !=""){ $tag=$_REQUEST['tag'];}
		if(empty(Equipamento::find_by_tag($tag))){
			echo "true";
		}else{
			echo "false";
		}
	}
	public function pdfRegistroAction($id){
		$registro = Registro::find($id);
		if(!empty($registro) || $registro != null){
			$operantes = $registro->operantes;
			$equipamento = $registro->equipamento;
			$pecas = $registro->pecas;
			$dias = $registro->soma_dias >0?$registro->soma_dias." Dias e ":"";$n="";
			if(isset($registro->terceiros[0])){
				$terceiro = '<div class="well">
				<h4>Serviço de terceiros: '.$registro->terceiros[0]->empresa.'</h4>
				<h4>Descrição do serviço: '.$registro->terceiros[0]->descricao.'</h4>
				<h4>Valor do serviço: R$ '.$registro->terceiros[0]->valor.'</h4>
			</div>';
		}else{
			$terceiro ='';
		}
		$html = '
		<link rel="stylesheet" href="'.CSS.'bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'font-awesome.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'style.css" type="text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="'.JS.'bootstrap.min.js"></script>

		<style type="text/css">
			small{
				float: right;
				margin-top: -45px;
				font-size: 10pt;
			}
			h3{
				margin: 0px;
			}
			.list-group>a>span{
				float: right;
			}
			body{
				background: none;
			}
		</style>';
		$html .= '<div class="col-md-9 well">
		<fieldset>
			<legend><span class="label label-danger">'.$registro->parada.'</span><br>Manutenção '.$registro->tipo_servico.'<br><small>Registro: '.$registro->data->format('Y/m/d H:i:s').'</small></legend>
			<h4><strong>Equipamento:</strong> '.$equipamento->tag.'</h4>
			<p><strong>Motivação:</strong> '.$equipamento->descricao.'</p>
			<p><strong>Serviço realizado:</strong> '.$registro->descricao_servico.'</p>
			'.$terceiro.'		<p>Ocorrência dia: '.explode('-',$registro->data_inicio)[2].'/'.explode('-',$registro->data_inicio)[1].'/'.explode('-',$registro->data_inicio)[0].' às '.$registro->hora_inicio.'<br>Inicio da manutenção: '.explode('-',$registro->conserto_inicio)[2].'/'.explode('-',$registro->conserto_inicio)[1].'/'.explode('-',$registro->conserto_inicio)[0].' às '.$registro->hora_inicio_conserto.'		  <br>Fim: '.explode('-',$registro->data_termino)[2].'/'.explode('-',$registro->data_termino)[1].'/'.explode('-',$registro->data_termino)[0].' às '.$registro->hora_termino.'</p>
			<p>Tempo de execução do serviço: '.$dias.''.$registro->soma_horas.' Horas</p>
			<div class="col-md-4 col-md-offset-1 well well-sm">
				<h4>Pecas utilizadas:</h4>
				<p>';
					foreach($pecas as $val){ $html .= $val->quantidade." ".$val->peca.", ";}
					$html .= '</p>
				</div>
				<div class="col-md-4 col-md-offset-1 well well-sm">
					<h4>Operantes:</h4>
					<p>';
						foreach($operantes as $val){ $html .= $val->mecanico->nome.", ";}
						$html .= '</p>
					</div>
				</fieldset>
			</div>';
			$pdf = new mPDF();
			$pdf->allow_charset_conversion = true;
			$pdf->charset_in = "UTF-8";
			$pdf->WriteHTML($html);
			$pdf->Output($registro->tipo_servico.'-'.$registro->id.'.pdf','D');
		}else{
			echo "false";
		}
	}
	public function ParadaMesAllAction($mes="",$ano=""){
		$mes = $mes==''?date('m'):$mes;$view_mes = $mes;$data['ano']=$ano;
		$todos = Equipamento::find('all');
		foreach($todos as $equipamento){
			foreach($equipamento->registros as $val){
				$m = explode('-', $val->data_inicio)[1];
				$anoo = explode('-', $val->data_inicio)[0];
				if($m == $mes && $ano == $anoo){
					$view_equipamento[$equipamento->id] = $equipamento;
					$view_horas[$val->equipamento_id] = isset($view_horas[$val->equipamento_id])?$view_horas[$val->equipamento_id] + $val->horas_parada:$val->horas_parada;
					$view_quantidade[$val->equipamento_id] = (isset($data_quantidade[$val->equipamento_id])?$data_quantidade[$val->equipamento_id] + 1 : 1 );
					if(!isset($view_horaParada[$val->equipamento_id])){
						$view_horaParada[$val->equipamento_id] = 0;
					}
					if($val->parada != 'NULL'){
						$view_horaParada[$val->equipamento_id] += $val->horas_parada;
					}
				}
			}
		}
		$mes = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Agosto','Outubro','Novembro','Novembro');
		$html = '
		<link rel="stylesheet" href="'.CSS.'bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'font-awesome.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'style.css" type="text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="'.JS.'bootstrap.min.js"></script>
		<style type="text/css">
			small{
				float: right;
				margin-top: -45px;
				font-size: 10pt;
			}
			h3{
				margin: 0px;
			}
			.list-group>a>span{
				float: right;
			}
			body{
				background: none;
			}
			td,th{
				padding: 5px;
			}
			leagend{
				padding 15px;
			}
		</style>';
		$html .=	'<span>Relatorio com base no mês <b>'.$m.'/'.$anoo.'</b></span><div class="col-md-9 well">';
		if(empty($view_equipamento)){
		$html .= '<h3>Nenhum registro encontrado para esse equipamento neste mês.</h3>';
		}else{
		foreach($view_equipamento as $val){ 
		$html.='
			<div class="col-md-10 col-md-offset-1">
			<fieldset><hr><h3><b>'.$val->tag.'</b></h3><hr>
				<p>Quantidade de horas parada no mês de <i>'.$mes[$view_mes].'</i>: <strong>'.$view_horas[$val->id].' Horas</strong></p>';
				if($view_horaParada[$val->id] != 0){ $html .= '<p class="bg-danger" style="color: white;padding: 3px">Quantidade de horas que a produção ficou parada no mês de <i>'.$mes[$view_mes].'</i>: <strong>'.$view_horaParada[$val->id].' Horas</strong></p>'; } $html.= '
				<p>Foram feita(s) <strong>'.$view_quantidade[$val->id].'</strong> manutenção ou melhoria no equipamento no mês de '.$mes[$view_mes].'</p>
				<p>Mecânicos que execultaram alguma ação no equipamento:</p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nome(s)</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>';
						foreach($val->registros as $vall){ if(explode('-', $vall->data_inicio)[1] == $view_mes){
					$html.='<tr>
							<td>'; foreach($vall->operantes as $operante){ $html .='
								<p>'.$operante->mecanico->nome.'</p>';
								} $html .='</td>
								<td>'.$vall->data->format('d/m/Y H:i:s').'</td>
							</tr>';
							} } $html .='
						</tbody>
					</table>
				</fieldset>
			</div>';
			} } $html .='
		</div>';
			$pdf = new mPDF();
			$pdf->allow_charset_conversion = true;
			$pdf->charset_in = "UTF-8";
			$pdf->WriteHTML($html);
			$pdf->Output('Registro-'.substr(md5(date('sTy')),0,5).'.pdf','D');
	}
	public function paradaMesAction($equipamento="",$mes="",$ano=""){

		if($equipamento=="" || $mes == "" || $ano==""){echo "Ocorreu algum erro ao gera o pdf tente novamente!";}else{
			$view_idequipamento = $equipamento;$view_mes = $mes;$data['ano']=$ano;
			$registro = Equipamento::find($equipamento)->registros;
			foreach($registro as $val){
				$m = explode('-', $val->data_inicio)[1];
				$anoo = explode('-', $val->data_inicio)[0];
				if($m == $mes && $ano == $anoo){
					$view_equipamento[$val->equipamento_id] = $val->equipamento;
					$view_horas[$val->equipamento_id] = isset($view_horas[$val->equipamento_id])?$view_horas[$val->equipamento_id] + $val->horas_parada:$val->horas_parada;
					$view_quantidade[$val->equipamento_id] = (isset($view_quantidade[$val->equipamento_id])?$view_quantidade[$val->equipamento_id] + 1 : 1 );
					if(!isset($view_horaParada[$val->equipamento_id])){
						$view_horaParada[$val->equipamento_id] = 0;
					}
					if($val->parada != 'NULL'){
						$view_horaParada[$val->equipamento_id] += $val->horas_parada;
					}
				}
			}
		$mes = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Agosto','Outubro','Novembro','Novembro');
		$html = '
		<link rel="stylesheet" href="'.CSS.'bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'font-awesome.min.css" type="text/css">
		<link rel="stylesheet" href="'.CSS.'style.css" type="text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
		<script type="text/javascript" src="'.JS.'bootstrap.min.js"></script>
		<style type="text/css">
			small{
				float: right;
				margin-top: -45px;
				font-size: 10pt;
			}
			h3{
				margin: 0px;
			}
			.list-group>a>span{
				float: right;
			}
			body{
				background: none;
			}
			td,th{
				padding: 5px;
			}
			leagend{
				padding 15px;
			}
		</style>';
		$html .=	'
			<span>Relatorio com base no mês <b>'.$m.'/'.$anoo.'</b></span><div class="col-md-9 well">';
		if(empty($view_equipamento)){
		$html .= '<h3>Nenhum registro encontrado para esse equipamento neste mês.</h3>';
		}else{
		foreach($view_equipamento as $val){ 
		$html.='<div class="col-md-10 col-md-offset-1">
			<fieldset><hr><h3><b>'.$val->tag.'</b></h3><hr>
				<p>Quantidade de horas parada no mês de <i>'.$mes[$view_mes].'</i>: <strong>'.$view_horas[$val->id].' Horas</strong></p>';
				if($view_horaParada[$val->id] != 0){ $html .= '<p class="bg-danger" style="color: white;padding: 3px">Quantidade de horas que a produção ficou parada no mês de <i>'.$mes[$view_mes].'</i>: <strong>'.$view_horaParada[$val->id].' Horas</strong></p>'; } $html.= '
				<p>Foram feita(s) <strong>'.$view_quantidade[$val->id].'</strong> manutenção ou melhoria no equipamento no mês de '.$mes[$view_mes].'</p>
				<p>Mecânicos que execultaram alguma ação no equipamento:</p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Nome(s)</th>
							<th>Data</th>
						</tr>
					</thead>
					<tbody>';
						foreach($val->registros as $vall){ if(explode('-', $vall->data_inicio)[1] == $view_mes){
					$html.='<tr>
							<td>'; foreach($vall->operantes as $operante){ $html .='
								<p>'.$operante->mecanico->nome.'</p>';
								} $html .='</td>
								<td>'.$vall->data->format('d/m/Y H:i:s').'</td>
							</tr>';
							} } $html .='
						</tbody>
					</table>
				</fieldset>
			</div>';
			} } $html .='
		</div>';
			$pdf = new mPDF();
			$pdf->allow_charset_conversion = true;
			$pdf->charset_in = "UTF-8";
			$pdf->WriteHTML($html);
			$pdf->Output('RegistroEqp-'.substr(md5(date('sTy')),0,5).'.pdf','D');
		}
	}
}