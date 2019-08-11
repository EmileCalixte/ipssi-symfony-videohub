<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Manager\VideoManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/videos", name="videos")
     */
    public function index(Request $request, VideoManager $manager)
    {
        $newVideo = new Video();

        $form = $this->createForm(VideoType::class, $newVideo);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $newVideo->setUser($this->getUser());
            $newVideo->setCreatedAt(new \DateTime());
            $manager->saveVideo($newVideo);
        }

//        $categories = $manager->getAllCategories();

        return $this->render('video/index.html.twig', [
            'form' => $form->createView(),
//            'categories' => $categories,
        ]);
    }
}
