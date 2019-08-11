<?php

namespace App\Controller;

use App\Manager\CategoryManager;
use App\Manager\UserManager;
use App\Manager\VideoManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(CategoryManager $manager)
    {
        $categories = $manager->getAllCategories();

        return $this->render('home/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/video/{id}", name="video_id")
     */
    public function video(int $id, VideoManager $videoManager)
    {
        $video = $videoManager->getVideoById($id);

        if(is_null($video)) {
            throw new NotFoundHttpException();
        }

        return $this->render('home/video_id.html.twig', [
            'video' => $video
        ]);
    }

    /**
     * @Route("/user/{id}", name="user_id");
     */
    public function user(int $id, UserManager $manager) {
        $user = $manager->getUserById($id);

        if(is_null($user)) {
            throw new NotFoundHttpException();
        }

        return $this->render('home/user_id.html.twig', [
            'user' => $user,
        ]);
    }
}
