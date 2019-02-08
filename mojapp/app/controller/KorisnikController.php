<?php

class KorisnikController{

public function __construct(){
    if(!Session::getInstance()->isLogiran()){
        $view = new View();
        $view->render('index',["poruka"=>"Nemate ovlasti"]);
        exit;
    }
}

 
    function index(){
        //echo "Hello";

        $view = new View();
        $view->render('korisnici/index',
        ["korisnici"=>Korisnik::read()
        ]
    );
    }


    function edit($id){
        $view = new View();
        $view->render(
            'korisnici/edit',
            [
            "korisnik"=>Korisnik::find($id)
            ]
        );
    }


}