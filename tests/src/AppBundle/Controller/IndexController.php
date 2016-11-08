<?php

namespace AppBundle\Controller;

use \PommProject\Foundation\Session\Session;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\Templating\EngineInterface;

class IndexController
{
    private $pomm;
    private $templating;

    public function __construct(EngineInterface $templating, Session $pomm)
    {
        $this->pomm = $pomm;
        $this->templating = $templating;
    }

    public function indexAction()
    {
        $result = $this->pomm->getQueryManager()
            ->query('select 1');

        return new Response(
            $this->templating->render(
                'AppBundle:Front:index.html.twig'
            )
        );
    }

    public function getAction(\AppBundle\Model\Config $config = null)
    {
        return new Response(
            $this->templating->render(
                'AppBundle:Front:get.html.twig',
                compact('config')
            )
        );
    }

    public function failAction()
    {
        $this->pomm->getQueryManager()
            ->query('select 1 from');
    }
}
