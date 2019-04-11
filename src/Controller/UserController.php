<?php

namespace App\Controller;

use App\Entity\User;
use App\Traits\LoggedUserTrait;
use App\Traits\Services\LoggerTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/writer") */
class UserController extends AbstractController
{
    use LoggerTrait;
    use LoggedUserTrait;

    /**
     * @Route("/profile", name="user_profile")
     */
    public function profileAction(Request $request): Response
    {
        return new Response(
            $this->renderView('User/profile.html.twig', ['user' => $this->getLoggedUser()])
        );
    }

    /**
     * @Route("/profile/{id}", name="user_profile_with_id")
     * @ParamConverter("object", class="App\Entity\User", options={"mapping": {"id" = "id"}})
     */
    public function profileWithIdAction(Request $request, User $user): Response
    {
        return new Response(
            $this->renderView('User/profile.html.twig', ['user' => $user])
        );
    }
}
