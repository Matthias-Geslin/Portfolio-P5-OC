<?php
namespace App\Controller;

use App\Controller\Extension\PhpAdditionalExtension;
use App\Model\Maker\ModelMaker;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;

/**
 * Class MainController
 * Manages the Main Features
 * @package App\Controller
 */
abstract class MainController extends SuperGlobalsController
{
    /**
     * @var Environment|null
     */
    protected $twig = null;

    /**
     * MainController constructor
     * Creates the Template Engine & adds its Extensions
     */
    public function __construct()
    {
        parent::__construct();

        $this->twig = new Environment(new FilesystemLoader('../src/View'), array(
            'cache' => false,
            'debug' => true
        ));
        $this->twig->addExtension(new DebugExtension());
        $this->twig->addExtension(new PhpAdditionalExtension());
        $this->twig->addGlobal('session', $_SESSION);
        $this->twig->addGlobal('post', $_POST);
        $this->twig->addGlobal('get', $_GET);
        $this->twig->addGlobal('file', $_FILES);
        $this->twig->addFilter( new \Twig\TwigFilter('nl2br', 'nl2br', ['is_safe' => ['html']]));
    }

    /**
     * Returns the Page URL
     * @param string $page
     * @param array $params
     * @return string
     */
    public function url(string $page, array $params = [])
    {
        $params['access'] = $page;
        return 'index.php?' . http_build_query($params);
    }

    /**
     * Redirects to another URL
     * @param string $page
     * @param array $params
     */
    public function redirect(string $page, array $params = [])
    {
        header('Location: ' . $this->url($page, $params));
        exit;
    }

    /**
     * Renders the Views
     * @param string $view
     * @param array $params
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $view, array $params = [])
    {
        return $this->twig->render($view, $params);
    }

    /**
     * @var array
     */
    private $post_content = [];

    /**
     * Uploading file into a table
     * @param string $var
     * @param int $id
     */
    public function uploadingFile(string $var)
    {
        if($var === 'Creation') {
            $this->post_content['name']                    = $this->post['name'];
            $this->post_content['link']                    = $this->post['link'];
            $this->post_content['year']                    = $this->post['year'];
            $this->post_content['description']             = $this->post['description'];
            $this->post_content['category']                = $this->post['category'];
        } else {
            $this->post_content['name']                    = $this->post['name'];
            $this->post_content['email']                   = $this->post['email'];
            $this->post_content['status']                  = $this->post['status'];
        }

        if (!empty($this->getFileVar('file'))) {
            $this->post_content['file'] = $this->uploadFile('img/' . $var);
        }


        ModelMaker::getModel('' . $var . '')->updateData($this->get['id'], $this->post_content);

        $this->redirect('user');
    }
}