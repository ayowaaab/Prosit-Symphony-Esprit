<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Form\BookType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\CodeCoverage\Report\Html\Renderer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{

    #[Route('/book', name: 'app_book')]
    public function book(BookRepository $bookList): Response
    {
        $x=$bookList->changeRomance();
        $x = $bookList->findScience();
        $list = $bookList->findAll();

        return $this->render('book/published.html.twig', [
            'Tab' => $list,
            'sum' => $x,
        ]);
    }
   
    #[Route('/showRef', name: 'app_showRef')]
    public function showRef(Request $req, BookRepository $bookList): Response
    {
        $ref =$req->query->get('recherche');
        $list = $bookList->findRef($ref);
        return $this->render('book/published.html.twig', [
            'Tab' => $list,

        ]);
    }
    #[Route('/deuxDate', name: 'deuxDate')]
    public function deuxDate(Request $req, BookRepository $bookList): Response
    {
       
        $list = $bookList->deuxDate();
        return $this->render('book/deuxDate.html.twig', [
            'Tab' => $list,

        ]);
    }

    #[Route('/addbook', name: 'app_addbook')]
    public function addbook(ManagerRegistry $doctrine, Request $req, ): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $em = $doctrine->getManager();
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {            
            $book->setPublished(true);
            $author = $book->getAuthor();
            if($author instanceof Author){
                $author->setNbBooks($author->getNbBooks()+1);
            }
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute("app_book");
        }
        return $this->renderForm('book/add.html.twig', [
            'F' => $form,
        ]);
    }



    #[Route('/editbook/{ref}', name: 'app_editbook')]
    public function editbook(ManagerRegistry $doctrine, BookRepository $bookList, Request $req, int $ref): Response
    {
        $em = $doctrine->getManager();
        $book = $bookList->find($ref);
        $authorBefore = $book->getAuthor();
        $form = $this->createForm(BookType::class, $book);
        $authorAfter = $book->getAuthor();
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $authorBefore->setNbBooks($authorBefore->getNbBooks()-1);
            $authorAfter->setNbBooks($authorAfter->getNbBooks()+1);
            $em->persist($book);
            $em->flush();
        }
        return $this->renderForm('book/edit.html.twig', [
            'F' => $form,
        ]);
    }
    
    #[Route('/deletbook/{ref}', name: 'app_deletbook')]
    public function deletbook(ManagerRegistry $doctrine, BookRepository $bookList, int $ref): Response
    {
        $em = $doctrine->getManager();
        $bookDeleted = $bookList->find($ref);
        $author = $bookDeleted->getAuthor();
        if($author instanceof Author){
            $author->setNbBooks($author->getNbBooks()-1);
        }
        $em->remove($bookDeleted);
        $em->flush();
        return $this->redirectToRoute("app_book");
        
    }
    #[Route('/showbook/{ref}', name: 'app_showbook')]
    public function showbook(int $ref,BookRepository $book): Response
    {
        $Tab = $book->find($ref);
        $N = $Tab->getAuthor();
        return $this->render("book/show.html.twig",[
            'tab' => $Tab,
            'N' => $N->getNbBooks(),
        ]);

    }
}
