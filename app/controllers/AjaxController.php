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
			'.$terceiro.'		<p>Ocorrência dia: '.explode('-',$registro->data_inicio)[2].'/'.explode('-',$registro->data_inicio)[1].'/'.explode('-',$registro->data_inicio)[0].' as '.$registro->hora_inicio.'<br>Inicio da manutenção: '.explode('-',$registro->conserto_inicio)[2].'/'.explode('-',$registro->conserto_inicio)[1].'/'.explode('-',$registro->conserto_inicio)[0].' as '.$registro->hora_inicio_conserto.'		  <br>Fim: '.explode('-',$registro->data_termino)[2].'/'.explode('-',$registro->data_termino)[1].'/'.explode('-',$registro->data_termino)[0].' as '.$registro->hora_termino.'</p>
			<p>Seviço demorou '.$dias.''.$registro->soma_horas.' Horas</p>
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
}