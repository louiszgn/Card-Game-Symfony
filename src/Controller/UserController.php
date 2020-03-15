<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/show/{id}", name="user")
     * @ParamConverter("user", options={"id"="id"})
     */
    // public function showUser(User $user)
    // {
    //     return $this->render('layout/details.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    /**
     * @Route("/user/edit/{id}", name="user_edit")
     * @ParamConverter("user", options={"id"="id"})
     */
    // public function editUser(Request $request, EntityManagerInterface $manager, User $user)
    // {
    //     $form = $this->createForm(UserFormType::class, $user);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em->persist($user);
    //         $em->flush();
    //         $this->addFlash('success', 'Utilisateur modifiée');
    //     }

    //     return $this->render('layout/form.html.twig', [
    //         'form' => $form->createView(),
    //         'title' => 'Utilisateur',
    //         'label' => 'Ajouter un utilisateur'
    //     ]);
    // }

    /**
     * @Route("/user/delete/{id}", name="user_delete")
     * @ParamConverter("user", options={"id"="id"})
     */
    // public function deleteUser(Request $request, EntityManagerInterface $manager, User $user)
    // {
    //     $manager->remove($user);
    //     $manager->flush();
    //     $this->addFlash('info', "Utilisateur supprimée");

    //     return $this->redirectToRoute('user');
    // }
}
