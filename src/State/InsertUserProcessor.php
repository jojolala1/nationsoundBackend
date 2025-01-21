<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InsertUserProcessor implements ProcessorInterface
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private EntityManagerInterface $em
        ) {}
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $hashedPassword = $this->userPasswordHasherInterface->hashPassword($data, $data->getPassword());

        $data->setPassword($hashedPassword);

        $this->em->persist($data);
        $this->em->flush();

        return $data;
    }
}
