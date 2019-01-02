<?php
/**
 * Created by PhpStorm.
 * User: kimt
 * Date: 28/12/18
 * Time: 17:10
 */

namespace App\Controller;


use App\Entity\Commercial\Ward;
use App\Repository\Commercial\CommercialRepository;
use App\Repository\Commercial\WardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ErpController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("dashboard", name="dashborad")
     */
    public function erp (CommercialRepository $commercialRepository)
    {
        $commerciaux = $commercialRepository->findAll();
       return $this->render('erp/dashborad.html.twig', [
           'commerciaux' => $commerciaux,
       ]);
    }

    /**
     * @Route("/direction-commerciale/lister-zone", name="area_read")
     */
    public function read(WardRepository $wardRepository)
    {
        $wards = $wardRepository->findAll();
        return $this->render('erp/direction_commerciale/area/read.html.twig', [
            'wards' => $wards,
        ]);
    }

}