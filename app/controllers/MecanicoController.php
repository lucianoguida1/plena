<?php 
Class MecanicoController extends Controller{
	public function __construct(){
    		parent::__construct();
    		Auth::redirectCheck();
    	}
	public function CadmecanicoAction($msg=""){
		if($msg != ""){ $data['message'] = $msg;}else{ $data = "";}
		$this->view('cadmecanico',$data,true);
	}
	public function SalvarmAction(){
		if(isset($_REQUEST) && $_REQUEST['inscricao'] > 0 && !empty($_REQUEST['nome'])){
			if(empty(Mecanico::find_by_inscricao($_REQUEST['inscricao']))){
				if(Mecanico::create(array('inscricao'=>$_REQUEST['inscricao'],'nome'=>$_REQUEST['nome']))){
					$this->CadmecanicoAction(array('success','Mecanico <b>'.Mecanico::last()->nome.'</b> cadastrado com sucesso!','Apartir de agora podera atribuir serviços a ele como operante.'));
				}
			}else{
				$this->CadmecanicoAction(array('danger','Matricula já cadastrada!','Esta matricula esta cadastrada para o mecanico <b>'.Mecanico::find_by_inscricao($_REQUEST['inscricao'])->nome.'</b>.'));
			}
		}
	}
	public function RemovermecAction($msg=""){
		if($msg != ""){ $data['message'] = $msg;}else{ $data = "";}
		if(isset($_REQUEST['id']) && $msg=="") {
			$mec = Mecanico::find($_REQUEST['id']);
			if($mec->delete()){
				$this->RemovermecAction(array('success','Mecanico <b>'.$mec->nome.'</b> deletado com sucesso!'));$_REQUEST=null;
			}else{
				$this->RemovermecAction(array('danger','Ocorreu algum erro durante a exclusão.','Caso o problema presista contate o administrador'));$_REQUEST=null;
			}
		}
		$this->view('exmecanico',$data,true);
	}
}