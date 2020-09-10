<?php

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\CourseRepository;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * @Route("/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="document_index")
     */
    public function index(DocumentRepository $documentRepository, CourseRepository $courseRepository): Response
    {
        $documents = $documentRepository->findAll();
        if ($documents) {
            foreach ($documents as $document) {
                $courses = $courseRepository->find($document->getId());
            }
        } else {
            $courses = null;
        }

        return $this->render('document/index.html.twig', [
            'documents' => $documents,
            'courses' => $courses,
        ]);
    }

    /**
     * @Route("/new", name="document_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $newDocument = new Document();
        $form = $this->createForm(DocumentType::class, $newDocument);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();

            /** @var UploadedFile $documentFile */
            $documentFile = $form->get('file')->getData();

            // this condition is needed because the 'document' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($documentFile) {
                // $originalFilename = pathinfo($documentFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                // $safeFilename = $slugger->slug($originalFilename);
                $safeFilename = 'doc';
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $documentFile->guessExtension();

                // Move the file to the directory where documents are stored
                try {
                    $documentFile->move(
                        $this->getParameter('documentDir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                // updates the 'documentFilename' property to store the PDF file name
                // instead of its contents
                $newDocument->setFileName($newFilename);

            }
            
            // ... persist the $document variable or any other work
            $courses = $form->get('courses')->getData();
            $entityManager->persist($newDocument);

            foreach ($courses as $course) {
                $course->addDocument($newDocument);
                $entityManager->persist($course);
            };
            
            $entityManager->flush();

            $this->addFlash('success', 'Document ajouté');

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/new.html.twig', [
            'document' => $newDocument,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('edit', 'Document édité');

            return $this->redirectToRoute('document_index');
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="document_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }
        $this->addFlash('delete', 'Document supprimé');


        return $this->redirectToRoute('document_index');
    }
}
