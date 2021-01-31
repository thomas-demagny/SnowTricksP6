<?php

namespace App\DataFixtures;


use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\User\User;


/**
 * Class TrickFixtures
 * @package App\DataFixtures
 */
class TrickFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * Const int
     */
    CONST TRICKS_NUMBER = 20;
    CONST TRICKS_NAME = [
        '360',
        'Air',
        'FS 540',
        '1080' ,
        'Front Flip',
        'Back Flip' ,
        'Indy'
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        dd($this->getReference('user1'));
        $usersData = $this->getReference('user'. mt_rand(1, UserFixtures::DATA));

        for ($k = 1 ; $k < self::TRICKS_NUMBER; $k++) {

            $trick = $this->initTrick(new Trick($usersData[$k]));

            $manager->persist($trick);
            $this->addReference("trick".$k, $trick);
        }

        $manager->flush();
    }

    public function initTrick( $trick): Trick
    {
        $faker = Factory::create('fr_FR');
        $date = $faker->dateTimeBetween('-2 months');

        $userData = $this->getReference('toto');
        $trick
            ->setTitle($faker->randomElement(self::TRICKS_NAME))
            ->setDescription(join("\n", $faker->paragraphs(3)))
            ->setCreatedAt($date)
            ->setUpdateAt($date)
            ->setUser($userData);

        return $trick;
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class
        ];
    }


}//end class