<?php

class Expense
{
    protected $id, $id_user, $cost, $description, $date;

    function __construct($id, $id_user, $cost, $description, $date)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->cost = $cost;
        $this->description = $description;
        $this->date = $date;
    }

    function __get($prop) { return $this->$prop;}
    function __set($prop, $val) { $this->$prop = $val; return $this;}
};

?>