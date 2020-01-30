<?php
namespace App\Controller;

use App\Entity\Posts;
use Twig\Environment;
use App\Entity\PostSearch;
use App\Form\PostSearchType;
use App\Repository\PostsRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController {

    private $repo;

    public function __construct(PostsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/Annonces", name="allposts.show")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new PostSearch();
        $form = $this->createForm(PostSearchType::class, $search);
        $form->handleRequest($request);

        $posts = $paginator->paginate(
            $this->repo->findAllPages($search),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('pages/annonces.html.twig', [
            'posts' => $posts,
            'form' => $form->createView(),
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