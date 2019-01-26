<?php
namespace Evisa;

/**
 *
 */
class Find
{
    private $inputs;
    private $post;
    private $downloadPdf;
    private $recource;

    function __construct()
    {
        $this->post = new PostSearchPage();
        $this->downloadPdf = new DownloadPdf();

    }

    public function find(int $resourceRow)
    {
        $resource = $this->resource->get($resourceRow);
        $this->setPasaportNo($resource[$this->resource->pasaportNo]);
        $this->setEmail($resource[$this->resource->email]);
        $this->setId($resource[$this->resource->id]);
        $this->save();
        $resourceRow++;
        return $resourceRow;
    }

    private function save()
    {
        $this->post->setInputs($this->inputs);
        $this->post->post();

        $this->downloadPdf->setPdfUrl($this->post->getPdfUrl());
        $this->downloadPdf->downloadPdf();
    }

    public function setInputs($inputs){
        $this->inputs = new Inputs($inputs);
    }

    public function setCaptcha($captcha){
        $this->inputs->setCaptcha($captcha);
    }

    public function setPasaportNo($pasaportNo){
        $this->inputs->setPasaportNo($pasaportNo);
    }

    public function setEmail($email){
        $this->inputs->setEmail($email);
    }

    public function setId($id){
        $this->downloadPdf->setId($id);
    }

    public function setResource($resource){
        $this->resource = $resource;
    }
}
