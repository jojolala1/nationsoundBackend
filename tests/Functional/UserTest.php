<?php

namespace App\Tests\Functional;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use function json_encode;

class UserTest extends WebTestCase
{
    private $client;
    private $container;
    private $entityManager;
    private $passwordHasher;

    // Méthode d'initialisation avant chaque test
    protected function setUp(): void
    {
        $this->client = static::createClient(); // Crée une instance du client
        $this->container = static::getContainer();// boite a outils qui nous permet de recuperer les "outils" que l'on a besoin
        $this->entityManager = $this->container->get(EntityManagerInterface::class);
        $this->passwordHasher = $this->container->get(UserPasswordHasherInterface::class);

        // Supprimer les utilisateurs existants avec le même email avant chaque test
        $this->removeTestUser();
    }

    // Supprime l'utilisateur de test si il existe
    private function removeTestUser(): void
    {
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => 'test@example.com']);
        if ($existingUser) {
            $this->entityManager->remove($existingUser);
            $this->entityManager->flush();
        }
    }

    // Créer un utilisateur de test
    private function createTestUser(): User
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $user->setFirstName('John');
        $user->setLastName('Doe');
        $user->setPassword($this->passwordHasher->hashPassword($user, 'password'));
        $user->setRoles(['ROLE_USER']);
        
        // Persist l'utilisateur en base de données
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    // Récupérer le token JWT de l'utilisateur
    private function getAuthToken(): string
    {
        $this->client->request('POST', '/api/auth', [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], json_encode([
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $this->assertResponseIsSuccessful();

        $data = json_decode($this->client->getResponse()->getContent(), true);
        return $data['token'];
    }

    public function testGetUsers(): void
    {
        $this->createTestUser(); // Crée un utilisateur temporaire

        $token = $this->getAuthToken(); // Récupère le JWT

        $this->client->request('GET', '/api/users', [], [], [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $token,
        ]);

        // Vérifie que la réponse est réussie
        $this->assertResponseIsSuccessful();
        $this->assertJson($this->client->getResponse()->getContent());
    }
}
