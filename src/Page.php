<?php
namespace Evisa;

use Curl;
/**
 *
 */
class Page
{

    private $page;
    private $headers;

    function __construct()
    {

    }

    public function set()
    {
        $curl = new Curl\Curl();
        $curl->setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
        // $curl->setUserAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $curl->get(EVISA_URL);

        if ($curl->error) {
            echo $curl->error_code;
        }
        else {
            $this->setPage($curl->response);
            $this->setHeaders($curl->response_headers);
        }
    }

    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getPage()
    {
        return $this->page;
    }

    public function getHeaders()
    {
        return $this->headers;
    }
}
