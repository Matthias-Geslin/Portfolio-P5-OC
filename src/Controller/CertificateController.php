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
     * @var array
     */
    private $post_content = [];

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

    /**
     * @return string
     */
    private function postData()
    {
        $this->post_content['name']        = $this->post['name'];
        $this->post_content['link']        = $this->post['link'];
        $this->post_content['certif_date'] = $this->post['certif_date'];
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        $name        = $this->post['name'];
        $link        = $this->post['link'];
        $certif_date = $this->post['certif_date'];

        if (empty($name && $link && $certif_date)) {
            return $this->render('backend/certificateCreate.twig');
        }
        ModelMaker::getModel('Certificate')->createData([
            'name'        => $name,
            'link'        => $link,
            'certif_date' => $certif_date
        ]);
        $this->redirect('user');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function deleteMethod()
    {
        ModelMaker::getModel('Certificate')->deleteData($this->get['id']);

        $this->redirect('user');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function modifyMethod()
    {
        if (!empty($this->post)) {
            $this->postData();

            ModelMaker::getModel('Certificate')->updateData($this->post_content);

            $this->redirect('user');
        }
        $certificate = ModelMaker::getModel('Certificate')->readData($this->get['id']);

        return $this->render('backend/certificateModify.twig', [
            'certificate' => $certificate
        ]);
    }
}