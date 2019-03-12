<?php
class AdminController
{
    function prijava()
    {
    $view = new View();
        $view->render('prijava',["poruka"=>""]);
    }

    function login()
    {
         

        $db=Db::getInstance();
        $izraz = $db->prepare("select id,firstName,lastName,username,password from users where username=:username");
        $izraz->execute(["username"=>Request::post("username")]);

        $view = new View();

        if($izraz->rowCount()>0){
            $red=$izraz->fetch();
            if(password_verify(Request::post("password"),$red->password)){
                $user = new stdClass();
                $user->id=$red->id;
                $user->firstName=$red->firstName;
                $user->lastName=$red->lastName;
                $user->username=$red->username;
                $user->firstNamelastName=$red->firstName . " " . $red->lastName;

                Session::getInstance()->login($user);

                $view->render('index',["poruka"=>"Uspješno prijavljen"]);
            }else{
                $view->render('prijava',["poruka"=>"Kombinacija usera i lozinke ne odgovaraju"]);
            }
        }else{
            $view->render('prijava',["poruka"=>"Ne postojeći email"]);
        }

        

         
        
    }

    function odjava()
    {

        Session::getInstance()->odjava();
        $view = new View();
        $view->render('index',["poruka"=>""]);
    }
}