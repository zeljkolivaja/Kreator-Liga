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


    function insert()
    {

        Igraci::insert();

        $id=Request::post("LeagueTable");
        $db = Db::getInstance();
        $izraz = $db->prepare("select league from leagueTable where id=$id");
        $izraz->execute();
        $id = $izraz->fetchColumn();

        $this->klubovi($id);                
    }


    function lista($id)
    {
        $view = new View();
        $view->render(
            'igraci/lista',
            [
            "popis"=>Igraci::lista($id)
            ]
        );
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