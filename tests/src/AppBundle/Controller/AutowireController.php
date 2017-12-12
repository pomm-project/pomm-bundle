<?php
/**
 * This file is part of the pomm-bundle package.
 *
 */

namespace AppBundle\Controller;

use AppBundle\Model\ConfigModel;
use PommProject\Foundation\Pomm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class AutowireController extends Controller
{
    public function getAutowireAction($name, Pomm $pomm)
    {
        $config = $pomm
            ->getDefaultSession()
            ->getModel(ConfigModel::class)
            ->findByPk(['name' => $name]);

        return $this->render(
            'AppBundle:Front:get.html.twig',
            compact('config')
        );
    }
}