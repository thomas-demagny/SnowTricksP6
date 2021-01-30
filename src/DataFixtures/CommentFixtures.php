<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * Class CommentFixtures
 * @package App\DataFixtures
 */
class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $usersData = [];
        for($i = 0; $i < UserFixtures::DATA; $i++)
        {
            $usersData[] = 'user'.$i;
        }
        for($j = 0; $j < TrickFixtures::TRICKS_NUMBER and UserFixtures::DATA; $j++)
        {
            $user = $this->getReference($usersData[array_rand($usersData)]);
            $trick = $this->getReference('trick'.$j);
            $date = max($faker->dateTimeBetween('- 6 days'), $user->getRegisteredAt(), $trick->getCreateAt() );

            $comment = new Comment();

            $comment
                ->setContent(join("\n", $faker->sentence(20) ))
                ->setCreatedAt($date);

            $manager->persist($comment);
        }
        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies() : array
    {
        return
            [
                TrickFixtures::class
            ];
    }
}