<?php

class LigaController{

    public function __construct(){
        if(!Session::getInstance()->isLogiran()){
            $view = new View();
            $view->render('index',["poruka"=>"Nemate ovlasti"]);
            exit;
        }
    }

   
    function index(){
        $view = new View();
        $view->render(
            'lige/index',
            [
            "popis"=>Popis::read()
            ]
        );
    }
    function delete($id)
{
        Popis::delete($id);
        $this->index();
       
        

}




function prepareadd()
{
    $view = new View();
    $view->render(
        'lige/novaliga',
        [
         "vrstasporta"=>Popis::readgametype()
        
          ]
    );
}
 




function add()
{
        Popis::add();
        $this->index();
}





 
}
 