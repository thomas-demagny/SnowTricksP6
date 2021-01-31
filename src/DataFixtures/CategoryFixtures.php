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


    CONST categories = [
        'Front',
        'Flip',
        'Back',
        'Rotations',
        'Grabs'
    ];

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < count(CategoryFixtures::categories); $i++) {
            $category = new Category();

            $category->setName(self::categories[$i]);
            $this->addReference('category' . $i, $category);

            $manager->persist($category);
        }

        $manager->flush();
    }

    public function loadCategories()
    {
        for ($l = 0; $l < count(CategoryFixtures::categories); $l++) {
            $categoriesArray[] = 'category'.$l ;
        }
        return $categoriesArray;
    }
}
