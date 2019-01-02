<?php
/**
 * Created by PhpStorm.
 * User: kimt
 * Date: 28/12/18
 * Time: 18:40
 */

namespace App\Controller\Commercial;


use App\Entity\Commercial\Commercial;
use App\Form\Commercial\CommercialType;
use App\Repository\Commercial\CommercialRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/commerciaux/{slug}/modifier", name="modifier-commerciaux")
     */
    public function ajouter(?Commercial $commercial, Request $request, ObjectManager $objectManager, CommercialRepository $commercialRepository)
    {
        if (!$commercial) {
            $commercial = new Commercial();
        }

        $form = $this->createForm(CommercialType::class, $commercial);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$commercial->getCode()) {
                $commerciauxId = $commercialRepository->findOneBy(array(), array('id' => 'desc'));

                if ($commerciauxId) {
                    $nombre = $commerciauxId->getId() + 1;
                    if ($commerciauxId->getId()  < 9 ) {
                        $code = "COM-ABJ-00".$nombre;
                    } elseif ($commerciauxId->getId()  < 99) {
                        $code = "COM-ABJ-0".$nombre;
                    } else {
                        $code = "COM-ABJ-".$nombre;
                    }
                } else {
                    $code = "COM-ABJ-001";
                }
                $commercial->setCode($code);
            }

            if (!$commercial->getId()) {

                 $objectManager->persist($commercial);
                 $objectManager->flush();

                $this->addFlash('success', "Commercial ".$commercial->getCode()." ajouté(é)!");
            } elseif ($commercial->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Commercial ".$commercial->getCode()." modifié(e)!");
            }

            return $this->redirectToRoute('modifier-commerciaux', ['slug' => $commercial->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/commerciaux/enregistrer.html.twig', [
            'commercial' => $commercial,
            'form' => $form->createView(),
            'edit' => $commercial->getId() !== null
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lister-commerciaux", name="liste-commerciaux")
     */
    public function liste (CommercialRepository $commercialRepository)
    {
        $commercials = $commercialRepository->findAll();
        return $this->render('erp/direction_commerciale/commerciaux/lister.html.twig', [
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


    /**
     * @param Request $request
     * @param CommercialRepository $commercialRepository
     * @param $id
     * @return Response
     * @Route("/{id}/supprimer", methods={"POST"}, name="supprimer_commerciaux")
     */
    public function supprimer(Request $request, CommercialRepository $commercialRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('liste-commerciaux');
        }

        $commercial = $commercialRepository->find($id);

        if ($commercial->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($commercial);
            $em->flush();
            $this->addFlash('danger', "Commercial ".$commercial->getCode()." supprimé(e)!");
        }

        return $this->redirectToRoute('liste-commerciaux');

    }
}