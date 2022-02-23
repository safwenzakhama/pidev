<?php

namespace App\Controller;

use App\Entity\Categoryexercice;
use App\Entity\Exercice;
use App\Form\CategoryexerciceType;
use App\Repository\CategoryexerciceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Gedmo\Sluggable\Util\Urlizer;

/**
 * @Route("/categoryexercice")
 */
class CategoryexerciceController extends AbstractController
{
    /**
     * @Route("/", name="categoryexercice_index", methods={"GET"})
     */
    public function index(CategoryexerciceRepository $categoryexerciceRepository): Response
    {
        return $this->render('categoryexercice/indexf.html.twig', [
            'categoryexercices' => $categoryexerciceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categoryexercice_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $categoryexercice = new Categoryexercice();
        $form = $this->createForm(CategoryexerciceType::class, $categoryexercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['photo']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $categoryexercice->setPhoto($newFilename);
            $entityManager->persist($categoryexercice);
            $entityManager->flush();

            return $this->redirectToRoute('categoryexercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoryexercice/new.html.twig', [
            'categoryexercice' => $categoryexercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoryexercice_show", methods={"GET"})
     */
    public function show($id): Response
    {
        $cat=$this->getDoctrine()->getRepository(Categoryexercice::class)->find($id);
        $exercice=$this->getDoctrine()->getRepository(Exercice::class)->findBy(array('categoryexercice'=>$cat));
        return $this->render('exercice/indexf.html.twig', [
            'exercices' => $exercice,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categoryexercice_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Categoryexercice $categoryexercice, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CategoryexerciceType::class, $categoryexercice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['photo']->getData();
            $destination = $this->getParameter('kernel.project_dir').'/public/uploads';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $categoryexercice->setPhoto($newFilename);
            $entityManager->flush();

            return $this->redirectToRoute('categoryexercice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('categoryexercice/edit.html.twig', [
            'categoryexercice' => $categoryexercice,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="categoryexercice_delete", methods={"POST"})
     */
    public function delete(Request $request, Categoryexercice $categoryexercice, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categoryexercice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($categoryexercice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categoryexercice_index', [], Response::HTTP_SEE_OTHER);
    }
}
