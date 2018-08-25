<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
     * @Route("/blog/{id}/edit", name="blog_edit")
     */
    public function form(Article $article = null, Request $request, ObjectManager $manager)
    {
        if(is_null($article)){
            $article = new Article();
        }

        /*
        $form = $this->createFormBuilder($article)
                    ->add('title')
                    ->add('content')
                    ->add('image')
                    ->getForm();
        */

        $form = $this->createForm(ArticleType::class, $article);

        // Traitement de la requête, vérification des données, affectation de chaque champ à une propriété de l'objet
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if(!$article->getId())
                $article->setCreatedAt(new \DateTime());
            $manager->persist($article);
            $manager->flush(); // Enregistrement dans la base et reception d'un id

            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);

            
        }
        dump($article->getId());

        return $this->render('blog/form.html.twig',[
            'formArticle' => $form->createView(),
            'editMode' => $article->getId() !== null
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     */
    //public function show(ArticleRepository $repo, $id)
    // Utilisation du param Converter de symfony qui va interpoler et comprendre qu'il a besoin d'un article et que d'après la route il faut un id
    public function show(Article $article, Request $request, ObjectManager $manager)
    {
        //$repo = $this->getDoctrine()->getRepository(Article::class);
        //$article = $repo->find($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $comment->setCreatedAt(new \DateTime());
            $comment->setArticle($article);
            if($this->getUser()){
                $comment->setAuthor($this->getUser()->getUsername());  
            } else {
                $comment->setAuthor("Anonymous");
            }
            
            
            $manager->persist($comment);

            $manager->flush();
            return $this->redirectToRoute('blog_show', ['id' => $article->getId()]);
        }
        
        return $this->render('blog/show.html.twig', [
            'article' => $article,
            'commentForm' => $form->createView()
        ]);
    }

}
