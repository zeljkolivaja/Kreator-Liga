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
            $kontrola = $this->kontrola();
            if($kontrola===true){
            Table::add();
            $this->home();
        }else{
            $view = new View();
            $view->render(
                'tables/poruka',
                [
                "poruka"=>$kontrola
                ]
            );
    
    }
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
        $kontrola = $this -> kontrolaedit();
        if ($kontrola===true) {
            Table::update($id);
            $this->home();
        }else{
            $view = new View();
            $view->render(
                'tables/poruka',
                [
                "poruka"=>$kontrola
                ]
            );


        }
             
        }
        


        function kontrola()
        {
            if(Request::post("nameOfTeam")===""){
                return "Ime tima je obavezno";
            }
     
    
    
            if(strlen(Request::post("nameOfTeam"))>50){
                return "Ime tima ne smije biti veći od 50 znakova";
            }
     
    
            $db = Db::getInstance();
            $izraz = $db->prepare("select count(id) from leagueTable where nameOfTeam=:nameOfTeam and id<>:id");
            $izraz->execute(["nameOfTeam"=>Request::post("nameOfTeam"), "id" => $db->lastInsertId()]);
            $ukupno = $izraz->fetchColumn();
            if($ukupno>0){
                return "Naziv tima već postoji, odaberite drugi";
            }
    
            return true;
        }

        function kontrolaedit()
        {
            if(Request::post("nameOfTeam")===""){
                return "Ime tima je obavezno";
            }
     
    
    
            if(strlen(Request::post("nameOfTeam"))>50){
                return "Ime tima ne smije biti veći od 50 znakova";
            }
     
    
            $db = Db::getInstance();
            $izraz = $db->prepare("select count(id) from leagueTable where nameOfTeam=:nameOfTeam and id<>:id");
            $izraz->execute(["nameOfTeam"=>Request::post("nameOfTeam"), "id" => Request::post("id")]);
            $ukupno = $izraz->fetchColumn();
            if($ukupno>0){
                return "Naziv tima već postoji, odaberite drugi";
            }
    
            return true;
        }

    
        function insert()
        {
             
                Table::insert();
                $this->home();
     
    }
    


    function rezultati($id)
    {
        $view = new View();
        $view->render('tables/rezultati',
        ["tablica"=>Table::rezultati($id)
        ]
    );
    }

    

}