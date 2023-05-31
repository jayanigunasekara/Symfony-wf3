<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles_index")
     * @IsGranted("ROLE_USER")
     */
    public function index(ArticleRepository $repo)
    {
        $articles= $repo->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles/new", name="article_create")
     */
    public function create(Request $request, EntityManagerInterface $manager) 
    {
        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $article->setAuthor($this->getUser());

            $manager->persist($article);
            $manager->flush();

            $this->addFlash('success', 
                            "L'article <strong>{$article->getTitle()}</strong> a bien été crée");

            return $this->redirectToRoute('article_show' , [
                'slug' => $article->getSlug()
            ]);
        }
        
        return $this->render('article/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="article_show")
     */
    public function show($slug , ArticleRepository $repo)
    {
        $article= $repo->findOneBySlug($slug);

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * @Route("/articles/{slug}/edit", name="article_edit")
     * @Security("is_granted('ROLE_USER') and user === article.getAuthor()")
     */
    public function edit(Request $request, Article $article, EntityManagerInterface $manager)
    {
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
     * @Route("articles/{slug}/delete", name="article_delete")
     */
    public function delete(EntityManagerInterface $manager, Article $article)
    {
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('danger',"L'article a bien été supprimé");
      
        return $this->redirectToRoute('articles_index');
    }

    
}
