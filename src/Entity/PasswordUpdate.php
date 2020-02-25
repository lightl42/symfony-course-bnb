<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class PasswordUpdate
{
    private $password;

    /**
     * @Assert\Length(min=8)
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous n'avez pas correctement confirmé votre mot de passe")
     */
    private $confirmPassword;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
