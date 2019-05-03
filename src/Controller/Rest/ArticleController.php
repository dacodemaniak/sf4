<?php
namespace App\Controller\Rest;

use App\Entity\Article;
use App\Entity\Category;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Rest\Services\ArticleService;

/**
 *
 * @author Aélion
 *        
 */
class ArticleController extends FOSRestController
{
    /**
     * 
     * @var ArticleService
     */
    private $service;
    
    public function __construct(ArticleService $service) {
        $this->service = $service;
    }
    
    /**
     * @Rest\Get("/articles")
     * 
     * @param void
     * @return View
     */
    public function all(): View {
        
        return View::create($this->service->all(), Response::HTTP_OK);
        //return View::create($this->service->all(), Response::HTTP_OK, []);
    }
    
    /**
     * @Rest\Post("/articles")
     * 
     * @param Request $request
     * @return View
     */
    public function add(Request $request): View {
        
        $category = $this->_checkCategory($request->get("category"));
        
        $article = new Article();
        $article->setCreationDate(new \DateTime($request->get("date")))
            ->setTitle($request->get("title"))
            ->setContent($request->get("content"))
            ->setCategory($category);
        
       $this->service->save();
        
        return View::create($article, Response::HTTP_CREATED, []);
    }
    
    /**
     * @Rest\Put("/articles/{id}")
     * 
     * @param Request $request
     * @return View
     */
    public function update(Request $request): View {
        $category = $this->_checkCategory($request->get("category"));
        
        $repository = $this->getDoctrine()->getRepository(Article::class);
        if ($article = $repository->find($request->get("id"))) {
            $article
                ->setTitle($request->get("title"))
                ->setContent($request->get("content"))
                ->setCategory($category);
           $this->service->save($article);
            
            return View::create($article, Response::HTTP_OK, []);
        }
        
        return View::create(null, Response::HTTP_NOT_MODIFIED, []);
        
    }
    
    /**
     * @Rest\Delete("/articles/{id}")
     * 
     * @param Request $request
     * @return View
     */
    public function delete(Request $request): View {
        $repository = $this->getDoctrine()->getRepository(Article::class);
        if ($article = $repository->find($request->get("id"))) {
           $this->service->delete($article);
            
            return View::create(null, Response::HTTP_OK, []);
        }
        
        return View::create(null, Response::HTTP_NOT_FOUND, []);
    }
    
    private function _checkCategory(array $content): Category {
        if (array_key_exists("id", $content)) {
            $repository = $this->getDoctrine()->getRepository(Category::class);
            return $repository->find($content["id"]);
        }
        
        $em = $this->getDoctrine()->getManager();
        $category = (new Category())->setTitle($content["title"]);
        $em->persist($category);
        $em->flush();
        
        return $category;
    }
}

