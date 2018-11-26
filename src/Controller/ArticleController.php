<?php
/**
 * Created by PhpStorm.
 * User: wilder
 * Date: 12/11/18
 * Time: 15:45
 */

namespace App\Controller;


use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Tag;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Flex\Response;



class ArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function show(Article $article) :Response
    {
        return $this->render('blog/article.html.twig', ['article'=>$article]);
    }
    /**
     *@Route("/articles", name="article_list")
     */
    public function list(Request $request)
    {
        $articles=$this->getDoctrine()
            ->getRepository(Article::class)
            ->findAll();

        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $article = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('article_list');
        }

        return $this->render(
            'blog/list.html.twig', [
                'articles' => $articles,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/tag/{name}", name="tag_show")
     */
    public function showByTag(Tag $tag) : Response
    {
        $tags = $tag->getArticles();

        return $this->render('blog/tag.html.twig',
            [
                'tag' => $tags
            ]
        );

    }
}