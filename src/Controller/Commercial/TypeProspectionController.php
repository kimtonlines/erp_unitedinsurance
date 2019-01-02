<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\TypeProspection;
use App\Form\Commercial\TypeProspectionType;
use App\Repository\Commercial\TypeProspectionRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypeProspectionController
 * @package App\Controller\Commercial
 * @Route("direction-commerciale/parametrage")
 */
class TypeProspectionController extends AbstractController
{
    /**
     * @Route("/creer-type-prospection", name="prospecting_type_create")
     * @Route("/type-prospection/{slug}/modifier", name="prospecting_type_update")
     * @param TypeProspection $typeProspection
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param TypeProspectionRepository $typeProspectionRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createUpdate(Request $request, ObjectManager $objectManager, TypeProspectionRepository $typeProspectionRepository, ?TypeProspection $tpProspection)
    {
        if (!$tpProspection) {
            $tpProspection = new TypeProspection();
        }


        $form = $this->createForm(TypeProspectionType::class, $tpProspection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$tpProspection->getCode()) {
                $typeProspectionId = $typeProspectionRepository->findOneBy(array(), array('id' => 'desc'));

                if ($typeProspectionId) {
                    $nombre = $typeProspectionId->getId() + 1;
                    if ($typeProspectionId->getId()  < 9 ) {
                        $code = "Type-00".$nombre;
                    } elseif ($typeProspectionId->getId()  < 99) {
                        $code = "Type-00".$nombre;
                    } else {
                        $code = "Type-".$nombre;
                    }
                } else {
                    $code = "Type-001";
                }
                $tpProspection->setCode($code);
            }

            if (!$tpProspection->getId()) {

                $objectManager->persist($tpProspection);
                $objectManager->flush();

                $this->addFlash('success', "Type de Prospection ".$tpProspection->getCode()." crée!");
            } elseif ($tpProspection->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Type de Prospection ".$tpProspection->getCode()." modifié!");
            }

            return $this->redirectToRoute('prospecting_type_update', ['slug' => $tpProspection->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/type_prospection/create_update.html.twig', [
            'typeProspection' => $tpProspection,
            'form' => $form->createView(),
            'edit' => $tpProspection->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-type-prospection", name="prospecting_type_read")
     */
    public function read(TypeProspectionRepository $typeProspectionRepository)
    {
        $typeProspections = $typeProspectionRepository->findAll();
        return $this->render('erp/direction_commerciale/type_prospection/read.html.twig', [
            'typeProspections' => $typeProspections,
        ]);
    }

    /**
     * @param Request $request
     * @param TypeProspectionRepository $typeProspectionRepository
     * @param $id
     * @return Response
     * @Route("type-prospection/{id}/supprimer", methods={"POST"}, name="prospecting_type_delete")
     */
    public function delete(Request $request, TypeProspectionRepository $typeProspectionRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('prospecting_type_read');
        }

        $typeProspection = $typeProspectionRepository->find($id);

        if ($typeProspection->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeProspection);
            $em->flush();
            $this->addFlash('danger', "Type Prospection ".$typeProspection->getCode()." supprimé!");
        }

        return $this->redirectToRoute('prospecting_type_read');

    }
}
