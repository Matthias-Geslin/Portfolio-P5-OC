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
            $this->stats['mana_points']     = 100;
            $this->stats['strength']        = 2;
            $this->stats['stamina']         = 1;
            $this->stats['intelligence']    = 0;
            $this->stats['agility']         = 1;
            $this->stats['defense']         = 1;
        } elseif ($category == 'Sorcerer') {
            $this->stats['health_points']   = 40;
            $this->stats['mana_points']     = 110;
            $this->stats['strength']        = 2;
            $this->stats['stamina']         = 0;
            $this->stats['intelligence']    = 1;
            $this->stats['agility']         = 0;
            $this->stats['defense']         = 0;
        } elseif ($category == 'Archer') {
            $this->stats['health_points']   = 40;
            $this->stats['mana_points']     = 110;
            $this->stats['strength']        = 1;
            $this->stats['stamina']         = 0;
            $this->stats['intelligence']    = 1;
            $this->stats['agility']         = 3;
            $this->stats['defense']         = 0;
        } elseif ($category == 'Paladin') {
            $this->stats['health_points']   = 44;
            $this->stats['mana_points']     = 100;
            $this->stats['strength']        = 1;
            $this->stats['stamina']         = 1;
            $this->stats['intelligence']    = 0;
            $this->stats['agility']         = 0;
            $this->stats['defense']         = 3;
        }
        ModelMaker::getModel('Rpg')->createData([
            'user_id'       => $user_id,
            'name'          => $name,
            'category'      => $category,
            'health_points' => $this->stats['health_points'],
            'mana_points'   => $this->stats['mana_points'],
            'strength'      => $this->stats['strength'],
            'stamina'       => $this->stats['stamina'],
            'intelligence'  => $this->stats['intelligence'],
            'defense'       => $this->stats['agility'],
            'agility'       => $this->stats['defense']
        ]);

        $this->redirect('rpg');
    }

    public function hit() {}

    public function defend() {}

    public function getXP() {}

    public function talk() {}
}