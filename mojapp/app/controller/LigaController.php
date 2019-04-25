<?php

class LigaController
{

    public function __construct()
    {
        if(!Session::getInstance()->isLogiran()){
            $view = new View();
            $view->render('index',["poruka"=>"Nemate ovlasti"]);
            exit;
        }
    }


    function index()
    {
        $view = new View();
        $view->render(
            'lige/index',
            [
            "popis"=>Popis::read()
            ]
        );
    }

    function index2()
    {
        $view = new View();
        $view->render(
            'lige2/index',
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

    function delete2($id)
    {
        Popis::delete($id);
        $this->index2();      
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


    function prepareadd2()
    {
    $view = new View();
    $view->render(
        'lige2/novaliga',
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

    function add2()
    {
    $kontrola = $this->kontrola();
    if($kontrola===true){
        Popis::add();
        $this->index2();
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
            "tablica"=>Table::read($id)

          ]
     );
    }



    function prepareedit2($id)
    {
    $view = new View();
    $korisnik = Popis::find($id);
    $_POST["nameOfLeague"]=$korisnik->nameOfLeague;
    $_POST["users"]=$korisnik->users;
    $_POST["description"]=$korisnik->description;
    $_POST["gameType"]=$korisnik->gameType;
    $_POST["id"]=$korisnik->id;

    $view->render(
        'lige2/edit',
         [
            "tablica"=>Table::read($id)

          ]
     );
    }























    function edit($id)
    {
    $_POST["id"]=$id;
    $kontrola = $this->kontrolaedit();
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




    function edit2($id)
    {
    $_POST["id"]=$id;
    $kontrola = $this->kontrolaedit();
    if($kontrola===true){
    Popis::update($id);
    $this->index2();
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
 

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(id) from league where nameOfLeague=:nameOfLeague and id<>:id");
        $izraz->execute(["nameOfLeague"=>Request::post("nameOfLeague"), "id" => $db->lastInsertId()]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Naziv postoji, odaberite drugi";
        }

        return true;
    }


    function kontrolaedit()
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
 

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(id) from league where nameOfLeague=:nameOfLeague and id<>:id");
        $izraz->execute(["nameOfLeague"=>Request::post("nameOfLeague"), "id" =>Request::post("id")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Naziv postoji, odaberite drugi";
        }

        return true;
    }
}
 