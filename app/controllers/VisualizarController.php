<?php
	class VisualizarController extends Controller{
		public function __construct(){
    		parent::__construct();
    		Auth::redirectCheck();
    	}
		Public function IndexAction(){
			$this->view('Home');
		}
		Public function ViewAction($id){
			if(!empty(Registro::find($id))){
				$data['registro'] = Registro::find($id);
				$data['operantes'] = $data['registro']->operantes;
				$data['equipamento'] = $data['registro']->equipamento;
				$data['pecas'] = $data['registro']->pecas;
				$this->view('Visualizar',$data);
			}
		}
		public function paradaMesAction($equipamento="",$mes="",$ano=""){
			if($equipamento=="" || $mes == "" || $ano =="" ){$this->IndexAction();}else{
			$data['idequipamento'] = $equipamento;$data['mes'] = $mes;$data['ano']=$ano;
			$registro = Equipamento::find($equipamento)->registros;
			foreach($registro as $val){
				$m = explode('-', $val->data_inicio)[1];
				$anoo = explode('-', $val->data_inicio)[0];
				if($m == $mes && $ano == $anoo){
					$data['equipamento'][$val->equipamento_id] = $val->equipamento;
					$data['horas'][$val->equipamento_id] = isset($data['horas'][$val->equipamento_id])?$data['horas'][$val->equipamento_id] + $val->horas_parada:$val->horas_parada;
					$data['quantidade'][$val->equipamento_id] = (isset($data['quantidade'][$val->equipamento_id])?$data['quantidade'][$val->equipamento_id] + 1 : 1 );
					if(!isset($data['horaParada'][$val->equipamento_id])){
						$data['horaParada'][$val->equipamento_id] = 0;
					}
					if($val->parada != 'NULL'){
						$data['horaParada'][$val->equipamento_id] += $val->horas_parada;
					}
				}
			}
			$this->view('RegistroMes',$data);
			}
		}
		public function paradaMesAllAction($mes='',$ano=""){
			$mes = $mes==''?date('m'):$mes;$data['mes'] = $mes;$data['ano']=$ano;
			$todos = Equipamento::find('all');
			foreach($todos as $equipamento){
				foreach($equipamento->registros as $val){
					$m = explode('-', $val->data_inicio)[1];
					$anoo = explode('-', $val->data_inicio)[0];
					if($m == $mes &&  $ano == $anoo){
						$data['equipamento'][$equipamento->id] = $equipamento;
						$data['horas'][$val->equipamento_id] = isset($data['horas'][$val->equipamento_id])?$data['horas'][$val->equipamento_id] + $val->horas_parada:$val->horas_parada;
						$data['quantidade'][$val->equipamento_id] = (isset($data['quantidade'][$val->equipamento_id])?$data['quantidade'][$val->equipamento_id] + 1 : 1 );
						if(!isset($data['horaParada'][$val->equipamento_id])){
							$data['horaParada'][$val->equipamento_id] = 0;
						}
						if($val->parada != 'NULL'){
							$data['horaParada'][$val->equipamento_id] += $val->horas_parada;
						}
					}
				}
			}
			$this->view('RegistroMesAll',$data);
		}
	}