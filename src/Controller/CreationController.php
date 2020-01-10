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
        $creation = ModelMaker::getModel('Creation')->listData();

        return $this->render('creation.twig',[
            'creations' => $creation
        ]);
    }

    /**
     * @return string
     */
    private function postData()
    {
        $this->post_content['name']          = $this->post['name'];
        $this->post_content['file']          = $this->files['file'];
        $this->post_content['link']          = $this->post['link'];
        $this->post_content['year']          = $this->post['year'];
        $this->post_content['description']   = $this->post['description'];
        $this->post_content['category']      = $this->post['category'];
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        $name = $this->post['name'];
        if (!empty($this->files['file'])) {
            $file = $this->uploadFile('img/creations');
        }
        $link               = $this->post['link'];
        $year               = $this->post['year'];
        $description        = $this->post['description'];
        $category           = $this->post['category'];

        if (empty($name && $file && $link && $year && $description && $category)) {
            return $this->render('backend/creationCreate.twig');
        }
        ModelMaker::getModel('Creation')->createData([
            'name'        => $name,
            'file'        => $file,
            'link'        => $link,
            'year'        => $year,
            'description' => $description,
            'category'    => $category
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
            $this->postData();

            if (!empty($this->getFileVar('file'))) {
                $this->post_content['file'] = $this->uploadFile('img/creations');
            } else {
                $file_get = ModelMaker::getModel('Creation')->readData($this->get['id']);

                $this->post_content['file'] = $file_get['file'];
            }

            ModelMaker::getModel('Creation')->updateData($this->get['id'], $this->post_content);

            $this->redirect('user');
        }
        $creation = ModelMaker::getModel('Creation')->readData($this->get['id']);

        return $this->render('backend/creationModify.twig', [
            'creation' => $creation
        ]);
    }
}