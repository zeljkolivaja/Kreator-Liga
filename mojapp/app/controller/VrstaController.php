<?php

class VrstaController
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
            'vrsteigara/index',
            [
            "vrste"=>Vrste::read()
            ]
        );
    }

    function prepareadd()
    {
        $view = new View();
        $view->render(
            'vrsteigara/novisport',
            [
                "poruka"=> ""
    
            ]
        );
    }

    function add()
    {

            $kontrola = $this->kontrolaadd();
            if($kontrola===true){
            Vrste::add();
            $this->index();


        }else{
            $view = new View();
            $view->render(
                'vrsteigara/novisport',
                [
                "poruka"=>$kontrola
                ]
            );
    
    }
}

    function prepareedit($id)
    {
    $view = new View();
    $view->render(
        'vrsteigara/edit',
         [
            "podaci1"=>Vrste::readSport($id)

          ]
     );
    }


    function edit()
    {
         $kontrola = $this ->kontrolaEdit();
        if ($kontrola===true) {
            Vrste::update();
            $this->index();
        }else{ 
            $ime = Request::post("id");
            $view = new View();
            $view->render(
                'vrsteigara/poruka', 
                [
                "poruka"=>$kontrola,
                "id"=>$ime
                ]
            );
        }               
    }


    function delete($id)
    {
            Vrste::delete($id);
            $this->index();
    }




    function kontrolaadd()
    {
       if(Request::post("gameName")===""){
           return "Ime sporta je obavezno";
       }

       if(Request::post("pointsPerWin")==="" or Request::post("pointsPerDraw")==="" or Request::post("pointsPerLoss")==="" ){
        return "Bodovi su obavezni";
    }

       $db = Db::getInstance();
       $izraz = $db->prepare("select count(id) from gameType where gameName=:gameName");
       $izraz->execute(["gameName"=>Request::post("gameName")]);
       $ukupno = $izraz->fetchColumn();
       if($ukupno>0){
           return "Naziv sporta već postoji, odaberite drugi";
       }



       return true;
    }



    function kontrolaEdit()
    {
       if(Request::post("gameName")===""){
           return "Ime sporta je obavezno";
       }

       if(Request::post("pointsPerWin")==="" or Request::post("pointsPerDraw")==="" or Request::post("pointsPerLoss")==="" ){
        return "Bodovi su obavezni";
    }

       $db = Db::getInstance();
       $izraz = $db->prepare("select count(id) from gameType where gameName=:gameName and id!=:id");
       $izraz->execute(["gameName"=>Request::post("gameName"),"id"=>Request::post("id")]);
       $ukupno = $izraz->fetchColumn();
       if($ukupno>0){
           return "Naziv sporta već postoji, odaberite drugi";
       }



       return true;
    }



    }
 