<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends BaseFixtures
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    protected function loadData(ObjectManager $manager)
    {

       $this->createMany(User::class,10,function (User $user,$count) {
           $hashedPassword = $this->passwordHasher->hashPassword(
               $user,
               '12345678'
           );
           $user->setEmail($this->faker->unique(true)->email)
               ->setUsername($this->faker->userName)
               ->setPassword($hashedPassword);
       });
       $manager->flush();
    }
}
