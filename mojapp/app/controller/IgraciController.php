<?php

class IgraciController
{
    function index()
    {
        $view = new View();
        $view->render(
            'igraci/index',
            [
            "popis"=>Igraci::popis()
            ]
        );
    }

    function klubovi($id)
    {
        $view = new View();
        $view->render(
            'igraci/klubovi',
            [
            "popis"=>Igraci::popisKlubova($id)
            ]
        );
    }

    function prepareinsert($id)
    {


            // Igraci::insert($id);
            $view = new View();
            $view->render(
                'igraci/unosigraca',
                [
                "popis"=>$id
                ]
            );
                
    }

    function listaIgrac()
    {

        $id=Request::post("klub");
        
        $view = new View();
        $view->render(
            'igraci/lista',
            [
            "popis"=>Igraci::lista(Igraci::listaIgraca($id))
            ]
        );
                
    }



    function insert()
    {
        Igraci::insert();
        $id=Request::post("LeagueTable");
        $this->lista($id);                
    }




    function lista2()
    {
        $klub = Request::post("klub");
        
        $db = Db::getInstance();
        $izraz = $db->prepare("select id from leagueTable where nameOfTeam='$klub';");
        $izraz->execute();
        $ime = $izraz->fetchColumn();
        $this->lista($ime);
   
    }



    function lista($id)
    {
        $view = new View();
        $view->render(
            'igraci/lista',
            [
            "popis"=>Igraci::lista($id),
            "id"=>$id
            ]
        );
    }

    // function top($id)
    // {
    //     $view = new View();
    //     $view->render(
    //         'igraci/topScorers',
    //         [
    //         "top"=>Igraci::topScorers($id)
    //         ]
    //     );
    // }


    function top($id)
    {

        $db = Db::getInstance();
        $izraz = $db->prepare("
            select
            play.firstName,
            play.lastName,
            play.totalGoalsScored,
            lt.league,
            lt.nameOfTeam
            from Players play inner join
            leagueTable lt on 
            lt.id=play.LeagueTable
            where league=$id
            order by play.totalGoalsScored DESC;
            ");
        
        $izraz->execute();
        $rezultati = $izraz->fetchAll(PDO::FETCH_OBJ);
        $podaci=[];
        foreach($rezultati as $red){
            if($red->totalGoalsScored=="0"){
                continue;
            }
            $p=new stdClass();
            $p->name=$red->firstName . " " . $red->lastName . "(" . $red->nameOfTeam . ")" ;
            $p->y=(int)$red->totalGoalsScored;
            $podaci[]=$p;
        }
        

        $view = new View();
        $view->render('igraci/topScorers',["podaci"=>json_encode($podaci,JSON_NUMERIC_CHECK)]);

    }


    function prepareEdit($id)
    {


            $view = new View();
            $view->render(
                'igraci/edit',
                [
                "popis"=>Igraci::igracEdit($id)
                ]
            );
                
    }

    function update()
    {
        Igraci::update();
        $id=Request::post("LeagueTable");
        $this->lista($id);
    }


    function delete($id)
    {
            Igraci::delete($id);
            $this->index();
    }


}