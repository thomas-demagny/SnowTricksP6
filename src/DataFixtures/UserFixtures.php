<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class UserFixtures extends Fixture
{
    /**
     *
     */
    CONST DATA = 6;
    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $passwordEncoder;
    /**
     * @var TokenGeneratorInterface
     */
    private TokenGeneratorInterface $token;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $token
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGeneratorInterface $token)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->token = $token;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= self::DATA; ++$i) {
            $user = new User();
            $username = $faker->userName;


            $password = $this->passwordEncoder->encodePassword($user, $username);

            $user->setUsername($username)
                ->setEmail($username.'@'.$username.'.fr')
                ->setPassword($password)
                ->setAvatar('https://imgur.com/gallery/FqQgvbZ')
                ->setIsVerified(true)
                ->setCreatedAt($faker->dateTimebetween('-7 days'))


            ;
            $this->addReference('user'.$i,$user);
            $manager->persist($user);
        }

        $manager->flush();
    }

}