<?php
namespace Evisa;
/**
 *
 */
class Inputs
{
    private $inputs = array();

    function __construct($inputs)
    {
        $this->setInputs($inputs);
    }

    public function setInputs(Array $inputs){
        $this->inputs = $inputs;
    }

    public function getInputs(){
        return $this->inputs;
    }

    public function setCaptcha($captcha){
        $this->inputs['ctl00$body$recaptcha_response_field'] = $captcha;
    }

    public function setPasaportNo($pasaportNo){
        $this->inputs['ctl00$body$txtPasaportNo'] = $pasaportNo;
    }

    public function setEmail($email){
        $this->inputs['ctl00$body$txtEmail'] = $email;
    }
}
