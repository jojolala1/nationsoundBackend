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

        if ($uriVariables['id']) {
            $userId = $uriVariables['id'];
            $user = $this->em->getRepository(User::class)->find($userId);
        } else {
            // Si c'est une création (POST)
            $user = new User();
        }

        $violations = $this->validator->validate($data); 
        if (count($violations) > 0) {
            throw new \Exception((string) $violations); 
        }

        if ($data->getEmail()){
            $user->setEmail($data->getEmail());
        }
        if ($data->getFirstName()){
            $user->setFirstName($data->getFirstName());
        }
        if ($data->getLastName()){
            $user->setLastName($data->getLastName());
        }

        if ($data->getPassword()){
            $hashedPassword = $this->userPasswordHasherInterface->hashPassword($user, $data->getPassword());
            $user->setPassword($hashedPassword);
        }


        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
