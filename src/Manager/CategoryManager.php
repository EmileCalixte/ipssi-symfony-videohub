<?php


namespace App\Manager;


use App\Entity\Category;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class CategoryManager
{
    private $repository;
    private $em;

    public function __construct(CategoryRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function saveCategory(Category $category, $flush = true)
    {
        $this->em->persist($category);
        if($flush) $this->em->flush();
    }

    public function getAllCategories()
    {
        return $this->repository->findBy([], ['name' => 'ASC']);
    }

    public function getCategoryById($id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function deleteCategory(Category $category, $flush = true)
    {
        $this->em->remove($category);
        if($flush) $this->em->flush();
    }
}