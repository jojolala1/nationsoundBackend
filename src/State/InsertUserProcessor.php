<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InsertUserProcessor implements ProcessorInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private EntityManagerInterface $em,
        private ValidatorInterface $validator
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {

        $violations = $this->validator->validate($data); 
        if (count($violations) > 0) {
            throw new \Exception((string) $violations); 
        }

        $user = new User();
        $user->setEmail($data->getEmail());
        $user->setFirstName($data->getFirstName());
        $user->setLastName($data->getLastName());

        $hashedPassword = $this->userPasswordHasherInterface->hashPassword($user, $data->getPassword());
        $user->setPassword($hashedPassword);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
