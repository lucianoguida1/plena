<?php 
    class LoginController extends Controller{
    	public function __construct(){
    		parent::__construct();
    		Auth::redirectCheck(true);
    	}
        public function indexAction($msg="",$user=""){
            if($msg != "" && $user != ""){ $data['message'] = $msg; $data['user'] = $user;}else{ $data = "";}
            $this->view('Login',$data,true,'generic','',array(CSS.'animate.css'));
        }
        public function logarAction(){
    		$data=array();
    		//Validação
    		$validator=new Validator($_REQUEST);
    		$validator->field_filledIn();
            $validator->field_username('username');

    		if(!$validator->valid){
    			$data["message"]=$validator->getErrors();
    		}else{
    			//Tratamento
    			$super_global=DataHelper::tratamento($_REQUEST,INPUT_POST);

    			//Autenticação
    			$auth=new Auth;
    			$auth->login($super_global["username"],$super_global["password"]);
    			if($auth->check()){
    				$this->redirectTo(SITE."home");
    			}else{
    				$data["message"]=$auth->getErrors();
    			}
    		}
    		$this->view('Login',$data,true,'generic');
        }

        public function CadastroAction($msg =""){
            if($msg != ""){ $data['message'] = $msg; }else{ $data = "";}
            $this->view('Cadastro',$data,true,'generic');
        }
        public function SalvarAction(){
            $validetor = new Validator($_REQUEST);
            $validetor->field_filledIn($_REQUEST);
            $validetor->field_numeric('matricula');
            $validetor->field_cadastrado('matricula');
            $validetor->field_senhas('senha','senhac');
            if($validetor->valid){
                $credencial = Tools::hashHX($_REQUEST['senha']);
                $user['password'] = $credencial['password'];
                $user['salt'] = $credencial['salt'];
                $user['username'] = $_REQUEST['matricula'];
                $user['role'] = "user";
                $user['status'] = 1;
                $user['full_name'] = $_REQUEST['nome'];
                if(User::create($user)){
                    $this->indexAction(array('success','Usuario criado com sucesso!','Faça login com suas credenciais'),$_REQUEST['matricula']);
                }
            }else{
                $this->CadastroAction($validetor->getErrors());
            }
        }
        public function sairAction(){
        	Auth::logout();
        }
    }