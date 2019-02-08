<?php

namespace App\Controller\Commercial;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Commercial\AgencyRepository;
use App\Form\Commercial\AgencyType;
use App\Entity\Commercial\Agency;

/**
 * Undocumented class
 * @Route("admin/direction-commerciale/parametrage")
 */
class AgencyController extends AbstractController
{
  /**
     * @param Request $request
     * @param Agency|null $agency
     * @param AgencyRepository $agencyRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-agence", name="agency_create")
     * @Route("/agence/{slug}/modifier", name="agency_update")
     */
    public function createUpdate(Request $request, ?Agency $agency, AgencyRepository $agencyRepository, ObjectManager $objectManager)
    {
        if (!$agency) {
            $agency = new Agency();
        }


        $form = $this->createForm(AgencyType::class, $agency);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$agency->getCode()) {
                $agencyId = $agencyRepository->findOneBy(array(), array('id' => 'desc'));

                if ($agencyId) {
                    $nombre = $agencyId->getId() + 1;
                    if ($agencyId->getId()  < 9 ) {
                        $code = "0".$nombre;
                    } elseif ($agencyId->getId()  < 99) {
                        $code = $nombre;
                    } else {
                        $code = $nombre;
                    }
                } else {
                    $code = "01";
                }
                $agency->setCode($code);
            }

            if (!$agency->getId()) {

                $objectManager->persist($agency);
                $objectManager->flush();

                $this->addFlash('success', "Agence ".$agency->getCode()." créee!");
            } elseif ($agency->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Agence ".$agency->getCode()." modifiée!");
            }

            return $this->redirectToRoute('agency_update', ['slug' => $agency->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/agency/create_update.html.twig', [
            'agency' => $agency,
            'form' => $form->createView(),
            'edit' => $agency->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-agence", name="agency_read")
     */
    public function read(AgencyRepository $agencyRepository)
    {
        $agencies = $agencyRepository->findAll();
        return $this->render('erp/direction_commerciale/agency/read.html.twig', [
            'agencies' => $agencies,
        ]);
    }

    /**
     * @param Request $request
     * @param AgencyRepository $agencyRepository
     * @param $id
     * @return Response
     * @Route("commune/{id}/supprimer", methods={"POST"}, name="agency_delete")
     */
    public function delete(Request $request, AgencyRepository $agencyRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('agency_read');
        }

        $agency = $agencyRepository->find($id);

        if ($agency->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($agency);
            $em->flush();
            $this->addFlash('danger', "Agence ".$agency->getCode()." supprimée!");
        }

        return $this->redirectToRoute('agency_read');

    }
}
