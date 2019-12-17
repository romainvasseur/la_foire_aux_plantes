<?php
namespace App\Controller\Admin;

use App\Repository\PostsRepository;
use App\Form\PostsType;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminPostController extends AbstractController {

    private $repo;

    public function __construct(PostsRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Route("/Admin", name="admin.show")
     */
    public function index()
    {
        $posts = $this->repo->findAll();
        return $this->render('pages/adminannonces.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/Admin/post/new", name="admin.new")
     */
    public function new(Request $request)
    {
        $post = new Posts();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostsType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'Votre annonce a bien été créée :)');
            return $this->redirectToRoute('admin.show');
        }

        return $this->render('pages/new.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/Admin/post/edit/{id}", name="admin.post.edit", methods="GET|POST")
     */
    public function edit(Posts $post, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($post);
            $entityManager->flush();
            $this->addFlash('success', 'Votre annonce a bien été modifiée :)');
            return $this->redirectToRoute('admin.show');
        }

        return $this->render('pages/adminedit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/Admin/post/edit/{id}", name="admin.post.delete", methods="DELETE")
     */
    public function delete(Posts $post, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $post->getId(), $request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
            $this->addFlash('success', 'Votre annonce a bien été supprimée :)');
        }
        return $this->redirectToRoute('admin.show');
    }

}