<?php

namespace App\Controller\Commercial;

use App\Entity\Commercial\TypeContract;
use App\Form\Commercial\TypeContractType;
use App\Repository\Commercial\TypeContractRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TypeContractController
 * @package App\Controller\Commercial
 * @Route("admin/direction-commerciale/parametrage")
 */
class TypeContractController extends AbstractController
{

    /**
     * @param Request $request
     * @param TypeContract|null $typeContract
     * @param TypeContractRepository $typeContractRepository
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-type-contrat", name="type_contact_create")
     * @Route("/type-contrat/{slug}/modifier", name="type_contract_update")
     */
    public function createUpdate(Request $request, ?TypeContract $typeContract, TypeContractRepository $typeContractRepository, ObjectManager $objectManager)
    {
        if (!$typeContract) {
            $typeContract = new TypeContract();
        }


        $form = $this->createForm(TypeContractType::class, $typeContract);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            if (!$typeContract->getCode()) {
                $typeContractId = $typeContractRepository->findOneBy(array(), array('id' => 'desc'));


                if ($typeContractId) {

                    $code = $typeContractId->getCode() + 1;

                    if ($code < 10) {
                        $code = "0" . $code;
                    }

                } else {

                    $code = "01";
                }

                $typeContract->setCode($code);
            }

            if (!$typeContract->getId()) {

                $objectManager->persist($typeContract);
                $objectManager->flush();

                $this->addFlash('success', "Type de Contrat ".$typeContract->getCode()." crée!");
            } elseif ($typeContract->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Type de Contrat ".$typeContract->getCode()." modifié!");
            }

            return $this->redirectToRoute('type_contract_update', ['slug' => $typeContract->getSlug()]);
        }

        return $this->render('erp/direction_commerciale/type_contract/create_update.html.twig', [
            'typeContract' => $typeContract,
            'form' => $form->createView(),
            'edit' => $typeContract->getId() !== null
        ]);
    }

    /**
     * @Route("/lister-type-contrat", name="type_contract_read")
     */
    public function read(TypeContractRepository $typeContractRepository)
    {
        $typeContracts = $typeContractRepository->findAll();
        return $this->render('erp/direction_commerciale/type_contract/read.html.twig', [
            'typeContracts' => $typeContracts,
        ]);
    }

    /**
     * @param Request $request
     * @param TypeContractRepository $typeContractRepository
     * @param $id
     * @return Response
     * @Route("type-contrat/{id}/supprimer", methods={"POST"}, name="type_contract_delete")
     */
    public function delete(Request $request, TypeContractRepository $typeContractRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('type_contract_read');
        }

        $typeContract = $typeContractRepository->find($id);

        if ($typeContract->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeContract);
            $em->flush();
            $this->addFlash('danger', "Type Contrat ".$typeContract->getCode()." supprimé!");
        }

        return $this->redirectToRoute('type_contract_read');

    }
}
