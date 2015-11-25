<?php

namespace AppBundle\Controller;

use \PommProject\Foundation\Session\Session;
use \Symfony\Component\Serializer\Serializer;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\Templating\EngineInterface;

class IndexController
{
    private $pomm;
    private $templating;
    private $serializer;

    public function __construct(
        EngineInterface $templating,
        Session $pomm,
        Serializer $serializer
    ) {
        $this->pomm = $pomm;
        $this->templating = $templating;
        $this->serializer = $serializer;
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

    public function getAction(\AppBundle\Model\Config $config)
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

    public function serializeAction()
    {
        $results = $this->pomm->getQueryManager()
            ->query('select point(1,2)');

        return new Response(
            $this->serializer->serialize($results, 'json'),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }
}
