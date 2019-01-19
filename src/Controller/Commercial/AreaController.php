<?php

namespace App\Controller\Commercial;

use App\Repository\Commercial\AreaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AreaController
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale")
 */
class AreaController extends AbstractController
{
    /**
     * @param AreaRepository $areaRepository
     * @return Response
     * @Route("/lister-zone", name="area_read")
     */
    public function read(AreaRepository $areaRepository): Response
    {
        $areas = $areaRepository->findAll();
        return $this->render('erp/direction_commerciale/area/read.html.twig', [
            'areas' => $areas,
        ]);
    }
}
