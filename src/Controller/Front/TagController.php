<?php

namespace App\Controller\Front;

use App\Repository\TagRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class TagController extends AbstractController
{
  /**
   * @Route("/tags", name="tagList")
   */
  public function tagList(tagRepository $tagRepository)
  {
    $tags = $tagRepository->findAll();
    return $this->render('front/tags.html.twig', ['tags' => $tags]);
  }
  /**
   * @Route("/tag/{id}", name="tagShow")
   */
  public function tagShow($id, tagRepository $tagRepository)
  {
    $tag = $tagRepository->find($id);
    return $this->render('front/tag.html.twig', ['tag' => $tag]);
  }
}
