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
class CertificateController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $certificate = ModelMaker::getModel('Certificate')->listData();

        return $this->render('certificate.twig',[
            'certificate' => $certificate
        ]);
    }
}