<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\EditUserFormType;
use App\Form\Handler\UserFormHandler;
use App\Repository\UserRepository;
use App\Utils\Manager\UserManager;
use phpDocumentor\Reflection\Types\This;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/user", name = "admin_user_")
 */
class UserController extends AbstractController
{

    /**
     * @Route("/list", name = "list")
     */
    public function list(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {

            return $this->redirectToRoute('admin_dashboard');
        }

        $user = $userRepository->findBy([],['id'=>'DESC']);

        return $this->render('admin/user/list.html.twig', [
            'user'=> $user
        ]);

    }


    /**
     * @Route("/edit/{id}", name = "edit")
     * @Route("/add", name = "add")
     */
    public function edit(Request $request, int $id=null, UserFormHandler $userFormHandler): Response
    {
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {

            return $this->redirectToRoute('admin_dashboard');
        }

        $entityManager = $this->getDoctrine()->getManager();

        //проверяем если id естт открываем форму айтема с данным id
        // а если нет перенаправляем на создание нового айтема
        if ($id) {
            $user = $entityManager->getRepository(User::class)->find($id);
        } else {
            $user = new User();
        }

        $form = $this->createForm(EditUserFormType::class, $user);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid() ) {

            //обращение к сервису для смены пороля
            $user = $userFormHandler->processEditForm($form);
            $this->addFlash('success', 'Your changes were saved!');

            //$entityManager->persist($user);
            //$entityManager->flush();

            return  $this->redirectToRoute('admin_user_list');

        }

        return $this->render('/admin/user/edit.html.twig', [
            'user' =>$user,
            'form'=>$form->createView()
        ]);


    }


    /**
     * @Route("/delete/{id}", name = "delete")
     */
    public function delete(User $user, UserManager $userManager): Response
    {
        if (!$this->isGranted('ROLE_SUPER_ADMIN')) {

            return $this->redirectToRoute('admin_dashboard');
        }

        $userManager->remove($user);

        $this->addFlash('warning', 'The User was successfully deleted!');

        return $this->redirectToRoute('admin_user_list');
    }

}