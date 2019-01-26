<?php
namespace Evisa;

use Curl;
use DOMDocument;
/**
 *
 */
class PostSearchPage
{
    private $inputs = array();
    private $pdfUrl;

    function __construct()
    {

    }

    public function setInputs(Inputs $inputs){
        $this->inputs = $inputs->getInputs();
    }

    public function post()
    {
        $curl = new Curl\Curl();
        //$curl->setUserAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko');
        $curl->setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_FOLLOWLOCATION, 1);
        $curl->setHeader('Origin', 'https://www.evisa.gov.tr');
        $curl->setHeader('Referer', 'https://www.evisa.gov.tr/tr/status/');
        $curl->setHeader('Connection', 'keep-alive');
        $curl->setHeader('Accept-Encoding', 'gzip, deflate, br');

        $curl->post(EVISA_URL, $this->inputs);

        if ($curl->error) {
            echo $curl->error_code;
        }
        else {
            //TODO yanlış doğrulama kodu olduğunda ne yapacak.
            $this->setPdfUrlFromDom($curl->response);
        }
    }

    private function setPdfUrlFromDom($response)
    {
            $doc = new DOMDocument();

            $internalErrors = libxml_use_internal_errors(true);
            $doc->loadHTML($response);
            libxml_use_internal_errors($internalErrors);

            try {

                //*[@id="ready"]/div[2]/a
                $ready = $doc->getElementById('ready');

                $div = $ready->getElementsByTagName('div')->item(1);
                $href = $div->getElementsByTagName('a')->item(0)
                ->getAttribute('href');
                $href = str_replace("../..", '', $href);
                $this->pdfUrl = EVISA. $href;

            } catch (Exception $e) {

            }

    }

    public function getPdfUrl(){
        return $this->pdfUrl;
    }
}
