<?php


namespace App\Manager;


use App\Entity\User;
use App\Entity\Video;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class UserManager
{
    private $userRepository;
    private $entityManager;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function getAllUsers() {
        return $this->userRepository->findAll();
    }

    public function getUserByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }

    public function getUserById($id)
    {
        return $this->userRepository->findOneBy(['id' => $id]);
    }

    public function save(User $user, bool $flush = true)
    {
        $this->entityManager->persist($user);
        if($flush === true) {
            $this->entityManager->flush();
        }
    }
}