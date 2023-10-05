<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/session')]
class SessionController extends AbstractController
{
    #[Route('/', name: 'app_session_index', methods: ['GET'])]
    public function index(SessionRepository $sessionRepository): Response
    {
        return $this->render('session/index.html.twig', [
            'sessions' => $sessionRepository->findAll(),
        ]);
    }
// add a new session
    #[Route('/new', name: 'app_session_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = new Session();
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_edit', ['id' => $session->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/new.html.twig', [
            'session' => $session,
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }
//display session details
    #[Route('/{id}', name: 'app_session_show', methods: ['GET'])]
    public function show(Session $session): Response
    {

        $traineeNotInSession = $SessionRepository->getNonSubscriber($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'unregistredTrainee' => $traineeNotInSession,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SessionType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/edit.html.twig', [
            'session' => $session,
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }

    #[Route('/{id}', name: 'app_session_delete', methods: ['POST'])]
    public function delete(Request $request, Session $session, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$session->getId(), $request->request->get('_token'))) {
            $entityManager->remove($session);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
    }

    //add or remove a trainee from a session

    
    #[Route("/session/removeTrainee/{idS}/{idT}", name: 'removeTrainee')]
    // ParamConverter permet de convertir les parametres en instances de Session et de Stagiaire en utilisant l'injection de
    // dependance de Doctrine pour recuper les entités correspondant à la base de donnée
    #[ParamConverter("session", options:["mapping"=>["idS"=>"id"]])]
    #[ParamConverter("intern", options:["mapping"=>["idT"=>"id"]])]
    
    public function removeStagiaire(ManagerRegistry $doctrine, Session $session, Trainee $trainee)
    {
        $em = $doctrine->getManager();
        $session->removeTrainee($intern);
        $em->persist($session);
        $em->flush();

    return $this->redirectToRoute('app_session_show', ['id' => $session->getId()]);
    }  
    
    #[Route("/session/addTrainee/{idS}/{idI}", name: 'addTrainee')]    
    #[ParamConverter("session", options:["mapping"=>["idS"=>"id"]])]
    #[ParamConverter("intern", options:["mapping"=>["idI"=>"id"]])]
    
    public function addTrainee(ManagerRegistry $doctrine, Session $session, Trainee $trainee)
    {
        $em = $doctrine->getManager();
        $session->addIntern($intern);
        $em->persist($session);
        $em->flush();

    return $this->redirectToRoute('app_session_show', ['id' => $session->getId()]);
    }
    
}
