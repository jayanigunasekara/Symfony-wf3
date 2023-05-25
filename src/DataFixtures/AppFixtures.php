<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Article;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager){

        $faker = Factory::create();

        for ($i=1; $i <= 20 ; $i++) { 

        $article= new Article();
            

        $title = $faker->sentence(2); 
        $intro = $faker->paragraph(2); 

        $content ="<p>" . implode("</p><p>",$faker->paragraphs(5)) . "<p>" ; 
        $image = "https://picsum.photos/400/300";

        $createdAt = $faker->dateTimeBetween('-2 months');

           
            $article->setTitle($title);
            $article->setIntro( $intro);
            $article->setContent( $content);
            $article->setImage($image);
            //$article->setCreatedAt($createdAt);
 
            $manager->persist($article);
            $article->initSlug();
    
            // $manager->persist();
        }

        $manager->flush();
    }
}
