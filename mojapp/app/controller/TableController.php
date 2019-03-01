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

 
    function index($id)
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



     

    function prepareedit($id)
    {
        $view = new View();
        $korisnik = Table::find($id);
        $_POST["id"]=$korisnik->id;
        $_POST["nameOfTeam"]=$korisnik->nameOfTeam;
        $_POST["totalPoints"]=$korisnik->totalPoints;
        $_POST["totalGoalsScored"]=$korisnik->totalGoalsScored;
        $_POST["totalGoalsConceded"]=$korisnik->totalGoalsConceded;
        $_POST["league"]=$korisnik->league;
    
    
        $view->render(
            'tables/edit',
            [
            "poruka"=>""
            ]
        );
    }
    



    function edit($id)
    {
        $_POST["id"]=$id;
        Table::update($id);
        $this->home();

      
             
        }

}