<?php

namespace App\Controller\Commercial;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commercial\City;
use App\Repository\Commercial\CityRepository;
use App\Form\Commercial\CityType;

/**
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale/parametrage")
 */
class CityController extends AbstractController
{
   /**
     * @param Request $request
     * @param City|null $city
     * @param CityRepository $cityRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-ville", name="city_create")
     * @Route("/ville/{slug}/modifier", name="city_update")
     */
    public function createUpdate(Request $request, ?City $city, CityRepository $cityRepository, ObjectManager $objectManager)
    {
        if (!$city) {
            $city = new City();
        }


        $form = $this->createForm(CityType::class, $city);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$city->getCode()) {
                $cityId = $cityRepository->findOneBy(array(), array('id' => 'desc'));

                if ($cityId) {
                    $nombre = $cityId->getId() + 1;
                    if ($cityId->getId()  < 9 ) {
                        $code = "0".$nombre;
                    } elseif ($cityId->getId()  < 99) {
                        $code = $nombre;
                    } else {
                        $code = $nombre;
                    }
                } else {
                    $code = "01";
                }
                $city->setCode($code);
            }

            if (!$city->getId()) {

                $objectManager->persist($city);
                $objectManager->flush();

                $this->addFlash('success', "Ville ".$city->getCode()." créee!");
            } elseif ($city->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Communue ".$city->getCode()." modifiée!");
            }

            return $this->redirectToRoute('city_update', ['slug' => $city->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/city/create_update.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
            'edit' => $city->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-ville", name="city_read")
     */
    public function read(CityRepository $cityRepository)
    {
        $cities = $cityRepository->findAll();
        return $this->render('erp/direction_commerciale/city/read.html.twig', [
            'cities' => $cities,
        ]);
    }

    /**
     * @param Request $request
     * @param CityRepository $cityRepository
     * @param $id
     * @return Response
     * @Route("ville/{id}/supprimer", methods={"POST"}, name="city_delete")
     */
    public function delete(Request $request, CityRepository $cityRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('city_read');
        }

        $city = $cityRepository->find($id);

        if ($city->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($city);
            $em->flush();
            $this->addFlash('danger', "Ville ".$city->getCode()." supprimée!");
        }

        return $this->redirectToRoute('city_read');

    }
}
