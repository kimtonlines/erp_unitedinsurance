<?php
/**
 * Created by PhpStorm.
 * User: kimt
 * Date: 28/12/18
 * Time: 18:40
 */

namespace App\Controller\Commercial;


use App\Entity\Commercial\Commercial;
use App\Form\CommercialType;
use App\Repository\Commercial\CommercialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Commercial
 * @package App\Controller\Direction_Commerciale
 * @Route("direction-commerciale")
 */
class CommercialController extends AbstractController
{

    /**
     * @param Request $request
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/ajouter-commerciaux", name="ajouter-commerciaux")
     */
    public function ajouter (Request $request, ObjectManager $objectManager)
    {
        $commercial = new Commercial();

        $form = $this->createForm(CommercialType::class, $commercial);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $code = "UI-ABJ-".$commercial->getTelephone();
            $commercial->setCode($code);
            $objectManager->persist($commercial);
            $objectManager->flush();

//            return $this->redirectToRoute('liste-commercial', ['slug' => $commercial->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/commerciaux/ajouter-commerciaux.html.twig', [
            'commercial' => $commercial,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/liste-commerciaux", name="liste-commerciaux")
     */
    public function liste (CommercialRepository $commercialRepository)
    {
        $commercials = $commercialRepository->findAll();
        return $this->render('erp/direction_commerciale/commerciaux/liste-commerciaux.html.twig', [
            'commercials' => $commercials
        ]);
    }


    /**
     * @param Commercial $commercial
     * @param CommercialRepository $commercialRepository
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/information-commerciaux/{slug}", name="information-commerciaux")
     */
    public function informationAndUpdate (Commercial $commercial, Request $request)
    {
        $form = $this->createForm(CommercialType::class, $commercial);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('information-commerciaux', ['slug' => $commercial->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/commerciaux/infomation-update-commerciaux.html.twig', [
            'commercial' => $commercial,
            'form' => $form->createView(),
        ]);
    }
}