<?php
	class UsuariosController extends Controller{
		public function EditarAction($id,$msg = ""){
			if($msg != ""){ $data['message'] = $msg;}else{ $data = "";}
			if(!empty($id)){
				$usr = User::find($id);
				if($usr->id == Auth::userActive()->id){
					$data['user'] = $usr;
					$this->view("Editar",$data);
				}else{
					header('location:'.SITE);
				}
			}else{
				header("location:".SITE);
			}
		}
		public function SalvarAction(){
			if(!empty($_REQUEST)){
				$validetor = new Validator($_REQUEST);
	            $validetor->field_filledIn($_REQUEST);
	            $validetor->field_numeric('matricula');
	            $validetor->field_cadastrado2('matricula');
	            $validetor->field_senhas('senha','senhac');
	            if($validetor->valid){
	                $credencial = Tools::hashHX($_REQUEST['senha']);
	                $user['password'] = $credencial['password'];
	                $user['salt'] = $credencial['salt'];
	                $user['username'] = $_REQUEST['matricula'];
	                $user['role'] = "user";
	                $user['status'] = 1;
	                $user['full_name'] = $_REQUEST['nome'];
	                $usu = Auth::userActive();
	                if($usu->update_attributes($user)){
	                    $this->EditarAction(Auth::userActive()->id,array('success','Usuario alterado com sucesso!','Seus dados foram alterado não se esqueça da sua matricula e senha'),$_REQUEST['matricula']);
	                }
	            }else{
	                $this->EditarAction(Auth::userActive()->id,$validetor->getErrors());
	            }
			}
		}
	}