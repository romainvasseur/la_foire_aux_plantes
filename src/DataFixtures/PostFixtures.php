<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Posts;
use App\Entity\Wishlist;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PostFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        
        for($i = 1; $i <= 10; $i++){
            $user = new User();
            $user
                ->setUsername($faker->firstNameMale())
                ->setPassword($this->encoder->encodePassword($user, 'totototo'))
                ->setEmail($faker->email())
                ->setRoles('ROLE_USER')
                ->setTelephone($faker->phoneNumber());
                
            $manager->persist($user);
        
            for($j = 0; $j < 200; $j++){
                $post = new Posts();
                $post
                    ->setTitle($faker->sentence(6, true))
                    ->setDescription($faker->sentences(6, true))
                    ->setDpt($faker->numberBetween(1, 96))
                    ->setPostal('33115')
                    ->setCity($faker->city())
                    ->setPrice($faker->numberBetween(0, 200))
                    ->setQuantity($faker->numberBetween(1, 10))
                    ->setCategory($faker->numberBetween(1, 8))
                    ->setPosttype($faker->numberBetween(1, 4))
                    ->setUser($user);

                $manager->persist($post);
            }

            for($k = 0; $k < 6; $k++){
                $wishlist = new Wishlist();
                $wishlist
                    ->setContent($faker->city())
                    ->setUser($user);

                $manager->persist($wishlist);
            }
        }
        // $product = new Product();
        // $manager->persist($product);
        
        $manager->flush();
    }
}
