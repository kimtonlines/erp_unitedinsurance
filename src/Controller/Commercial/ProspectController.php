<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\Prospect;
use App\Form\Commercial\ProspectType;
use App\Repository\Commercial\ProspectRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProspectController
 * @package App\Controller\Prospect
 * @Route("admin/direction-commerciale")
 */
class ProspectController extends AbstractController
{
    /**
     * @param Prospect|null $prospect
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param ProspectRepository $prospectRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *  @Route("/creer-prospect", name="prospect_create")
     * @Route("/prospect/{slug}/modifier", name="prospect_update")
     */
    public function createUpdate(?Prospect $prospect, Request $request, ObjectManager $objectManager, ProspectRepository $prospectRepository)
    {
        if (!$prospect) {
            $prospect = new Prospect();
        }

        $form = $this->createForm(ProspectType::class, $prospect);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$prospect->getCode()) {
                $prospectId = $prospectRepository->findOneBy(array(), array('id' => 'desc'));

                if ($prospectId) {
                    $nombre = $prospectId->getId() + 1;
                    if ($prospectId->getId()  < 9 ) {
                        $code = "PROS-ABJ-00".$nombre;
                    } elseif ($prospectId->getId()  < 99) {
                        $code = "PROS-ABJ-0".$nombre;
                    } else {
                        $code = "PROS-ABJ-".$nombre;
                    }
                } else {
                    $code = "PROS-ABJ-001";
                }
                $prospect->setCode($code);
            }

            if (!$prospect->getId()) {

                $prospect->setUser($this->getUser());
                $objectManager->persist($prospect);
                $objectManager->flush();

                $this->addFlash('success', "Prospect ".$prospect->getCode()." crée!");
            } elseif ($prospect->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Prospect ".$prospect->getCode()." modifié!");
            }

            return $this->redirectToRoute('prospect_update', ['slug' => $prospect->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/prospect/create_update.html.twig', [
            'prospect' => $prospect,
            'form' => $form->createView(),
            'edit' => $prospect->getId() !== null
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lister-prospect", name="prospect_read")
     */
    public function read(ProspectRepository $prospectRepository)
    {
        $prospects = $prospectRepository->findAll();
        return $this->render('erp/direction_commerciale/prospect/read.html.twig', [
            'prospects' => $prospects
        ]);
    }

    /**
     * @param Request $request
     * @param ProspectRepository $prospectRepository
     * @param $id
     * @return Response
     * @Route("prospect/{id}/supprimer", methods={"POST"}, name="prospect_delete")
     */
    public function delete(Request $request, ProspectRepository $prospectRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('prospect_read');
        }

        $prospect = $prospectRepository->find($id);

        if ($prospect->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($prospect);
            $em->flush();
            $this->addFlash('danger', "Commercial ".$prospect->getCode()." supprimé!");
        }

        return $this->redirectToRoute('prospect_read');

    }
}
