<?php

namespace App\Controller\Front;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
  /**
   * @Route("/home", name="home")
   */
  public function home()
  {
    return $this->render('front/home.html.twig');
  }

  /**
   * @Route("/search", name="search")
   */
  public function search(ArticleRepository $articleRepository, Request $request)
  {
    $term = $request->query->get("search");
    $articles = $articleRepository->searchByTerm($term);

    return $this->render('front/search.html.twig', ['articles' => $articles, 'term' => $term]);
  }
}
