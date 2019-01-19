<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\Ward;
use App\Form\Commercial\WardType;
use App\Repository\Commercial\WardRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WardController
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale/parametrage")
 */
class WardController extends AbstractController
{

    /**
     * @param Request $request
     * @param Ward|null $ward
     * @param WardRepository $wardRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-quartier", name="ward_create")
     * @Route("/quartier/{slug}/modifier", name="ward_update")
     */
    public function createUpdate(Request $request, ?Ward $ward, WardRepository $wardRepository, ObjectManager $objectManager)
    {
        if (!$ward) {
            $ward = new Ward();
        }


        $form = $this->createForm(WardType::class, $ward);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$ward->getCode()) {
                $wardId = $wardRepository->findOneBy(array(), array('id' => 'desc'));

                if ($wardId) {
                    /** @var Ward $lastOfWardsInTownship */
                    $lastOfWardsInTownship = $ward->getTownship()->getWards()->last();

                    if ($lastOfWardsInTownship) {
                        $code = $lastOfWardsInTownship->getCode() + 1;

                        if ($code < 10) {
                            $code = "0" . $code;
                        }
                    } else {
                        $code = "01";
                    }

                }

                $ward->setCode($code);
            }

            if (!$ward->getId()) {

                $objectManager->persist($ward);
                $objectManager->flush();

                $this->addFlash('success', "Quartier ".$ward->getCode()." crée!");
            } elseif ($ward->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Quartier ".$ward->getCode()." modifié!");
            }

            return $this->redirectToRoute('ward_update', ['slug' => $ward->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/ward/create_update.html.twig', [
            'ward' => $ward,
            'form' => $form->createView(),
            'edit' => $ward->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-quartier", name="ward_read")
     */
    public function read(WardRepository $wardRepository)
    {
        $wards = $wardRepository->findAll();
        return $this->render('erp/direction_commerciale/ward/read.html.twig', [
            'wards' => $wards,
        ]);
    }

    /**
     * @param Request $request
     * @param WardRepository $wardRepository
     * @param $id
     * @return Response
     * @Route("quartier/{id}/supprimer", methods={"POST"}, name="ward_delete")
     */
    public function delete(Request $request, WardRepository $wardRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('ward_read');
        }

        $ward = $wardRepository->find($id);

        if ($ward->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($ward);
            $em->flush();
            $this->addFlash('danger', "Quartier ".$ward->getCode()." supprimé!");
        }

        return $this->redirectToRoute('ward_read');

    }

    /**
     * @param WardRepository $wardRepository
     * @return Response
     * @Route("/lister-zone", name="area_read")
     */
    public function areaRead(WardRepository $wardRepository)
    {
        $wards = $wardRepository->findAll();
        return $this->render('erp/direction_commerciale/ward/area_read.html.twig', [
            'wards' => $wards,
        ]);
    }
}
