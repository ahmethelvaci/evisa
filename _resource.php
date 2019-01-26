<?php

class Resource
{
    public $id = 0;
    public $pasaportNo = 1;
    public $email = 2;
    private $resource = array();

    public function __construct()
    {
        $this->resource = $this->getResource();
    }

    public function get($id)
    {
        return $this->resource[$id];
    }

    public function getResource()
    {
        return array(
            array('1*1','A*4','c1*****@a******s.com','0'),
        );
    }
}
