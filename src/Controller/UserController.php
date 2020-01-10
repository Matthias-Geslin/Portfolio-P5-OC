<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        if ($this->getUserVar('status') === 'Admin') {
            $certificate = ModelMaker::getModel('Certificate')->listData();
            $creation    = ModelMaker::getModel('Creation')->listData();
            $user        = ModelMaker::getModel('User')->listData();

            return $this->render("backend/user.twig", [
                'certificate' => $certificate,
                'creation'    => $creation,
                'user'        => $user
            ]);
        }
        elseif ($this->getUserVar('status') === 'Member') {
            return $this->render("backend/user.twig");
        }
        $this->redirect('home');
    }

    /**
     * @var array
     */
    private $post_content = [];

    private function postData()
    {
        $this->post_content['name']        = $this->post['name'];
        $this->post_content['email']       = $this->post['email'];
        $this->post_content['status']      = $this->post['status'];
    }

    private function postDataUser()
    {
        $this->post_content['name']        = $this->post['name'];
        $this->post_content['email']       = $this->post['email'];

        $this->post_content['status']      = $this->getUserVar('status');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function createMethod()
    {
        $name         = $this->post['name'];
        $email        = $this->post['email'];
        $pass         = $this->post['pass'];

        if (empty($name && $email && $pass)) {
            if ($this->getUserVar('status') == 'Admin') {
                return $this->render('backend/userCreate.twig');
            } $this->redirect('home');
        }

        $pass_encrypted = password_hash($pass, PASSWORD_DEFAULT);
        ModelMaker::getModel('User')->createData([
            'name'        => $name,
            'email'       => $email,
            'pass'        => $pass_encrypted
        ]);

        // Redirection if signup form complete
        if (isset($this->post['signup'])) {
            $user = ModelMaker::getModel('User')->readData($this->post['email'], 'email');
            $this->sessionCreate(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['pass'],
                $user['status']
            );
            $this->redirect('home');
        }
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
        ModelMaker::getModel('User')->deleteData($this->get['id']);

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

            ModelMaker::getModel('User')->updateData($this->get['id'], $this->post_content);

            $this->redirect('user');
        }
        if ($this->getUserVar('status') == 'Admin') {
            $user = ModelMaker::getModel('User')->readData($this->get['id']);

            return $this->render('backend/userModify.twig', [
                'user' => $user
            ]);

        } $this->redirect('home');
    }

    /**
     * @return string|mixed
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function usereditMethod()
    {
        if (!empty($this->post)) {
            $this->postDataUser();

            ModelMaker::getModel('User')->updateData($this->get['id'], $this->post_content);
            $user = ModelMaker::getModel('User')->readData($this->post['email'], 'email');

            $this->sessionDestroy();
            $this->sessionCreate(
                $user['id'],
                $user['name'],
                $user['email'],
                $user['pass'],
                $user['status']
            );

            $this->redirect('user');
        }
        $userInfo = ModelMaker::getModel('User')->readData($this->get['id']);

        return $this->render('backend/user.twig',[
            'user' => $userInfo
        ]);
    }
}
