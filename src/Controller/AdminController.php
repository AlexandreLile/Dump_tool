<?php

namespace App\Controller;

use App\Entity\Outil;
use App\Form\OutilType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/outils', name: 'app_outils', methods: ['GET'])]
    public function outils(Request $request, EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Outil::class);
        $outils = $repository->findAll();
        return $this->render('admin/outils.html.twig', [
            'outils' => $outils
        ]);
    }

    #[Route('/outils/ajouter', name: 'app_add_outils')]
    public function add_outils(Request $request, ManagerRegistry $doctrine): Response
    {
        $outil = new Outil();
        $form = $this->createForm(OutilType::class, $outil);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em ->persist($outil);
            $em->flush();
            return $this->redirectToRoute('app_add_outils');
        }
        return $this->render('admin/add.html.twig', [
            'formoutil' => $form ,
        ]);
    }
}
