<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ConnectionController
 * @package App\Controller
 */
class ConnectionController extends MainController
{
    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        if (!empty($this->post['email']) && !empty($this->post['pass'])) {
            $user = ModelMaker::getModel('User')->readData($this->post['email'], 'email');

            if (password_verify($this->post['pass'], $user['pass'])) {
                $this->sessionCreate(
                    $user['id'],
                    $user['name'],
                    $user['file'],
                    $user['email'],
                    $user['pass'],
                    $user['status']
                );
                if($this->getUserVar('status') === 'Admin') {
                    $this->redirect('user');
                }
                $this->redirect('home');
            }
        }
        if($this->getUserVar('status') === 'Admin') {
            $this->redirect('user');
        }
        elseif ($this->getUserVar('status') === 'Member') {
            $this->redirect('user');
        }
        elseif ($this->getUserVar('status') === 'Visitor') {
            $this->redirect('home');
        }
        return $this->render('connection.twig');
    }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function logoutMethod()
    {
        $this->sessionDestroy();
        $this->redirect('home');
    }
}
