<?php
namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class PostController extends AbstractController {

    private $repo;

    public function __construct(PostsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/Annonces", name="allposts.show")
     */
    public function index()
    {
        $post = $this->repo->findAll();
        return $this->render('pages/annonces.html.twig', [
            'current_menu' => 'posts'
        ]);
    }

    /**
     * @Route("/Annonces/{id}", name="post.show")
     */
    public function show($id)
    {
        $post = $this->repo->find($id);
        return $this->render('pages/show.html.twig', [
            'post' => $post
        ]);
    }
}