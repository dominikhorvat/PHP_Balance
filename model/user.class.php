<?php

class User
{
    protected $id, $username, $password_hash, $total_paid, $total_debt, $email, $registration_sequence, $has_registered;

    function __construct($id, $username, $password_hash, $total_paid, $total_debt, $email, $registration_sequence, $has_registered)
    {
        $this->id = $id;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->total_paid = $total_paid;
        $this->total_debt = $total_debt;
        $this->email = $email;
        $this->registration_sequence = $registration_sequence;
        $this->has_registered = $has_registered;
    }



    function __get($prop) { return $this->$prop;}
    function __set($prop, $val) { $this->$prop = $val; return $this;}
};

?>