<?php

namespace App\Controller;

use App\Entity\Youtube;
use App\Form\YoutubeType;
use App\Repository\YoutubeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// use RicardoFiorani\Matcher\VideoServiceMatcher;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
heroku login 
git init
git add -all
git commit -m "start"
heroku create
echo "web: heroku-php-apache2 public/" > Procfile
heroku config:set APP_ENV=prod
heroku addons:create heroku-postgresql:hobby-dev
jouer les migrations composer.json > scripts
"compile" : [
            "php bin/console doctrine:migrations:migrate"
]

composer require symfony/apache-pack
 */

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
            Request $request , 
            EntityManagerInterface $em ,
            YoutubeRepository $repo ,
            ): Response
    {
        $youtube = new Youtube();
        $form = $this->createForm(YoutubeType::class , $youtube);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
            //[ , $idVideoYoutube] = explode("=" , $youtube->getUrl() );
            //$youtube->setUrl($idVideoYoutube);
            /* $vsm = new VideoServiceMatcher();
            $video = $vsm->parse($youtube->getUrl());
            $youtube->setUrl($video->getEmbedCode(500, 380, true, true)); */
            $em->persist($youtube);
            $em->flush();
            $this->addFlash("confirm" , "le lien a été ajouté en bdd");
            return $this->redirectToRoute('app_home');
        }

        return $this->render('home/index.html.twig', [
            'youtubes' => $repo->findAll(),
            'form' => $form->createView()
        ]);
    }
}
