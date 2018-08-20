<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @Route("/blog/new", name="blog_create")
     */
    public function create(Request $request, ObjectManager $manager)
    {
        dump($request);
        dump($request->request->count());

        if($request->request->count() > 0){
            
            $article = new Article();
            $article->setTitle($request->request->get('title'))
                    ->setContent($request->request->get('content'))
                    ->setImage($request->request->get('image'))
                    ->setCreatedAt(new \DateTime());

            $manager->persist($article);

            $manager->flush();

            return $this-redirectToRoute('blog_show',['id' => $article->getId()]);
        }
        return $this->render('blog/create.html.twig', [
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    //public function show(ArticleRepository $repo, $id)
    // Utilisation du param Converter de symfony qui va interpoler et comprendre qu'il a besoin d'un article et que d'après la route il faut un id
    public function show(Article $article)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);
        
        return $this->render('blog/show.html.twig', [
            'article' => $article
        ]);
    }

}
