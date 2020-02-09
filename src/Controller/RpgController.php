<?php
namespace App\Controller;

use App\Model\Maker\ModelMaker;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class RpgController
 * @package App\Controller
 */
class RpgController extends MainController {

    /**
     * @var array
     */
    private $stats = [];

    /**
     * Renders the View
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function launchMethod()
    {
        $params         = ModelMaker::getModel('Rpg')->listData();
        $userCharacter  = ModelMaker::getModel('Rpg')->listData($this->getUserVar('id'), 'user_id');

        return $this->render('rpg.twig',[
            'param'        => $params,
            'character'    => $userCharacter
        ]);
    }

    /**
     * Creates a character with default stats
     */
    public function createMethod() {
        $user_id    = $this->getUserVar('id');
        $name       = $this->post['name'];
        $category   = $this->post['category'];

        if ($category == 'Warrior') {
            $this->stats['health_points']   = 44;
            $this->stats['strength']        = 2;
        } elseif ($category == 'Sorcerer') {
            $this->stats['health_points']   = 40;
            $this->stats['strength']        = 2;
        } elseif ($category == 'Archer') {
            $this->stats['health_points'] = 40;
            $this->stats['strength'] = 1;
        }
        ModelMaker::getModel('Rpg')->createData([
            'user_id'       => $user_id,
            'name'          => $name,
            'category'      => $category,
            'health_points' => $this->stats['health_points'],
            'strength'      => $this->stats['strength'],
            'exp'           => $this->stats['exp']
        ]);

        ModelMaker::getModel('User')->updateData($this->getUserVar('id'), [
            'user_character' => $this->post['name']
        ]);

        $this->redirect('rpg');
    }

    /**
     * Menu Character Actions
     */
    public function actionsMethod() {

    }


    public function hit() {}

    public function defend() {}

    public function getXP() {}

    public function talk() {}
}