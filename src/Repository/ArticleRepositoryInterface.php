<?php
namespace App\Repository;

use App\Entity\Article;
use App\Repository\RepositoryInterface;
use App\Entity\EntityInterface;

/**
 *
 * @author Aélion
 *        
 */
interface ArticleRepositoryInterface extends RepositoryInterface
{
    public function all(): array;
    
    public function save(EntityInterface $article): EntityInterface;
    
    public function delete(EntityInterface $article): void;
}

