<?php
namespace App\Repository;

use App\Entity\EntityInterface;

/**
 *
 * @author jean-luc
 *        
 */
interface RepositoryInterface
{
    public function all(): array;
    
    public function save(EntityInterface $entity): EntityInterface;
    
    public function delete(EntityInterface $entity): void;
}

