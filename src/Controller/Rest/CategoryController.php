<?php
namespace App\Controller\Rest;

use App\Entity\Article;
use App\Entity\Category;
use App\Controller\Rest\Services\MyService;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 *
 * @author Aélion
 *        
 */
class CategoryController extends FOSRestController
{
    /**
     * 
     * @var MyService
     */
    private $service;
    
    public function __construct(MyService $service) {
        $this->service = $service;
        
    }
    /**
     * @Rest\Get("/categories")
     * 
     * @return View
     */
    public function all(): View {
        
         $categoryRepo = $this->getDoctrine()->getRepository(Category::class);
         $categories = $categoryRepo->findAll();
        
         
         $articleRepo = $this->getDoctrine()->getRepository(Article::class);
        
         
/*          $all = [];
        
         foreach ($categories as $category) {
             var_dump($category);
             $articles = $articleRepo->findBy(["category" => $category]);
             $all["category"] = $category;
             $all["articles"] = $articles;
         } */
         return View::create("All", Response::HTTP_OK, []);
    }
}

