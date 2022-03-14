<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Users;
use App\Form\RegisterUserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UsersFormType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class HelloPasauli extends AbstractController
{
    /**
     * @Route("/uzduotis", name="default", name="uzduotis")
     */
    public function UzduotisKurti(Request $request, ManagerRegistry $doctrine) : Response
    {
$user = new Users();
$form = $this->createForm(UsersFormType::class, $user);
$form->handleRequest($request);
$entityManager = $doctrine->getManager();

if ($form->isSubmitted() && $form->isValid())
{

$entityManager->persist($user);
$entityManager->flush();

    $this->addFlash('notice','Sukurtas useris, kurio ID yra: ' . $user->getId());

    return $this->redirectToRoute('uzduotis');
}
        return $this->render('default/uzduotis.html.twig',[
            'controller_name' => 'HelloPasauli',
            'form' => $form->createView(),
            'users' => $user
        ]);





    }

    /**
     * @Route ("/uzduotis/{id}", name ="GrazinimasID", methods={"GET"})
     * @param ManagerRegistry $doctrine
     * @param int $id
     * @return Response
     */
    public function GrazinkId(ManagerRegistry $doctrine, int $id){


            $grazinimas = $doctrine->getRepository(Users::class)->find($id);
            return new Response('Useris, kurio vardas: '. $grazinimas->getName($id). ', Pavarde: '. $grazinimas->getSurname($id));



    }

    /**
     * @Route ("/users", name="UserSukurimas")
     * @param ManagerRegistry $doctrine
     * @return Response
     */
public function Sukurimas(ManagerRegistry $doctrine){

$user = new Users();
    $entityManager = $doctrine->getManager();
    $user->setName('Algiukas');
    $user->setSurname('Rodriguez');
    $entityManager->persist($user);
    $entityManager->flush();

    $this->addFlash('notice','Sukurtas useris, kurio ID yra: ' . $user->getId());
    return $this->render('default/sukurimas.html.twig',[
        'controller_name' => 'HelloPasauli',
        'users' => $user
    ]);

}

    /**
     * @Route ("/registracija", name="registracija")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ManagerRegistry $doctrine
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
public function Registracija(Request $request, UserPasswordEncoderInterface $passwordEncoder,ManagerRegistry $doctrine)
{
//    $entityManager = $doctrine->getManager();
//$users = $entityManager->getRepository(User::class)->findAll();
//dump($users);

    $user = new User();
$form = $this->createForm(RegisterUserType::class, $user);
$form->handleRequest($request);

if($form->isSubmitted() && $form->isValid()){

        $user->setPassword($passwordEncoder->encodePassword($user, $form->get('password')->getdata()));
        $user->setEmail($form->get('email')->getdata());

    $entityManager = $doctrine->getManager();
    $entityManager->persist($user);
    $entityManager->flush();

    $this->addFlash('notice','Sukurtas useris, kurio ID yra: ' . $user->getId());


    return $this->redirectToRoute('registracija');


}
    return $this->render('default/uzduotis.html.twig',[
        'controller_name' => 'HelloPasauli',
        'form' => $form->createView(),
    ]);








}

}

