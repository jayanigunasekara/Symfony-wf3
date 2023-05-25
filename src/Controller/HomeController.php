<?php

namespace App\Controller;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Faker;
use Cocur\Slugify\Slugify;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(ArticleRepository $repo): Response
    {   
        //Use faker to generate dummy data
        /* $faker = Faker\Factory::create('fr_FR');
        $title1=$faker->sentence(2);
        $intro1 = $faker->paragraph(2);
        $image =$faker->imageUrl();

        dump($title1);
        print($image);

        $contenu = ["pomme", "fraise", "figue"];
        $content = "<p>".implode('</p></p>', $faker->paragraphs(5)).'</p>';

        $createdAt = $faker->dateTimeBetween('-2 months');




        print($content);
        print( $createdAt->format('Y-m-d H:i:s'));
 */

        
        $articles = $repo->findLastArticles(3);
        
        // dump($articles);


        //------------------Slugify---------------------
        //$slugify =  new Slugify();
        // $title =  "Let's learn the theory of the symfony";
        // $slug = $slugify->slugify($title);
        // dump($slug);
       
        
        


        



        return $this->render('home/index.html.twig', [
           "articles"=> $articles
        ]);
    }
}
