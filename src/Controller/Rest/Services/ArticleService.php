<?php
namespace App\Controller\Rest\Services;

use App\Entity\Article;
use App\Repository\ArticleRepository;

/**
 *
 * @author jean-luc
 *        
 */
class ArticleService
{
    /**
     * 
     * @var ArticleRepository
     */
    private $repository;
    
    public function __construct(ArticleRepository $articleRepository) {
        $this->repository = $articleRepository;
    }

    
    public function all() {
        return $this->repository->all();
    }
    
    public function save(Article $article) {
        return $this->repository->save($article);
    }
    
    public function delete(Article $article) {
        return $this->repository->delete($article);
    }
}

