<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $article = new Article();

        $form = $this->createFormBuilder($article)
                    ->add('title', TextType::class, [
                        'label' => 'Titre',
                        'attr' => [
                            'placeholder' => "Titre de l'article",
                            'cclass' => "form-control"
                        ]])
                    ->add('content', TextareaType::class, [
                        'label' => 'Contenu',
                        'attr' => [
                            'placeholder' => "Contenu de l'article",
                            'cclass' => "form-control"
                        ]])
                    ->add('image', TextType::class, [
                        'label' => 'Image',
                        'attr' => [
                            'placeholder' => "URL de l'image",
                            'class' => "form-control"
                        ]])
                    ->add('save', SubmitType::class, [
                        'label' => 'Enregistrer',
                        'attr' => [
                            'class' => 'btn btn-primary'
                        ]])
                    ->getForm();

        return $this->render('blog/create.html.twig',[
            'formArticle' => $form->createView()
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
