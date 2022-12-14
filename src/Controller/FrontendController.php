<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontendController extends AbstractController
{
    /**
     * @Route("/login", name="login", methods="GET")
     */
    public function login(Request $request): Response
    {
        $request->getSession()->remove('user');
        return $this->render(
            'login.html.twig',
            array(
                'cname' => $_ENV['CNAME'],
            )
        );
    }

    /**
     * @Route("/", name="home", methods="GET")
     */
    public function home(Request $request): Response
    {
        $user = $request->getSession()->get('user');
        if (empty($user)) {

            //Redirect user to login page
            return new Response(sprintf("<meta http-equiv='refresh' content='0; url=%s/login' />", $_ENV['NGROK_URL']));
        }

        $split = explode(":", $user);
        $username = $split[0];
        $userFullName = $split[1];
        return $this->render(
            'home.html.twig',
            array(
                'username' => $username,
                'userFullName' => $userFullName
            )
        );

    }

    /**
     * @Route("/ping", name="pong", methods="GET")
     */
    public function pong(Request $request): Response
    {
        return new Response("pong");
    }
}