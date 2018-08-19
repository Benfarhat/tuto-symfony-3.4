<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Repository\ArticleRepository;

class BlogController extends Controller
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo)
    {
        // On passe plutot par l'injection de dépendance
        // $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'title' => "Bienvenue ici les amis!",
            'age' => 11
        ]);
    }


    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    //public function show(ArticleRepository $repo, $id)
    // Utilisation du param Converter de symfony
    public function show(Article $article)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        $article = $repo->find($id);
        
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }
}
