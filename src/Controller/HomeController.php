<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 03/11/18
 * Time: 12:31
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */

    public function index()
    {
        $message = 'Hello WCS';
        return $this->render('lucky/home.html.twig', ['message' => $message]);
    }
}