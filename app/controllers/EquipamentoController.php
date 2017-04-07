<?php
class EquipamentoController extends Controller{
	public function __construct(){
    		parent::__construct();
    		Auth::redirectCheck();
    	}
	public function ListarAction($msg=""){
		if($msg!=""){$data['message'] = $msg;}else{$data = "";}
		$this->view("ListEquipamento",$data,true);
	}
	public function CadastrarAction($msg=""){
		if($msg != ""){ $data['message'] = $msg;}else{ $data = "";}
		$this->view("cadastroEquipamento",$data,true);
	}
	public function SalvarAction(){
		if(!empty($_REQUEST['tag']) && !empty($_REQUEST['desEquip'])){
			if(empty(Equipamento::find_by_tag($_REQUEST['tag']))){
				if(Equipamento::create(array('tag'=>$_REQUEST['tag'],'descricao'=>$_REQUEST['desEquip']))){
					$this->CadastrarAction(array('success','Equipamento cadastrado com suscesso.'));
				}else{
					$this->CadastrarAction(array('danger','Ocorreu algum erro durante o cadastro. Tente Novamente!','Caso o problema pressista contate o administrador!'));
				}
			}else{
				$this->CadastrarAction(array('danger','TAG já cadastrada!','Esta TAG: <b>'.Equipamento::find_by_tag($_REQUEST['tag'])->tag.'</b> esta cadastrada. Descricão:<b>'.Equipamento::find_by_tag($_REQUEST['tag'])->descricao.'</b>.'));
			}
		}
	}
	public function DeleteAction($msg=""){
		if($msg!=""){$data['message'] = $msg;}else{$data = "";}
		if(isset($_REQUEST['id']) && $msg=="") {
			$mec = Equipamento::find($_REQUEST['id']);
			if($mec->delete()){
				$this->DeleteAction(array('success','Equipamento <b>'.$mec->tag.'</b> deletado com sucesso!'));$_REQUEST=null;
			}else{
				$this->DeleteAction(array('danger','Ocorreu algum erro durante a exclusão.','Caso o problema presista contate o administrador'));$_REQUEST=null;
			}
		}
		$this->view("DeleteEquipamento",$data,true);
	}
}