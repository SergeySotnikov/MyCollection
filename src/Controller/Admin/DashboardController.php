<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */


class DashboardController extends AbstractController
{


    /**
     * @Route("/dashboard", name= "admin_dashboard")
     */
    public function dashboard(): Response {
        return $this->render('Admin/Pages/dashboard.html.twig');
    }

}