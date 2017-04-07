<?php 
    class IndexController extends Controller{
    	public function __construct(){
    		parent::__construct();
    		Auth::redirectCheck(true);
    	}
        public function indexAction(){
           $this->view('login','',true,"generic");
        }
    }