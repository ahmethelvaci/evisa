<?php
namespace Evisa;

use Curl;
use Humbug;
/**
 *
 */
class DownloadPdf
{
    private $pdfUrl;
    private $id;

    function __construct()
    {

    }

    public function setPdfUrl($pdfUrl)
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function downloadPdf($redirect = false)
    {
        $curl = new Curl\Curl();
        $curl->setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
        // $curl->setUserAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_BINARYTRANSFER, 1);
        $curl->setHeader('Referer', 'https://www.evisa.gov.tr/tr/finalstep/');
        $curl->setHeader('Connection', 'keep-alive');
        $curl->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $curl->get($this->pdfUrl);

        if($curl->isRedirect() && !$redirect){
            return $this->redirect();
        }

        if ($curl->error) {
            //echo $curl->error_code;
            return false;
        }
        else {
            file_put_contents(DIR_PDF. '/'.$this->id.'.pdf', $curl->response);
            return true;
        }
    }
    private function redirect()
    {
        $curl = new Curl\Curl();
        // $curl->setUserAgent('Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko');
        $curl->setUserAgent('Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');
        $curl->setOpt(CURLOPT_RETURNTRANSFER, 1);
        $curl->setOpt(CURLOPT_COOKIEJAR, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_COOKIEFILE, '/tmp/cookies.txt');
        $curl->setOpt(CURLOPT_BINARYTRANSFER, 1);
        $curl->setHeader('Referer', 'https://www.evisa.gov.tr/tr/finalstep/');
        $curl->setHeader('Connection', 'keep-alive');
        $curl->setHeader('Accept-Encoding', 'gzip, deflate, br');
        $curl->setHeader('X-Requested-With', 'XMLHttpRequest');
        $curl->post('https://www.evisa.gov.tr/Services/VisaService.svc/PersonalizeVisa', array());

        $this->downloadPdf(true);
        return true;
    }

    /**
     * Parse a set of HTTP headers
     *
     * @param array The php headers to be parsed
     * @param [string] The name of the header to be retrieved
     * @return A header value if a header is passed;
     *         An array with all the headers otherwise
     */
    private function parseHeaders(array $headers, $header = null)
    {
        $output = array();

        if ('HTTP' === substr($headers[0], 0, 4)) {
            list(, $output['status'], $output['status_text']) = explode(' ', $headers[0]);
            unset($headers[0]);
        }

        foreach ($headers as $v) {
            $h = preg_split('/:\s*/', $v);
            $output[strtolower($h[0])] = $h[1];
        }

        if (null !== $header) {
            if (isset($output[strtolower($header)])) {
                return $output[strtolower($header)];
            }

            return;
        }

        return $output;
    }
}
