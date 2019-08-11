<?php


namespace App\Manager;

use App\Entity\Video;
use App\Repository\CategoryRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;

class VideoManager
{
    private $repository;
    private $em;

    public function __construct(VideoRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    public function saveVideo(Video $video, $flush = true)
    {
        $this->em->persist($video);
        if($flush) $this->em->flush();
    }

    public function getVideoById($id)
    {
        return $this->repository->findOneBy(['id' => $id]);
    }

    public function deleteVideo(Video $video, $flush = true)
    {
        $this->em->remove($video);
        if($flush) $this->em->flush();
    }
}