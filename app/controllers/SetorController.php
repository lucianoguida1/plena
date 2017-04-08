<?php 

	class SetorController extends Controller{
		public function IndexAction(){
			$data['setores'] = Setor::all();
			$this->view("setores",$data);
		}
		public function CadastrarAction(){
			if(empty($_POST)){
				$this->view("SetorCadastrar");
			}elseif($_POST['nome'] != ""){
				if(Setor::create(array('nome'=>$_POST['nome']))){
					$this->view("SetorCadastrar",array('message'=>array('success','O setor <b>'.$_POST['nome'].'</b> foi cadastrado com sucesso!')));
				}else{
					$this->view("SetorCadastrar",array('message'=>array('danger','Erro ao cadastrar, tente novamente.<br> Caso o problema pressista contate o administrador!')));
				}
			}else{
				$this->IndexAction();
			}
		}
		public function AlterarAction($id=''){
			if(empty($_POST)){
				$data['setores'] = $id==""?Setor::all():Setor::find('all',array('conditions'=>array('id ='.$id)));
				$this->view("SetorAlterar",$data);
			}elseif(isset($_POST['nome']) && isset($_POST['id'])){
				$setor = Setor::find($_POST['id']);
				if(!empty($setor)){
					$setor->nome = $_POST['nome'];
					$setor->save();
					$this->view("SetorAlterar",array('message'=>array('success','O setor <b>'.$_POST['nome'].'</b> foi alterado com sucesso!')));
				}else{
					$this->view("SetorCadastrar",array('message'=>array('danger','Erro ao cadastrar, tente novamente.<br> Caso o problema pressista contate o administrador!')));
				}
			}else{
				$this->IndexAction();
			}
		}
		public function DeletarAction($id=''){
			if(empty($_POST)){
				$data['setores'] = Setor::all();
				$this->view("SetorDeletar",$data);
			}elseif(isset($_POST['id'])){
				$setor = Setor::find($_POST['id']);
				if(!empty($setor)){
					$setor->delete();
					$this->view("SetorDeletar",array('message'=>array('success','O setor <b>'.$setor->nome.'</b> foi alterado com sucesso!')));
				}else{
					$this->view("SetorDeletar",array('message'=>array('danger','Erro ao cadastrar, tente novamente.<br> Caso o problema pressista contate o administrador!')));
				}
			}else{
				$this->IndexAction();
			}
		}
	}