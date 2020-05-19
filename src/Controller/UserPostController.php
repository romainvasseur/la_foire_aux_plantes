<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Posts;
use Twig\Environment;
use App\Form\PostsType;
use App\Entity\Wishlist;
use App\Form\WishlistType;
use App\Form\RegistrationType;
use App\Repository\UserRepository;
use App\Repository\PostsRepository;
use App\Repository\WishlistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserPostController extends AbstractController
{

    private $repo;
    private $repoUser;
    private $wrepo;

    public function __construct(PostsRepository $repo, UserRepository $repoUser, WishlistRepository $wrepo)
    {
        $this->repo = $repo;
        $this->repoUser = $repoUser;
        $this->wrepo = $wrepo;
    }
    
    /**
     * @Route("/profile/posts", name="user.show")
     */
    public function index(PaginatorInterface $paginator, PostsRepository $repo, Security $security, Request $request)
    {
        $user = $security->getUser();
        $id = $user->getId();
        $posts = $paginator->paginate(
            $this->repo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('userpost/userannonces.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     * @Route("/profile/post/new", name="user.post.new")
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
            return $this->redirectToRoute('user.show');
        }

        return $this->render('pages/new.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/profile/post/edit/{id}", name="user.post.edit", methods="GET|POST")
     */
    public function edit(Posts $post, Request $request, Security $security)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(PostsType::class, $post);
        $form->handleRequest($request);
        $user = $security->getUser();
        $verif = $post->getUser();

        if($form->isSubmitted() && $form->isValid()){
            if($user === $verif){
                $entityManager->persist($post);
                $entityManager->flush();
                $this->addFlash('success', 'Votre annonce a bien été modifiée :)');
                return $this->redirectToRoute('user.show');
            } else {
                return $this->render('userpost/usernon.html.twig');
            }
        }
        
        return $this->render('userpost/useredit.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/post/edit{id}", name="user.post.delete", methods="DELETE")
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
        return $this->redirectToRoute('user.show');
    }

    /**
     * @Route("/user/show/{id}", name="user.show.profile")
     */
    public function showUser($id, PaginatorInterface $paginator, PostsRepository $repo, Request $request, WishlistRepository $wrepo){
        $user = $this->repoUser->find($id);
        $posts = $paginator->paginate(
            $this->repo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            7
        );
        $wishlists = $paginator->paginate(
            $this->wrepo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            7
        );
        return $this->render('pages/showUser.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'wishlists' => $wishlists
        ]);
    }

    /**
     * @Route("/profile/myprofile/{id}", name="user.myprofile")
     */
    public function showMe($id, PaginatorInterface $paginator, PostsRepository $repo, Request $request, WishlistRepository $wrepo){
        $user = $this->repoUser->find($id);
        $posts = $paginator->paginate(
            $this->repo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            7
        );
        $wishlists = $paginator->paginate(
            $this->wrepo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            7
        );
        return $this->render('pages/showMyProfile.html.twig', [
            'user' => $user,
            'posts' => $posts,
            'wishlists' => $wishlists
        ]);
    }

    /**
     * @Route("/profile/myprofile/edit/{id}", name="user.edit.profile")
     */
    public function editProfile(User $user, Request $request, Security $security, UserPasswordEncoderInterface $encoder, $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        $test = $security->getUser();
        $verif = $user;

        if($form->isSubmitted() && $form->isValid()){
            if($test === $verif){
                $hash = $encoder->encodePassword($user, $user->getPassword());
                $user->setPassword($hash);
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Votre profil a bien été mis à jour :)');
                return $this->redirectToRoute('home');
            } else {
                return $this->render('userpost/usernon.html.twig');
            }
        }
        
        return $this->render('pages/showMe.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/wishlist", name="user.wishlist")
     */
    public function indexwishlist(PaginatorInterface $paginator, WishlistRepository $wrepo, Security $security, Request $request)
    {
        $user = $security->getUser();
        $id = $user->getId();
        $wishlists = $paginator->paginate(
            $this->wrepo->findBy(['user' => $id]),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('pages/userwishlist.html.twig', [
            'wishlists' => $wishlists
        ]);
    }

    /**
     * @Route("/profile/wishlist/new", name="user.wishlist.new")
     */
    public function newwishlist(Request $request, Security $security)
    {
        $wishlist = new Wishlist();
        $entityManager = $this->getDoctrine()->getManager();
        $form = $this->createForm(WishlistType::class, $wishlist);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $security->getUser();
            $wishlist->setUser($user);
            $entityManager->persist($wishlist);
            $entityManager->flush();
            $this->addFlash('success', 'Votre voeu a bien été créée :)');
            return $this->redirectToRoute('user.wishlist');
        }

        return $this->render('pages/newwishlist.html.twig', [
            'wishlist' => $wishlist,
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/profile/wishlist/edit{id}", name="user.wishlist.delete", methods="DELETE")
     */
    public function deletewish(Wishlist $wishlist, Request $request)
    {
        if($this->isCsrfTokenValid('delete'. $wishlist->getId(), $request->get('_token')))
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wishlist);
            $entityManager->flush();
            $this->addFlash('success', 'Votre voeu a bien été supprimé :)');
        }
        return $this->redirectToRoute('user.wishlist');
    }
    
}
