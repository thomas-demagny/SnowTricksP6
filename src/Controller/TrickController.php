<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/")
 */
class TrickController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET"})
     * @Route("/trick/category/{id}", name="trick_category", methods={"GET"})
     * @param TrickRepository $trickRepository
     * @param CategoryRepository $categoryRepository
     * @param int|null $id
     * @return Response
     */
    public function index(TrickRepository $trickRepository, CategoryRepository $categoryRepository, int $id = null): Response
    {

        $trick = $id ? $trickRepository->findTrickByCategory($id): $trickRepository->findAll();

        return $this->render('trick/index.html.twig', [
            'tricks' => $trick,
            'categories'=> $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/new", name="trick_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request ): Response
    {
        $trick = new Trick($this->getUser());
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trick);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("trick/{id}", name="trick_show")
     * @Entity("trick", expr="repository.findTrickWithCategories(id)")
     * @param $id
     * @param Trick $trick
     * @param CommentRepository $commentRepository
     * @param Request $request
     * @return Response
     */
    public function show($id,Trick $trick, CommentRepository $commentRepository, Request $request): Response
    {
        $comments = $commentRepository->findCommentsWithUser($trick);


        $comment = new Comment($this->getUser(), $trick);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if($this->getUser()){
            $entityComment = $this->getDoctrine()->getManager();
            $entityComment->persist($comment);
            $entityComment->flush();

            return $this->redirect($this->generateUrl('trick_show',
                    ['id' => $id,]).'#comments');
        }
        }

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form'=> $form->createView(),
            'comments'=>$comments
        ]);
    }

    /**
     * @Route("trick/{id}/edit", name="trick_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Trick $trick
     * @return Response
     */
    public function edit(Request $request, Trick $trick): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trick->setUpdateAt(new DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trick_delete", methods={"DELETE"})
     * @param Request $request
     * @param Trick $trick
     * @return Response
     */
    public function delete(Request $request, Trick $trick): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}