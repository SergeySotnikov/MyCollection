<?php

namespace App\Controller;

use App\Entity\CollectionItem;
use App\Form\EditCollectionItemFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/",methods="GET" ,name = "main_homepage")
     */

    public function index(): Response
    {
        $entityManager= $this->getDoctrine()->getManager();
        $itemList= $entityManager->getRepository(CollectionItem::class)->findAll();
        //dd($itemList);


        return $this->render('main/homepage/index.html.twig', []);
    }



    //создание и редактирование айтема
    /**
     * @Route("/collection-item-edit/{id}",methods="GET|POST",name = "collectionItemEdit", requirements={"id"="\d+"})
     * @Route("/collection-item-add", methods="GET|POST", name = "collectionItemAdd")
     */

    public function editCollectionItem(Request $request, int $id=null): Response
    {
        $entityManager= $this->getDoctrine()->getManager();
        //проверяем если id естт открываем форму айтема с данным id
        // а если нет перенаправляем на создание нового айтема
        if ($id) {
            $collectionItem = $entityManager->getRepository(CollectionItem::class)->find($id);
        } else {
            $collectionItem = new CollectionItem();
        }

        // создали форму c
        $form = $this->createForm(EditCollectionItemFormType::class,$collectionItem);

        // проверили форму на валидность и отправку и записали в БД
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($collectionItem);
            $entityManager->flush();
            //после записи делаем редирект на ийтем с этим id
            return $this->redirectToRoute('collectionItemEdit',['id'=>$collectionItem->getId()]);
        }


        return $this->render('main/editCollectionItem/edit_collection_item.html.twig', [
            'form'=> $form->createView(),
        ]);
    }
}
