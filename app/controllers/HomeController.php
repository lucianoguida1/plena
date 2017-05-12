<?php
	class HomeController extends Controller{
		public function __construct(){
			parent::__construct();
			Auth::redirectCheck();
		}
		public function indexAction($cad=null){
			if(!is_null($cad)){
				if($cad == "true"){
					$data['message']=array('success','Registro enviado com sucesso!');
				}elseif($cad == "exc"){
					$data['message']=array('success','Registro excluido com sucesso!');
				}
			}else{$data=null;}
			$this->view('Home',$data,true);
		}
	}