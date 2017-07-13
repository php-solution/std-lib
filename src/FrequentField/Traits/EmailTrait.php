<?php
namespace PhpSolution\FrequentField\Traits;

/**
 * EmailTrait
 */
trait EmailTrait
{
    /**
     * @var string
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }
}