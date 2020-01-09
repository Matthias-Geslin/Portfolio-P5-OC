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
        $creation = ModelMaker::getModel('Creation')->listData();

        return $this->render('creation.twig',[
            'creations' => $creation
        ]);
    }
}