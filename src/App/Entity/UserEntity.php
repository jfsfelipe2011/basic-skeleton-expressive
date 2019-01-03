<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\EntityTrait\Id;
use App\Entity\EntityTrait\Timestamps;

class UserEntity implements EntityInterface
{
	use Id,
		Timestamps;

	/** @var string */
	protected $name;

	/** @var string */
	protected $email;

	/** @var string */
	protected $password;

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail() : string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return self
     */
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
	{
		return [
			'id' 	     => $this->id,
			'name'       => $this->name,
			'email'      => $this->email,
			'password'   => $this->password,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at
		];
	}
}