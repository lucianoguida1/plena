<?php
	class AjaxController extends Controller{
		public function EquipAction($tag=""){
			if($tag=="" && $_REQUEST['tag'] !=""){ $tag=$_REQUEST['tag'];}
			if(!empty(Equipamento::find_by_tag($tag))){
				echo Equipamento::find_by_tag($tag)->descricao;
			}
		}
	}