<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 03/11/18
 * Time: 18:52
 */

namespace App\Controller;

use App\Entity\Category;
use App\Form\ArticleSearchType;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\Form\FormView;

class BlogController extends AbstractController
{
    /**
     * Show all row from article's entity
     *
     * @Route("/", name="blog_index")
     * @return Response A response instance
     */
    public function index(Request $request) : Response
    {
        $articles = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        if (!$articles) {
            throw $this->createNotFoundException(
                'No article found in article\'s table.'
            );
        }

        $form = $this->createForm(
            ArticleSearchType::class);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $data = $form->getData();
        }

        return $this->render(
            'blog/index.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
                ]
        );


    }


    /**
     * Getting a article with a formatted slug for title
     *
     * @param string $slug The slugger
     *
     * @Route("/blog/{slug<^[a-z0-9-]+$>}",
     *     defaults={"slug" = null},
     *     name="blog_show")
     *  @return Response A response instance
     */
    public function show($slug) : Response
    {
        if (!$slug) {
            throw $this
                ->createNotFoundException('No slug has been sent to find an article in article\'s table.');
        }

        $slug = preg_replace(
            '/-/',
            ' ', ucwords(trim(strip_tags($slug)), "-")
        );

        $article = $this->getDoctrine()
            ->getRepository(Article::class)
            ->findOneBy(['title' => mb_strtolower($slug)]);

        if (!$article) {
            throw $this->createNotFoundException(
                'No article with '.$slug.' title, found in article\'s table.'
            );
        }

        return $this->render(
            'blog/show.html.twig',
            [
                'article' => $article,
                'slug' => $slug,
            ]
        );
    }

//    /**
//     * Show articles from Category
//     *
//     * @Route("/category/{category}", name="blog_show_category")
//     * @return Response A response instance
//    */
//    public function showByCategory(string $category) : Response
//    {
//        $category = $this
//            ->getDoctrine()
//            ->getRepository(Category::class)
//            ->findOneByName($category)
//        ;
//
//        $articles = $this
//            ->getDoctrine()
//            ->getRepository(Article::class)
//            ->findBy(array('category'=> $category),null, 3)
//        ;
//
//        return $this->render(
//            'blog/category.html.twig',
//            [
//                'articles' => $articles,
//                'category' => $category,
//            ]
//        );
//    }

    /**
     * Show all articles from one Category
     *
     * @Route("/category/{name}/all", name="blog_show_allbyCategory")
     * @return Response A response instance
     */
    public function showAllByCategory(Category $category) : Response
    {
        $categories = $category->getArticles();

        return $this->render(
            'blog/showAllByCategory.html.twig',
            [
                'category' => $categories,
            ]
        );
    }
}