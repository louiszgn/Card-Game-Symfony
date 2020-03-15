<?php

namespace App\Controller;

use App\Entity\Faction;
use App\Form\FactionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FactionController extends AbstractController
{
    /**
     * @Route("/faction", name="faction")
     */
    public function listFaction(EntityManagerInterface $em)
    {
        $factions = $em->getRepository('App:Faction')->findAll();
        return $this->render('layout/index.html.twig', [
            'factions' => $factions,
            'title' => 'Liste des factions'
        ]);
    }

    /**
     * @Route("/addfaction", name="add_faction")
     */
    public function addfaction(Request $request, EntityManagerInterface $em)
    {
        $faction = new Faction();
        $form = $this->createForm(FactionFormType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $em->persist($faction);
            $em->flush();
            $this->addFlash('success', 'Faction ajoutée');

        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Factions',
            'label' => 'Ajouter une faction'
        ]);
    }

    /**
     * @Route("/faction/show/{id}", name="faction_show")
     * @ParamConverter("faction", options={"id"="id"})
     */
    public function showFaction(Faction $faction)
    {
        return $this->render('layout/details.html.twig', [
            'faction' => $faction,
        ]);
    }

    /**
     * @Route("/faction/edit/{id}", name="faction_edit")
     * @ParamConverter("faction", options={"id"="id"})
     */
    public function editFaction(Request $request, EntityManagerInterface $manager, Faction $faction)
    {
        $form = $this->createForm(FactionFormType::class, $faction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($faction);
            $em->flush();
            $this->addFlash('success', 'Faction modifiée');
        }

        return $this->render('layout/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Factions',
            'label' => 'Modifier une faction'
        ]);
    }

    /**
     * @Route("/faction/delete/{id}", name="faction_delete")
     * @ParamConverter("faction", options={"id"="id"})
     */
    public function deleteFaction(Request $request, EntityManagerInterface $manager, Faction $faction)
    {
        $manager->remove($faction);
        $manager->flush();
        $this->addFlash('info', "Faction supprimée");

        return $this->redirectToRoute('faction');
    }
}
