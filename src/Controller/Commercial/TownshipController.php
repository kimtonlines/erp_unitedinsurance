<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\Township;
use App\Form\Commercial\TownshipType;
use App\Repository\Commercial\TownshipRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TownshipController
 * @package App\Controller\Commercial
 * @Route("direction-commerciale/parametrage")
 */
class TownshipController extends AbstractController
{
    /**
     * @param Request $request
     * @param Township|null $township
     * @param TownshipRepository $townshipRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-communue", name="township_create")
     * @Route("/communue/{slug}/modifier", name="township_update")
     */
    public function createUpdate(Request $request, ?Township $township, TownshipRepository $townshipRepository, ObjectManager $objectManager)
    {
        if (!$township) {
            $township = new Township();
        }


        $form = $this->createForm(TownshipType::class, $township);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$township->getCode()) {
                $townshipId = $townshipRepository->findOneBy(array(), array('id' => 'desc'));

                if ($townshipId) {
                    $nombre = $townshipId->getId() + 1;
                    if ($townshipId->getId()  < 9 ) {
                        $code = "0".$nombre;
                    } elseif ($townshipId->getId()  < 99) {
                        $code = $nombre;
                    } else {
                        $code = $nombre;
                    }
                } else {
                    $code = "01";
                }
                $township->setCode($code);
            }

            if (!$township->getId()) {

                $objectManager->persist($township);
                $objectManager->flush();

                $this->addFlash('success', "Commune ".$township->getCode()." créee!");
            } elseif ($township->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Communue ".$township->getCode()." modifiée!");
            }

            return $this->redirectToRoute('township_update', ['slug' => $township->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/township/create_update.html.twig', [
            'township' => $township,
            'form' => $form->createView(),
            'edit' => $township->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-communue", name="township_read")
     */
    public function read(TownshipRepository $townshipRepository)
    {
        $townships = $townshipRepository->findAll();
        return $this->render('erp/direction_commerciale/township/read.html.twig', [
            'townships' => $townships,
        ]);
    }

    /**
     * @param Request $request
     * @param TownshipRepository $townshipRepository
     * @param $id
     * @return Response
     * @Route("commune/{id}/supprimer", methods={"POST"}, name="township_delete")
     */
    public function delete(Request $request, TownshipRepository $townshipRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('township_read');
        }

        $township = $townshipRepository->find($id);

        if ($township->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($township);
            $em->flush();
            $this->addFlash('danger', "Commune ".$township->getCode()." supprimé!");
        }

        return $this->redirectToRoute('township_read');

    }
}
