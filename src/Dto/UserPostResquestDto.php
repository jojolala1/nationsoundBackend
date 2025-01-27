<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserPostResquestDto
{
    public function __construct(
        #[Assert\NotBlank(message: "L'email est obligatoire.")]
        #[Assert\Email(message: "L'email '{{ value }}' n'est pas valide.")]
        private string $email,

        #[Assert\NotBlank(message: "Le mot de passe est obligatoire.")]
        #[Assert\Regex(
            pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\d\s]).{6,}$/',
            message: "Le mot de passe doit contenir au moins 6 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial."
        )]
        private string $password,

        #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
        private string $firstName,

        #[Assert\NotBlank(message: "Le nom est obligatoire.")]
        private string $lastName
    ) {
    }


    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}