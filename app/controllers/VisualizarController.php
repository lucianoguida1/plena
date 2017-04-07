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
	}