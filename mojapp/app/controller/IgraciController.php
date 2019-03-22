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
        $this->index();
                
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



  




}