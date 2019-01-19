<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\Status;
use App\Form\Commercial\StatusType;
use App\Repository\Commercial\StatusRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatusController
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale/parametrage")
 */
class StatusController extends AbstractController
{
    /**
     * @param Request $request
     * @param Status|null $status
     * @param StatusRepository $statusRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-statut", name="status_create")
     * @Route("/statut/{slug}/modifier", name="status_update")
     */
    public function createUpdate(Request $request, ?Status $status, StatusRepository $statusRepository, ObjectManager $objectManager)
    {
        if (!$status) {
            $status = new Status();
        }


        $form = $this->createForm(StatusType::class, $status);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$status->getCode()) {
                $statusId = $statusRepository->findOneBy(array(), array('id' => 'desc'));

                if ($statusId) {
                    $nombre = $statusId->getId() + 1;
                    if ($statusId->getId()  < 9 ) {
                        $code = "0".$nombre;
                    } elseif ($statusId->getId()  < 99) {
                        $code = $nombre;
                    } else {
                        $code = $nombre;
                    }
                } else {
                    $code = "01";
                }
                $status->setCode($code);
            }

            if (!$status->getId()) {

                $objectManager->persist($status);
                $objectManager->flush();

                $this->addFlash('success', "Statut ".$status->getCode()." créee!");
            } elseif ($status->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Communue ".$status->getCode()." modifiée!");
            }

            return $this->redirectToRoute('status_update', ['slug' => $status->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/status/create_update.html.twig', [
            'status' => $status,
            'form' => $form->createView(),
            'edit' => $status->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-statut", name="status_read")
     * @param StatusRepository $statusRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read(StatusRepository $statusRepository)
    {
        $status = $statusRepository->findAll();
        return $this->render('erp/direction_commerciale/status/read.html.twig', [
            'status' => $status,
        ]);
    }

    /**
     * @param Request $request
     * @param StatusRepository $statusRepository
     * @param $id
     * @return Response
     * @Route("commune/{id}/supprimer", methods={"POST"}, name="status_delete")
     */
    public function delete(Request $request, StatusRepository $statusRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('status_read');
        }

        $status = $statusRepository->find($id);

        if ($status->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($status);
            $em->flush();
            $this->addFlash('danger', "Statut ".$status->getCode()." supprimée!");
        }

        return $this->redirectToRoute('status_read');

    }
}
