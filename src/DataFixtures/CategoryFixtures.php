<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;


/**
 * Class CategoryFixtures
 * @package App\DataFixtures
 */
class CategoryFixtures extends Fixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategoryDataSet() as $n => $categoryData) {
            $category = new Category;
            $category->setName($categoryData);
            $this->addReference('category' . $n, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }

    private function getCategoryDataSet(): array
    {
        return [
            'Front',
            'Flip',
            'Back',
            'Rotations',
            'Grabs'
        ];
    }
}