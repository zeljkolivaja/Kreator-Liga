<?php

class KorisnikController
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
        //echo "Hello";

        $view = new View();
        $view->render('korisnici/index',
        ["korisnici"=>Korisnik::read()
        ]
        );
    }



    function delete($id)
    {
            Korisnik::delete($id);
            $this->index();
    }



    function kontrola()
    {
        if(Request::post("username")===""){
            return "Korisničko ime je obavezno";
        }

        if(Request::post("firstName")===""){
            return "Ime je obavezno";
        }

        if(Request::post("lastName")===""){
            return "Prezime je obavezno";
        }



        if(strlen(Request::post("username"))>50){
            return "Korisničko ime ne smije biti veći od 50 znakova";
        }

        $db = Db::getInstance();
        $izraz = $db->prepare("select count(id) from users where username=:username and id<>:id");
        $izraz->execute(["username"=>Request::post("username"), "id" => Request::post("id")]);
        $ukupno = $izraz->fetchColumn();
        if($ukupno>0){
            return "Ime postoji, odaberite drugo";
        }


        return true;
    }


    function prepareEdit($id)
    {
        $view = new View();
        $korisnik = Korisnik::find($id);
        $_POST["administrator"]=$korisnik->administrator ? "on" : "";
        $_POST["firstName"]=$korisnik->firstName;
        $_POST["lastName"]=$korisnik->lastName;
        $_POST["username"]=$korisnik->username;
        $_POST["id"]=$korisnik->id;

        $view->render(
            'korisnici/edit',
            [
            ]
        );
    }


    function prepareAdd()
    {
        $view = new View();
        $view->render(
            'korisnici/novikorisnik',
            [
            "poruka"=>""
            ]
        );
    }

    function add()
    {
        
        $kontrola = $this->kontrola();
        if($kontrola===true){
            Korisnik::add();
            $this->index();
        }else{
            $view = new View();
            $view->render(
                'korisnici/novikorisnik',
                [
                "poruka"=>$kontrola
                ]
            );
        }

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