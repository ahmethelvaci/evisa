<?php
namespace Evisa;

use Curl;
/**
 *
 */
class Captcha
{
    private $captchaUrl;

    private $_timestamp;

    function __construct()
    {
        $this->setCaptchaUrl();
        $this->saveCaptcha();
    }

    public function setCaptchaUrl(){
        $this->_timestamp =  time() . '342';
        $this->captchaUrl =
            'https://www.evisa.gov.tr/captcha/' .
            $this->_timestamp . '/';
    }

    public function getCaptchaUrl(){
        return SITE_URL . 'temp/captcha.png?' . $this->_timestamp;
    }

    private function saveCaptcha(){

        $curl = new Curl\Curl();
        $curl->setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
        // $curl->setUserAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $curl->get($this->captchaUrl);

        if ($curl->error) {
            echo $curl->error_code;
        }
        else {

            $temp = DIR_TEMP . '/captcha.png';
            file_put_contents($temp, $curl->response);
        }
    }
}
