<?php
namespace Evisa;

use DOMDocument;
/**
 *
 */
class SearchPage extends Page
{
    private $inputs = array();

    function __construct()
    {
        $this->set();
        $this->setInputsFromPageDom();
    }

    public function getInputs(){
        return $this->inputs;
    }

    public function setInputs($inputs){
        $this->inputs = $inputs;
    }

    private function setInputsFromPageDom()
    {
        $doc = new DOMDocument();

        $internalErrors = libxml_use_internal_errors(true);
        $doc->loadHTML($this->getPage());
        libxml_use_internal_errors($internalErrors);

        $form1 = $doc->getElementById('form1');

        $inputs = $form1->getElementsByTagName('input');
        foreach($inputs as $input){
            $name = $input->getAttribute('name');
            $value = $input->getAttribute('value');
            $this->inputs[$name] = $value;
        }
    }
}
