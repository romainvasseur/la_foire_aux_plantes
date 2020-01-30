<?php


namespace App\Controller\Admin;

use App\Entity\Posts;
use App\Entity\User;
use App\Form\PostsType;
use App\Entity\PostSearch;
use App\Entity\UserSearch;
use App\Form\PostSearchType;
use App\Form\UserSearchType;
use App\Repository\UserRepository;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminPostController extends AbstractController {

    private $repo;
    private $repoUser;

    public function __construct(PostsRepository $repo, UserRepository $repoUser)
    {
        $this->repo = $repo;
        $this->repoUser = $repoUser;
    }

    /**
     * @Route("/admin", name="admin.show")
     */
    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new PostSearch();
        $form = $this->createForm(PostSearchType::class, $search);
        $form->handleRequest($request);

        $posts = $paginator->paginate(
            $this->repo->findAllPages($search),
            $request->query->getInt('page', 1),
            30
        );
        return $this->render('pages/adminannonces.html.twig', [
            'posts' => $posts,
            'form' => $form->createView(),
        ]);
    }

    

    /**
     * @Route("/admin/post/new", name="admin.post.new")
     */
    public function new(Request $request, Security $security)
    {
        $post = new Posts();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostsType::class, $post);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $post->setUser($user);
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
     * @Route("/admin/post/edit/{id}", name="admin.post.edit", methods="GET|POST")
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
     * @Route("/admin/post/edit/{id}", name="admin.post.delete", methods="DELETE")
     */
    public function delete(Posts $post, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $post->getId(), $request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
            $this->addFlash('success', 'L\'annonce a bien été supprimée :)');
        }
        return $this->redirectToRoute('admin.show');
    }

    /**
     * @Route("/admin/users", name="admin.users")
     */
    public function adminUser(PaginatorInterface $paginator, Request $request)
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $users = $paginator->paginate(
            $this->repoUser->findAllUsers($search),
            $request->query->getInt('page', 1),
            8
        );
        return $this->render('pages/adminusers.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/user/edit/{id}", name="admin.user.delete", methods="DELETE")
     */
    public function banUser(User $user, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $user->getId(), $request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('success', 'L\'utilisateur a bien été banni et ses annonces supprimées :)');
        }
        return $this->redirectToRoute('admin.users');
    }

}