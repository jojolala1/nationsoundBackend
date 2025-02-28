<?php

namespace App\Tests\Unit;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;
    public function setUp(): void
    {
        $this->user = new User();
       
    }
    public function testGetEmail(): void
    {
        $value = 'test@gmail.fr';

        $response = $this->user->setEmail($value);
        $getEmail = $this->user->getEmail();

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $getEmail);
    }

    public function testGetRoles(): void
    {
        self::assertContains('ROLE_USER', $this->user->getRoles());
    }
    public function testGetPassword(): void
    {
        $value = 'password';

        $response = $this->user->setPassword($value);
        $getPassword = $this->user->getPassword();

        self::assertInstanceOf(User::class, $response);
        self::assertEquals($value, $getPassword);
    }
    
}
