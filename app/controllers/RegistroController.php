<?php
Class RegistroController extends Controller{
	public function __construct(){
		parent::__construct();
		Auth::redirectCheck();
	}
	public function SalvarAction(){
		$datatime1 = new DateTime($_REQUEST['datainicio'].' '.$_REQUEST['horainicio'].':00');
		$datatime2 = new DateTime($_REQUEST['datafim'].' '.$_REQUEST['horafim'].':00');
		$data1  = $datatime1->format('Y-m-d H:i:s');
		$data2  = $datatime2->format('Y-m-d H:i:s');
		$diff = $datatime1->diff($datatime2);
		$equipamento = Equipamento::find_by_tag($_REQUEST['tag']);
		if(empty($equipamento)){
			Equipamento::create(array('tag'=>$_REQUEST['tag'],'descricao'=>$_REQUEST['desEquip'],'setor_id'=>$_REQUEST['setor']));
			$equipamento = Equipamento::last();
		}
		$registro = array(
			"tipo_servico"=>$_REQUEST['tiposervico'],
			"descricao_servico"=>$_REQUEST['desServico'],
			"data_inicio"=>$_REQUEST['datainicio'],
			"hora_inicio"=>$_REQUEST['horainicio'],
			"data_termino"=>$_REQUEST['datafim'],
			"hora_termino"=>$_REQUEST['horafim'],
			"soma_dias"=>$diff->days,
			"soma_horas"=>$diff->h,
			"parada"=>isset($_REQUEST['parada'])?$_REQUEST['parada']:false,
			//"causas"=>$_REQUEST[''],
			//"horas_parada"=>$_REQUEST[''],
			"equipamento_id"=>$equipamento->id,
			"user_id"=>Auth::userActive()->id,
			"status" => 1
			);$sair=true;$i=1;
		if(Registro::create($registro)){
			while($sair == true){
				if(isset($_REQUEST["peca".$i])){
					if($_REQUEST['peca'.$i] != "" && $_REQUEST["qnt".$i] !=""){
						Peca::create(array('peca'=>$_REQUEST["peca".$i],'quantidade'=>$_REQUEST["qnt".$i],'registro_id'=>Registro::last()->id));
					}
					$i++;
				}else{
					$sair=false;
				}
			}$sair=true;$i=1;
			while($sair == true){
				if(isset($_REQUEST["nome".$i])){
					if(!empty(Mecanico::find($_REQUEST['nome'.$i]))){
						Operante::create(array('mecanico_id'=>$_REQUEST['nome'.$i],'registro_id'=>Registro::last()->id));
						
					}
					$i++;
				}else{
					$sair=false;
				}
			}
			header("location:".SITE."home/index/true");
		}
	}
	public function IndexAction($id=""){
		if($id != ""){	$data['dados'] = Equipamento::find($id); }else{$data="";}
		$this->view('formregistro',$data,true);
	}
	public function ExcluirAction($id=""){
		$id = (int)$id;
		if(!empty(Registro::find($id))){
			$reg = Registro::find($id);
			$reg->status = 2;
			$reg->save();
			header('location:'.SITE.'home/index/exc');
		}else{
			header('location:'.SITE.'visualizar/view/'.$id);
		}
	}

	public function CadastrarAction($msg=""){
		if($msg != ""){ $data['message'] = $msg;}else{ $data = "";}
		$data['setores'] = Setor::all();
		$this->view('formregistro',$data,true);
	}
}