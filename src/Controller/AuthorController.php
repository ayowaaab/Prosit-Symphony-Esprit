<?php

namespace App\Controller;


use Doctrine\Persistence\ManagerRegistry;
use App\Repository\AuthorRepository;
use App\Entity\Author;
use App\Form\FormType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AuthorController extends AbstractController
{
    // ! ------------------------- Prosit 4 ----------------------

    #[Route('/author', name: 'app_showAuthorDB')]
    public function showAuthorDB(AuthorRepository $repo): Response
    {
        $list = $repo->findOrderEmail();
        return $this->render('author/showAuthorDB.html.twig', [
            'dbList' => $list,
        ]);
    }

    #[Route('/addauthor', name: 'app_addauthor')]
    public function addauthor(ManagerRegistry $doctrine, Request $req): Response
    {
        $em = $doctrine->getManager();
        $author = new Author();
        $form = $this->createForm(FormType::class, $author);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_showAuthorDB');
        }
        return $this->renderForm('author/add.html.twig', [
            'F' => $form,
        ]);
    }



    #[Route('/editauthor/{id}', name: 'app_editauthor')]
    public function editauthor($id, ManagerRegistry $manager, AuthorRepository $authorrepo, Request $req): Response
    {
        $em = $manager->getManager();
        $idData = $authorrepo->find($id);
        $form = $this->createForm(FormType::class, $idData);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('app_showAuthorDB');
        }
        return $this->renderForm('author/edit.html.twig', [
            'F' => $form
        ]);
    }


    #[Route('/deleteauthor/{id}', name: 'app_deleteauthor')]
    public function deleteauthor(ManagerRegistry $doctrine, Request $req, int $id, AuthorRepository $repo): Response
    {
        $em = $doctrine->getManager();
        $remove = $em->getRepository(Author::class)->find($id);
        if ($remove) {
            $em->remove($remove);
            $em->flush();
            return $this->redirectToRoute('app_showAuthorDB');
        }
        return new Response("<h1>Can't Delete unknown Object 😒</h1>");
    }
}
