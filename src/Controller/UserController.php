<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 * @Route("/admin/configuration")
 */
class UserController extends AbstractController
{
    /**
     * @param User|null $user
     * @param Request $request
     * @param ObjectManager $objectManager
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/creer-utilisateur", name="user_create", methods={"GET", "POST"})
     * @Route("/utilisateur/{slug}/modifier", name="user_update", methods={"GET", "POST"})
     */
    public function createUpdate(?User $user, Request $request, ObjectManager $objectManager, UserRepository $userRepository, UserPasswordEncoderInterface $encoder)
    {
        if (!$user) {
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            if (!$user->getCode()) {
                $userId = $userRepository->findOneBy(array(), array('id' => 'desc'));

                if ($userId) {
                    $nombre = $userId->getId() + 1;
                    if ($userId->getId()  < 9 ) {
                        $code = "U-ABJ-00".$nombre;
                    } elseif ($userId->getId()  < 99) {
                        $code = "U-ABJ-0".$nombre;
                    } else {
                        $code = "U-ABJ-".$nombre;
                    }
                } else {
                    $code = "U-ABJ-001";
                }
                $user->setCode($code);
            }

            if (!$user->getId()) {

                $objectManager->persist($user);
                $objectManager->flush();

                $this->addFlash('success', "Utilisateur ".$user->getCode()." crée!");
            } elseif ($user->getId()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('warning', "Utilisateur ".$user->getCode()." modifié!");
            }

            return $this->redirectToRoute('user_update', ['slug' => $user->getSlug()]);
        }

        return $this->render('erp/user/create_update.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'edit' => $user->getId() !== null
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/lister-utilisateur", name="user_read")
     */
    public function read(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        return $this->render('erp/user/read.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param $id
     * @return Response
     * @Route("user/{id}/supprimer", methods={"POST"}, name="user_delete")
     */
    public function delete(Request $request, UserRepository $userRepository, $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('user_read');
        }

        $user = $userRepository->find($id);

        if ($user->getId())
        {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
            $this->addFlash('danger', "Utilisateur ".$user->getCode()." supprimé!");
        }

        return $this->redirectToRoute('user_read');

    }

    /**
     * @param User|null $user
     * @param Request $request
     * @param ObjectManager $objectManager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/utilisateur/{slug}/modifier", name="user_update")
     */
    public function profile(User $user, Request $request, ObjectManager $objectManager)
    {

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $objectManager->persist($user);
            $objectManager->flush();
            $this->addFlash('warning', "Utilisateur ".$user->getCode()." modifié!");

            return $this->redirectToRoute('user_update', ['slug' => $user->getSlug()]);
        }

        return $this->render('erp/user/profile.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
