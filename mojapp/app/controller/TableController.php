<?php

class TableController{

public function __construct()
{
    if(!Session::getInstance()->isLogiran()){
        $view = new View();
        $view->render('index',["poruka"=>"Nemate ovlasti"]);
        exit;
    }
}

 
    function index($id=5)
    {
        $view = new View();
        $view->render('tables/index',
        ["tablica"=>Table::read($id)
        ]
    );
    }
    

    function delete($id)
    {
            Table::delete($id);
            $this->home();
    }



    function prepareadd($id)
    {
        $view = new View();
        $view->render(
            'tables/noviklub',
            [
            "poruka"=>$id
            ]
        );
    }


    function add()
    {
            Table::add();
            $this->home();
 
    }

    
    function home(){
        $view = new View();
        $view->render(
            'lige/index',
            [
            "popis"=>Popis::read()
            ]
        );
    }




    function edit($id)
    {
        $_POST["id"]=$id;
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Korisnik::update($id);
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'korisnici/edit',
                [
                "poruka"=>$kontrola
                ]
            );
        }

    }

}
