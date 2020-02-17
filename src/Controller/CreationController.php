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


    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        if (!empty($this->getFileVar('name'))) {
            $file = $this->uploadFile('img/Creation');
        }

        if (empty($this->post)) {
            return $this->render('backend/creationCreate.twig');
        }
        ModelMaker::getModel('Creation')->createData([
            'name'        => $this->post['name'],
            'file'        => $file,
            'link'        => $this->post['link'],
            'year'        => $this->post['year'],
            'description' => $this->post['description'],
            'category'    => $this->post['category']
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
        ModelMaker::getModel('Creation')->deleteData($this->get['id']);

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
            $this->uploadingFile('Creation');
        }
        if ($this->getUserVar('status') == 'Admin') {
            $creation = ModelMaker::getModel('Creation')->readData($this->get['id']);

            return $this->render('backend/creationModify.twig', [
                'creation' => $creation
            ]);
        } $this->redirect('home');
    }
}
