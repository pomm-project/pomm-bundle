<?php
/**
 * This file is part of the pomm-bundle package.
 *
 */
namespace AppBundle\Controller;
use AppBundle\Model\MyDb1\PublicSchema\ConfigModel;
use PommProject\Foundation\Pomm;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AutowireController
{
    public function getAutowireAction(
        $name,
        Pomm $pomm,
        Environment $engine
    )
    {
        $config = $pomm
            ->getDefaultSession()
            ->getModel(ConfigModel::class)
            ->findByPk(['name' => $name]);

        return new Response($engine->render(
            'Front/get.html.twig',
            compact('config')
        ));
    }
}
