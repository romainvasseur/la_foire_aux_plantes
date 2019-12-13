<?php
namespace App\Controller;

use App\Entity\Posts;
use App\Repository\PostsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class HomeController extends AbstractController {

    private $repo;

    public function __construct(PostsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $posts = $this->repo->findLatest();
        return $this->render('pages/home.html.twig', [
            'posts' => $posts
        ]);
    }

}