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
    $kontrola = $this->kontrola();
    if($kontrola===true){
        Popis::add();
        $this->index();
    }else{    $view = new View();
        $view->render(
            'lige/poruka',
            [
            "poruka"=>$kontrola
            ]
        );
    }
}

function prepareedit($id)
{
    $view = new View();
    $korisnik = Popis::find($id);
    $_POST["nameOfLeague"]=$korisnik->nameOfLeague;
    $_POST["users"]=$korisnik->users;
    $_POST["description"]=$korisnik->description;
    $_POST["gameType"]=$korisnik->gameType;
    $_POST["id"]=$korisnik->id;


    $view->render(
        'lige/edit',
        [
        "poruka"=>""
        ]
    );
}



function edit($id)
{
    $_POST["id"]=$id;
    $kontrola = $this->kontrola();
    if($kontrola===true){
    Popis::update($id);
    $this->index();
}else{
    $view = new View();
    $view->render(
        'lige/poruka',
        [
        "poruka"=>$kontrola
        ]
    );
}
}
    function kontrola()
    {
        if(Request::post("nameOfLeague")===""){
            return "Ime lige je obavezno";
        }

        if(Request::post("gameType")===""){
            return "Vrsta igre je obavezna";
        } 



        if(strlen(Request::post("nameOfLeague"))>50){
            return "Ime lige ne smije biti veći od 50 znakova";
        }
 

        // $db = Db::getInstance();
        // $izraz = $db->prepare("select count(id) from users where username=:username and id<>:id");
        // $izraz->execute(["username"=>Request::post("username"), "id" => Request::post("id")]);
        // $ukupno = $izraz->fetchColumn();
        // if($ukupno>0){
        //     return "Ime postoji, odaberite drugo";
        // }


        return true;
    }

 
}
 