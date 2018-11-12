<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 03/11/18
 * Time: 18:52
 */

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog/{slug}", name="blog_show", requirements={"slug"="[a-z0-9-]+"})
     */
//    public function show($slug='article sans titre')
//    {
//        $slug2 = str_replace("-"," ",$slug);
//        $slug3 = ucwords($slug2);
//
//        return $this->render('blog/index.html.twig', ['slug' => $slug3]);
//    }

//    /**
//     *@Route("/blog/categories", name="blog_listCategories"
//     */
//    public function listCategories()
//    {
//
//        return $this->render('blog/listCategories.html.twig', ['categories' => $categories]);
//    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article) :Response
    {
        return $this->render('blog/article.html.twig', ['article'=>$article]);
    }
}