<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Form\SessionType;
use App\Form\SessionAddType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
// create a new session
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
    public function show(Session $session, SessionRepository $sessionRepository): Response
    {

        $traineeNotInSession = $sessionRepository->findByStagiairesNotInSession($session->getId());
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'unsubscribedTrainee' => $traineeNotInSession,
        ]);
    }
    //add a new session to a training
    #[Route('/{id}/add', name: 'app_session_add', methods: ['GET', 'POST'])]
    public function addSession(Request $request, Training $training, EntityManagerInterface $entityManager): Response
    {
        $session = new Session;
        $form = $this->createForm(SessionAddType::class, $session);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $training->addSession($session);
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('app_session_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('session/addNew.html.twig', [
            'session' => $session,
            'training' => $training,
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }
    //update a existent session
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

    //add or remove a trainee from a session (subsribe and unsubsribe)

    
    #[Route("/session/{idSession}/unsubscribeTrainee/{idTrainee}", name: 'unsubscribeTrainee')]
          
    public function unsubscribeTrainee( EntityManagerInterface $entityManager, Session $idSession, Trainee $idTrainee): Response
    {

        $idSession->removeTrainee($idTrainee);
        $idTrainee->removeSession($idSession);
        $entityManager->flush();

    return $this->redirectToRoute('app_session_show', ['id' => $idSession->getId()]);
    }  
    
    #[Route("/session/{idSession}/subsribeTrainee/{idTrainee}", name: 'subsribeTrainee')]    
        
    public function subsribeTrainee(EntityManagerInterface $entityManager, Session $idSession, Trainee $idTrainee): Response
    {
        $idSession->addTrainee($idTrainee);
        $idTrainee->addSession($idSession);
        $entityManager->persist($idSession);
        $entityManager->flush();

    return $this->redirectToRoute('app_session_show', ['id' => $idSession->getId()]);
    }
    
}
