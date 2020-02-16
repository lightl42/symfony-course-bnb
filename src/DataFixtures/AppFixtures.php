<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Ad;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('FR-fr');

        for($i = 1; $i < 30; $i++) {
            $ad = new Ad();

            $title = $faker->sentence();
            $image = $faker->imageUrl(1000, 350);
            $intro = $faker->paragraph(2);
            $content = $faker->paragraph(5);

            $ad->setTitle($title)
                ->setCoverImage($image)
                ->setIntroduction($intro)
                ->setContent($content)
                ->setPrice(mt_rand(40, 200))
                ->setRooms(mt_rand(1, 5));

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
