<?php

namespace App\Controller\Admin;

use App\Entity\CollectionItem;
use App\Form\EditCollectionItemFormType;
use App\Repository\CollectionItemRepository;
use App\Utils\Manager\ItemManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/collectionItem", name = "admin_collectionItem_")
 */

class CollectionItemController extends AbstractController
{
    /**
     * @Route("/list", name = "list")
     */
    public function list(CollectionItemRepository $collectionItemRepository): Response
    {
        $collectionItem = $collectionItemRepository->findAll();

        return $this->render('admin/collectionItem/list.html.twig', [
            'collectionItem'=> $collectionItem
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
            $collectionItem = $entityManager->getRepository(CollectionItem::class)->find($id);
        } else {
            $collectionItem = new CollectionItem();
        }

        $form = $this->createForm(EditCollectionItemFormType::class, $collectionItem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {

            $entityManager->persist($collectionItem);
            $entityManager->flush();

            return  $this->redirectToRoute('admin_collectionItem_list');

        }

        return $this->render('/admin/collectionItem/edit.html.twig', [
            'collectionItem' =>$collectionItem,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name = "delete")
     */
    public function delete(CollectionItem $collectionItem, ItemManager $itemManager): Response
    {
        $itemManager->remove($collectionItem);

        return $this->redirectToRoute('admin_collectionItem_list');
    }
}
