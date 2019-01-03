<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\ProspectingSheet;
use App\Form\Commercial\ProspectingSheetType;
use App\Repository\Commercial\CommercialRepository;
use App\Repository\Commercial\ProspectingSheetRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PropectingSheetController
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale")
 */
class PropectingSheetController extends AbstractController
{


    /**
     * @param ProspectingSheet|null $prospectingSheet
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param ProspectingSheetRepository $prospectingSheetRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-fiche-prospection", name="prospecting_sheet_create")
     * @Route("/fiche-prospection/{slug}/modifier", name="prospecting_sheet_update")
     */
    public function createUpdate(?ProspectingSheet $prospectingSheet, Request $request, ObjectManager $objectManager, ProspectingSheetRepository $prospectingSheetRepository, CommercialRepository $commercialRepository)
    {
        if (!$prospectingSheet) {
            $prospectingSheet = new ProspectingSheet();
        }

        $form = $this->createForm(ProspectingSheetType::class, $prospectingSheet);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$prospectingSheet->getCode()) {

                $prospectingSheetId = $prospectingSheetRepository->findOneBy(array(), array('id' => 'desc'));
                $date = new DateTime();
                $date->format('Y-m');

                if ($prospectingSheetId) {
                    $nombre = $prospectingSheetId->getId() + 1;
                    if ($prospectingSheetId->getId() < 9) {
                        $code = $date->format('Y-m')."-N°0".$nombre;
                    } else {
                        $code = $date->format('Y-m')."-N°0".$nombre;
                    }
                } else {
                    $code = $code = $date->format('Y-m')."-N°01";
                }

                $prospectingSheet->setCode($code);
            }

            if (!$prospectingSheet->getId()) {

                $objectManager->persist($prospectingSheet);
                $objectManager->flush();

                $this->addFlash('success', "Fiche de Prospection " . $prospectingSheet->getCode() . " ajoutée!");
            } elseif ($prospectingSheet->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Fiche de Prospection " . $prospectingSheet->getCode() . " modifiée!");
            }

            return $this->redirectToRoute('prospecting_sheet_update', ['slug' => $prospectingSheet->getSlug()]);
        }

        $commercials = $commercialRepository->findAll();
        return $this->render('erp/direction_commerciale/prospecting_sheet/create_update.html.twig', [
            'prospectingSheet' => $prospectingSheet,
            'form' => $form->createView(),
            'edit' => $prospectingSheet->getId() !== null,
            'commercials' => $commercials
        ]);
    }

    /**
     * @Route("/lister-fiches-prospections", name="prospecting_sheet_read")
     */
    public function read(ProspectingSheetRepository $prospectingSheetRepository)
    {
        $prospectingSheets = $prospectingSheetRepository->findAll();
        return $this->render('erp/direction_commerciale/prospecting_sheet/read.html.twig', [
            'prospectingSheets' => $prospectingSheets
        ]);
    }

//    /**
//     * @Route("/fiche-prospection/{slug}", name="prospecting_sheet_readone")
//     */
//    public function prospectingSheetRead(ProspectingSheet $prospectingSheetSlug, ProspectingSheetRepository $prospectingSheetRepository)
//    {
//        $prospectingSheet = $prospectingSheetRepository->find($prospectingSheetSlug->getId());
//        return $this->render('erp/direction_commerciale/prospecting_sheet/prospecting_sheet_read.html.twig', [
//            'prospectingSheet' => $prospectingSheet
//        ]);
//    }

    /**
     * @Route("/direction-commercial/liste-fiche-prospection", name="prospecting_sheet_pdf")
     */
    public function imprimer(Request $request, ProspectingSheetRepository $prospectingSheetRepository, Pdf $pdf)
    {
        $prospectingSheets = $prospectingSheetRepository->findAll();

        $html = $this->render('erp/direction_commerciale/prospecting_sheet/prospecting_sheet_pdf.html.twig', [
            'prospectingSheets' => $prospectingSheets
        ]);

        $filename = 'Liste-fiche-de-prospection';

        return new Response(
            $pdf->getOutputFromHtml($html),200,array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'

            )
        );
    }
}
