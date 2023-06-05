<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Role;
use App\Entity\User;
use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager )
    {
        $faker = Faker\Factory::create('ma_MA');

        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);

        $adminUser = new User();
        $adminUser->setFirstName('Jayani')
                  ->setLastName('Gunasekara')
                  ->setEmail('jayani@admin.com')
                  ->setHash($this->encoder->encodePassword($adminUser, 'password'))
                  ->setAvatar('https://www.gravatar.com/avatar/00000000000000000000000000000000?d=wavatar&f=y')
                  ->setPresentation('Moi un User pas comme les autres')
                  ->addUserRole($adminRole);
        $manager->persist($adminUser);

        $users = [];
        $genres = ['male', 'female'];

        for ($i=0; $i <= 20 ; $i++) { 
            $user = new User();

            $genre = $faker->randomElement($genres);

            $picture = 'https://randomuser.me/api/portraits/';
            $pictureId = $faker->numberBetween(1,99) . '.jpg';
            
            $picture .= ($genre == 'male' ? 'men/' : 'women/').$pictureId;

            $user->setFirstname($faker->firstname($genre))
                 ->setLastname($faker->lastname)
                 ->setEmail($faker->email)
                 ->setAvatar($picture)
                 ->setPresentation($faker->sentence())
                 ->setHash($this->encoder->encodePassword($user, 'password'));
        
            $manager->persist($user);
            $users[] = $user ;
      
        }

        //Generate articles 
        $categories = [];
        for ($i=0; $i < 5; $i++) { 
            $category = new Category();
            $category->setName($faker->sentence(1));
            $manager->persist($category);
            $categories[] = $category;
        }


        // GESTION DES ARTICLES
        for ($i=0; $i <=20 ; $i++) { 
            
            $article = new Article();
            
            $title = $faker->sentence(2);

            $image = "https://picsum.photos/400/300";

            $intro = $faker->paragraph(2);

            $content = '<p>' . implode('</p><p>',$faker->paragraphs(5)) . '</p>';

            $author= $users[mt_rand(0, count($users) -1)];
            $category = $categories[mt_rand(0, count($categories) -1 )];

            $article->setTitle($title)
                    ->setImage($image)
                    ->setIntro($intro)
                    ->setContent($content)
                    ->setCategory($category)
                    ->setAuthor($author);

            $manager->persist($article);
            }

       

        $manager->flush();

        


    }

}
