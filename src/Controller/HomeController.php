<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class HomeController
 * Manages the Homepage
 * @package App\Controller
 */
class HomeController extends MainController
{
    /**
     * Renders the View Home
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $params         = ModelMaker::getModel('Rpg')->listData();

        $creations      = ModelMaker::getModel('Creation')->listData();
        $certificates   = ModelMaker::getModel('Certificate')->listData();

        return $this->render('home.twig',[
            'param'        => $params,
            'creations'     => $creations,
            'certificates'  => $certificates
        ]);
    }
}