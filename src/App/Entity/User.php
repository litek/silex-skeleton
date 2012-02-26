<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validation\Constraints AS Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;


    /**
     * @ORM\Column(type="string")
     */
    protected $name;


    public function serialize()
    {
        return array(
            'id'   => $this->id,
            'name' => $this->name
        );
    }


    public function toJSON()
    {
        return json_encode($this->serialize());
    }
}