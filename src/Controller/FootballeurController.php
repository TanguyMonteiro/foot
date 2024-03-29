<?php

namespace App\Controller;

use App\Entity\Footballeur;
use App\Repository\FootballeurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/footAPI")
 */
class FootballeurController extends AbstractController
{
    /**
     * @Route("/footballeur", name="footballeur")
     */
    public function index(FootballeurRepository $repository): Response
    {
       $footballeurs = $repository->findAll();


        return $this->json($footballeurs);
    }
    /**
     * @Route("/delete/{id}" , name="delete_footballeur")
     */
    public function delete(Footballeur $footballeur , EntityManagerInterface $manager){
        $manager->remove($footballeur);
        $manager->flush();
        $message = "bien suprimer";
        return $this->json($message);
    }
    /**
     * @Route("/create", name="create_footballeur")
     */
    public function create(EntityManagerInterface $manager , Request $request , SerializerInterface $serializer){
       $json = $request->getContent();
      $footballeur = $serializer->deserialize($json, Footballeur::class , 'json');
       $manager->persist($footballeur);
       $manager->flush();

       return $this->json($footballeur);
    }
}
