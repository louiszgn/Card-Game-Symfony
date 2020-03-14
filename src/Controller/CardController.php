<?php

namespace App\Controller;

use App\Entity\Card;
use App\Form\CardFormType;
use App\Repository\CardRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    /**
     * @Route("/card", name="card")
     */
    public function listCards(EntityManagerInterface $em)
    {
        $cards = $em->getRepository('App:Card')->findAll();
        return $this->render('layout/index.html.twig', [
            'cards' => $cards,
            'title' => 'Liste des cartes'
        ]);
    }

    /**
     * @Route("/addcard", name="add_card")
     */
    public function addCard(Request $request, EntityManagerInterface $em)
    {
        $card = new Card();
        $form = $this->createForm(CardFormType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $card->setCreator($this->getUser());

            $em->persist($card);
            $em->flush();

            $dir = 'cards'; $newname = $card->getId().'.jpg';
            move_uploaded_file($_FILES['image']["tmp_name"], "$dir/$newname");

            $this->addFlash('success', 'Carte ajoutée');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Cartes',
            'label' => 'Ajouter une carte',
            'card' => true
        ]);
    }

    /**
     * @Route("/card/show/{id}", name="card_show")
     * @ParamConverter("card", options={"id"="id"})
     */
    public function showCard(Card $card)
    {
        return $this->render('layout/details.html.twig', [
            'card' => $card,
        ]);
    }

    /**
     * @Route("/card/edit/{id}", name="card_edit")
     * @ParamConverter("card", options={"id"="id"})
     */
    public function editCard(Request $request, EntityManagerInterface $manager, Card $card)
    {
        $form = $this->createForm(CardFormType::class, $card);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($card);
            $manager->flush();

            $dir = 'cards'; $newname = $card->getId().'.jpg';
            move_uploaded_file($_FILES['image']["tmp_name"], "$dir/$newname");

            $this->addFlash('info', "Carte modifiée");
        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/card/delete/{id}", name="card_delete")
     * @ParamConverter("card", options={"id"="id"})
     */
    public function deleteCard(Request $request, EntityManagerInterface $manager, Card $card)
    {
        $manager->remove($card);
        $manager->flush();
        $this->addFlash('info', "Carte supprimée");

        return $this->redirectToRoute('card');
    }
}
