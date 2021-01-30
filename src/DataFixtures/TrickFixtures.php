<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class Trick extends Fixture implements DependentFixtureInterface
{

    /**
     *
     */
    CONST TRICKS_NUMBER = 20;

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $categories = $this->shuffleCategories();

        for ($k = 0 ; $k < self::TRICKS_NUMBER; $k++) {
            $date = $faker->dateTimeBetween('-10 days');
            $trick = new \App\Entity\Trick($this->shuffleUsers()[$k]);

            $trick
                ->setTitle($faker->text(50))
                ->setDescription(join("\n", $faker->paragraphs(3)))
                ->setCreatedAt($date)
                ->setUpdateAt($date)
            ;
            $this->addReference("trick".$k, $trick);
            $manager->persist($trick);
        }
        $manager->flush();
    }

    /**
     * @return mixed
     */
    public function shuffleUsers()
    {
        for($i = 0; $i < self::TRICKS_NUMBER ; $i++) {
            $usersData = 'user'.rand(0, UserFixtures::DATA);
            $users[] = $this->getReference($usersData);
        }
        return $users;
    }

    /**
     * @return mixed
     */
    public function shuffleCategories()
    {
        for($j = 0; $j < self::TRICKS_NUMBER ; $j++) {
            $categoriesData = new \App\Entity\Category();
            $categoryTrick = [];

            for($i = 0; $i < rand(1,3); $i++) {
                $key = array_rand($categoryTrick);
                $categoriesTrick[] = $categoriesData[$key];
            }
            $categories[$j] = $categoriesTrick;
        }
        return $categories;
    }

    public function getDependencies(): array
    {
        return [
            Category::class,
            UserFixtures::class
        ];
    }
}
