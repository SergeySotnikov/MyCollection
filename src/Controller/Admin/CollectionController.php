<?php

namespace App\Controller\Admin;

use App\Entity\Collection;
use App\Form\EditCollectionFormType;
use App\Repository\CollectionRepository;
use App\Utils\Manager\CollectionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/collection", name = "admin_collection_")
 */
class CollectionController extends AbstractController
{

    /**
     * @Route("/list", name = "list")
     */
    public function list(CollectionRepository $collectionRepository): Response
    {
        $collection = $collectionRepository->findBy([],['id'=>'DESC']);

        return $this->render('admin/collection/list.html.twig', [
            'collection'=> $collection
        ]);
    }


    /**
     * @Route("/edit/{id}", name = "edit")
     * @Route("/add", name = "add")
     */
    public function edit(Request $request, int $id=null): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        //проверяем если id естт открываем форму айтема с данным id
        // а если нет перенаправляем на создание нового айтема
        if ($id) {
            $collection = $entityManager->getRepository(Collection::class)->find($id);
        } else {
            $collection = new Collection();
        }

        $form = $this->createForm(EditCollectionFormType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $entityManager->persist($collection);
            $entityManager->flush();

            return  $this->redirectToRoute('admin_collection_list');

        }

        return $this->render('/admin/collection/edit.html.twig', [
            'collection' =>$collection,
            'form'=>$form->createView()
        ]);
    }


    /**
     * @Route("/delete/{id}", name = "delete")
     */
    public function delete(Collection $collection, CollectionManager $collectionManager): Response
    {
        $collectionManager->remove($collection);

        return $this->redirectToRoute('admin_collection_list');
    }

}
