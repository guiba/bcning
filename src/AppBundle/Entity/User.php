<?php
/**
 * Created by PhpStorm.
 * User: uto
 * Date: 05/12/16
 * Time: 20:00
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __contruct()
    {
        parent::__contruct();
        //your own logic
    }
}