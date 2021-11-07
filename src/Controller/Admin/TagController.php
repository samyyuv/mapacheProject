<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class TagController extends AbstractController
{
  /**
   * @Route("/admin/tags", name="adminTagList")
   */
  public function adminTagsList(TagRepository $tagRepository)
  {
    $tags = $tagRepository->findAll();
    return $this->render('admin/tags.html.twig', ['tags' => $tags]);
  }

  /**
   * @Route("/admin/tag/{id}", name="adminTagShow")
   */
  public function adminTagShow($id, TagRepository $tagRepository)
  {
    $tag = $tagRepository->find($id);
    return $this->render('admin/tag.html.twig', ['tag' => $tag]);
  }

  /**
   * @Route("/admin/create/tag", name="adminTagCreate")
   */
  public function adminTagCreate(EntityManagerInterface $entityManagerInterface, Request $request)
  {
    $tag = new Tag;
    $tagForm = $this->createForm(TagType::class, $tag);
    $tagForm->handleRequest($request);

    if ($tagForm->isSubmitted() && $tagForm->isValid()) {
      $entityManagerInterface->persist($tag);
      $entityManagerInterface->flush();

      return $this->redirectToRoute('adminTagList');
    }
    return $this->render('admin/tagForm.html.twig', ['tagForm' => $tagForm->createView()]);
  }

  /**
   * @Route("/admin/update/tag/{id}", name="adminTagUpdate")
   */
  public function adminTagUpdate($id, Request $request, EntityManagerInterface $entityManagerInterface, TagRepository $tagRepository)
  {
    $tag = $tagRepository->find($id);
    $tagForm = $this->createForm(TagType::class, $tag);
    $tagForm->handleRequest($request);

    if ($tagForm->isSubmitted() && $tagForm->isValid()) {
      $entityManagerInterface->persist($tag);
      $entityManagerInterface->flush();
      return $this->redirectToRoute("adminTagList");
    }
    return $this->render("admin/tagForm.html.twig", ['tagForm' => $tagForm->createView()]);
  }

  /**
   * @Route("admin/delete/tag/{id}", name="adminTagDelete")
   */
  public function adminTagDelete($id, EntityManagerInterface $entityManagerInterface, TagRepository $tagRepository)
  {
    $tag = $tagRepository->find($id);
    $entityManagerInterface->remove($tag);
    $entityManagerInterface->flush();
    return $this->redirectToRoute('adminTagList');
  }
}
