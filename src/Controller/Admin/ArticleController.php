<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
  /**
   * @Route("/admin/articles", name="adminArticleList")
   */
  public function articleList(ArticleRepository $articleRepository)
  {
    $articles = $articleRepository->findAll();
    return $this->render('admin/articles.html.twig', ['articles' => $articles]);
  }

  /**
   * @Route("/admin/article/{id}", name="adminArticleShow")
   */
  public function articleShow($id, ArticleRepository $articleRepository)
  {
    $article = $articleRepository->find($id);
    return $this->render('admin/article.html.twig', ['article' => $article]);
  }

  /**
   * @Route("/admin/create/article", name="adminArticleCreate")
   */
  public function adminArticleCreate(Request $request, EntityManagerInterface $entityManagerInterface)
  {
    $article = new Article();
    $articleForm = $this->createForm(ArticleType::class, $article);
    $articleForm->handleRequest($request);

    if ($articleForm->isSubmitted() && $articleForm->isValid()) {
      $entityManagerInterface->persist($article);
      $entityManagerInterface->flush();

      return $this->redirectToRoute("adminArticleList");
    }
    return $this->render('admin/articleForm.html.twig', ['articleForm' => $articleForm->createView()]);
  }

  /**
   * @Route("/admin/update/article/{id}", name="adminArticleUpdate")
   */
  public function adminArticleUpdate($id, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
  {
    $article = $articleRepository->find($id);
    $articleForm = $this->createForm(ArticleType::class, $article);
    $articleForm->handleRequest($request);

    if ($articleForm->isSubmitted() && $articleForm->isValid()) {
      $entityManagerInterface->persist($article);
      $entityManagerInterface->flush();

      return $this->redirectToRoute("adminArticleList");
    }
    return $this->render('admin/articleForm.html.twig', ['articleForm' => $articleForm->createView()]);
  }

  /**
   * @Route("/admin/delete/article/{id}", name="adminArticleDelete")
   */
  public function adminArticleDelete($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManagerInterface)
  {
    $article = $articleRepository->find($id);
    $entityManagerInterface->remove($article);
    $entityManagerInterface->flush();

    return $this->redirectToRoute('adminArticleList');
  }
}
