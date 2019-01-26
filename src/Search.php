<?php
namespace Evisa;

/**
 *
 */
class Search
{
    private $page;
    private $captcha;

    function __construct()
    {
        $this->page = new SearchPage();
        $this->captcha = new Captcha();
    }

    public function getInputs(){
        return $this->page->getInputs();
    }

    public function getCaptchaUrl(){
        return $this->captcha->getCaptchaUrl();
    }
}
