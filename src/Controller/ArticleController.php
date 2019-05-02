<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;

class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ArticleController.php',
        ]);
    }

    /**
     * @Route("/article/add", methods={"POST", "HEAD"}, name="add-article")
     */
    public function add(): Response {
        $article = new Article();
        $article
            ->setCreationDate(new \DateTime())
            ->setTitle("Premier article")
            ->setContent(
                [
                    "abstract" => "Troisième article",
                    "content" => "Try to get the serialization",
                    "see" => "https://docs.symfony.com/serialization"
                ]
            );
        $repository = $this->getDoctrine()->getManager();
        $repository->persist($article);
        $repository->flush();
        
        return new Response(
            $this->json(["id" => $article->getId()]), 
            Response::HTTP_CREATED,
            []
        );
    }
    
    /**
     * @Route("/article/{id}", methods={"PUT", "HEAD"}, name="upd-article")
     */
    public function update(Request $request): Response {
        // Chercher l'article à partir de l'ID passé en paramètre
        $repository = $this->getDoctrine()->getRepository(Article::class);
        $article = $repository->find($request->get("id"));
        
        if ($article) {
            $article->setTitle("Titre du troisième article");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();
            
            return new Response(
                $this->json(["id" => $article->getId()]),
                Response::HTTP_ACCEPTED
            );
        } else {
            return new Response(
                "L'article : " . $request->get("id") . " n'existe plus !",
                Response::HTTP_NOT_MODIFIED
             );
        }

    }
}
