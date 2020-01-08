<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class CreationController
 * @package App\Controller
 */
class CreationController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $creations = ModelMaker::getModel('Creation')->listData();

        return $this->render('creations.twig',[
            'creations' => $creations
        ]);
    }
}