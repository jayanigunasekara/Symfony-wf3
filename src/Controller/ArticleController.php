<?php

namespace App\Controller;
use App\Entity\Article;
use App\Form\ArticleType;
use Cocur\Slugify\Slugify;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_index")
     */

     //To retreive the data in the database 
    public function index(ArticleRepository $repo)
    {
        // $article = new Article();
        // $article->setTitle("ABC");
        // $article->setIntro("aezezrer");
        // $article->setImage("https://images.pexels.com/photos/1640772/pexels-photo-1640772.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500");
        // $time = new \DateTime();
        // $time->format('H:i:s \O\n Y-m-d');
        // $article->setCreatedAt($time);


        
        // $entityManager->persist($article);
        // $entityManager->flush();

        
        $articles= $repo->findAll();
        //$article= $repo->findOneById(67);

        //add slug to a title
        //$slugify =  new Slugify();
        //$slug =  $slugify->slugify($article->getTitle().time().hash("sha1", $article->getIntro()));
        //dump(slug);
        //print(var_dump($slug));



        
        //print(var_dump($articles));
        
        // $slugify =  new Slugify();
        // $article = $repo->findOneBySomeTitle("Article numéro: 1");
        // print(var_dump($article));
        // $slug  =  $slugify->slugify($article->getTitle());
        // print(dump($slug));
 



        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }


    
    //Dynamic article -form
         /**
     * @Route("/articles/new", name="article_create")
     */
    public function create(Request $request, EntityManagerInterface $manager){

        $article = new Article();
        
        $form = $this->createForm(ArticleType::class, $article);



        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //$title = $form->get("title")->getData();
            // $title = $form["title"]->getData();
            // $intro = $form["intro"]->getData();
            // $content = $form["content"]->getData();
            // $image = $form["image"]->getData();
            
            // if ($form) {
            //     if(strlen($title) < 5){
            //         $errorTitleMin = new FormError("Un titre aussi court? Minimum 5 charactéres requis");
            //         $form->get('title')->addError( $errorTitleMin);
            //         /* return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  */
            //     }elseif (strlen($title) > 255) {
            //         $errorTiteMax = new FormError("Un titre de moins  255 charactères est requis");
            //         $form->get('title')->addError($errorTiteMax);
            //         /* return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  */
            //     }elseif (strlen($intro) < 20) {
            //         $errorIntroMin = new FormError("Minimum 20 charactères pour l'intro");
            //         $form->get('intro')->addError($errorIntroMin);
            //         /* return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  */
            //     }elseif (strlen($intro) > 255) {
            //         $errorIntroMax = new FormError("Plus de 255 charactères ce n'est plus une intro !");
            //         $form->get('intro')->addError($errorIntroMax);
            //         /* return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  */
            //     }elseif($image){
            //         $errorImageUrl = new FormError("Ceci n'est pas une url");
            //         $form->get('image')->addError($errorImageUrl);
            //        /*  return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]); */ 
            //     }elseif ($content) {
            //         $errorContent= new FormError("Ce champs ne peut pas etre vide");
            //         $form->get('content')->addError($errorContent);
            //        /*  return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  */
            //     }
                    

            //          return $this->render('article/create.html.twig', [
            //             'form' => $form->createView(),
                        
                        
            //         ]);  


            // }
            
            
            $manager->persist($article);
            $manager->flush();

            

            $this->addFlash("success", 
            "L'article <strong>{$article->getTitle()}</strong> a bien été crée");

            return $this->redirectToRoute('article_show' , 
                ['slug' => $article->getSlug()]);
        }

        dump($article);


        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    } 





    //using slug
   /**
     * @Route("/articles/{slug}", name="article_show")
     */
    
    public function show($slug, ArticleRepository $repo){
        // if($slug === "new"){
        //     return $this->render('article/error.html.twig', [
        //         "article" => "file not found"
        //     ]);
        // }
      
        $article = $repo->findOneBySlug($slug);
        
        return $this->render('article/show.html.twig', [
            "article" => $article
           
        ]);
    } 


     /**
     * @Route("/articles/{slug}/edit", name="article_edit")
     */
    public function edit($slug, Request $request, EntityManagerInterface $manager,ArticleRepository $repo)
    {

        $article = $repo->findOneBySlug($slug);

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash('info', 
                            "L'article <strong>{$article->getTitle()}</strong> a bien été modifié");

            return $this->redirectToRoute('article_show' , [
                'slug' => $article->getSlug()
            ]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/articles/{slug}/delete", name="article_delete")
     */
    public function delete($slug, EntityManagerInterface $manager, ArticleRepository $repo)
    {

        $article = $repo->findOneBySlug($slug);
        
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('danger',"L'article a bien été supprimé");
      
        return $this->redirectToRoute('articles_index');
    }













}
