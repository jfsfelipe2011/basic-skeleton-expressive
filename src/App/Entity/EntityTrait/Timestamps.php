<?php

declare(strict_types=1);

namespace App\Entity\EntityTrait;

trait Timestamps
{
    /** @var \string */
    protected $created_at;

    /** @var \string */
    protected $updated_at;

    /**
     * @return \string
     */
    public function getCreatedAt() : string
    {
        return $this->created_at;
    }

    /**
     * @param string $created_at
     *
     * @return self
     */
    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return string
     */
    public function getUpdatedAt() : string
    {
        return $this->updated_at;
    }

    /**
     * @param string $updated_at
     *
     * @return self
     */
    public function setUpdatedAt(string $updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
