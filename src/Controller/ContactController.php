<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class ContactController
 * @package App\Controller
 */
class ContactController extends MainController
{
  /**
   * @return string
   * @throws LoaderError
   * @throws RuntimeError
   * @throws SyntaxError
   */
  public function launchMethod()
  {
    return $this->render('contact.twig');
  }

    /**
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function mailMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $firstname    = htmlentities($this->post['first_name']);
            $lastname     = htmlentities($this->post['last_name']);
            $email        = htmlentities($this->post['email']);
            $subjectPost  = htmlentities($this->post['subject']);
            $content      = $this->post['content'];

            $from    = $email;
            $to      = "pro-matthias.geslin@matthias-geslin.fr";

            $subject =  'Message de ' .$firstname.' <'.$email.'>';
            $message = $content;

            $header  = 'MIME-Version: 1.0'."\r\n";
            $header .= 'Content-type: text/html; charset=utf-8'."\r\n";
            $header .= 'From: '.$from."\r\n";

            mail($to,$subject,$message, $header);

            $this->redirect('contact');
        }
        return $this->render('contact.twig');
    }
}
