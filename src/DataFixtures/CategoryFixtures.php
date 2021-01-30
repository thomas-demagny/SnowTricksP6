<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class Category
 * @package App\DataFixtures
 */
class Category extends Fixture
{
    /**
     * @var array|string[]
     */
    private array $categories = ['Front', 'Flip', 'Back', 'Rotations', 'Grabs'];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count($this->categories); $i++) {
            $category = new \App\Entity\Category();

            $category->setName($this->categories[$i]);
            $this->addReference('category' . $i, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
