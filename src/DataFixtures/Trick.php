<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use http\Url;

class Trick extends Fixture
{
    CONST TRICK_NUMBER = 20;

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        ;

        $manager->flush();
    }
}
