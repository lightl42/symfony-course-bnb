<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ad;
use App\Entity\Image;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
         $this->encoder = $encoder;   
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        // Gestion des utilisateurs
        $users = [];
        $genres = ['male', 'female'];
        
        for($i = 1; $i < 10; $i++) {
            $user = new User();
            
            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1, 99) . '.jpg';

            $picture .= ($genre == 'male' ? 'men/' : 'women/') . $pictureId;

            $hash = $this->encoder->encodePassword($user, 'password');

            $user->setFirstName($faker->firstName($genre))
                 ->setLastName($faker->lastName)
                 ->setEmail($faker->email)
                 ->setIntroduction($faker->sentence())
                 ->setDescription('<p>' . join('<p></p>', $faker->paragraphs(3)) . '</p>')
                 ->setHash($hash)
                 ->setPicture($picture);
            
            $manager->persist($user);
            $users[] = $user;
        }

        // Gestion des annonces
        for($i = 1; $i < 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $image = $faker->imageUrl(1000, 350);
            $intro = $faker->paragraph(2);
            $content = $faker->paragraph(5);
            $user = $users[mt_rand(0, count($users) - 1 )];

            $ad->setTitle($title)
                ->setCoverImage($image)
                ->setIntroduction($intro)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5))
                ->setAuthor($user);

            for($j = 1; $j <= mt_rand(2, 5); $j++) {
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                      ->setCaption($faker->sentence())
                      ->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
        }
        $manager->flush();
    }
}