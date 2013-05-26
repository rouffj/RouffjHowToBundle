<?php

namespace Rouffj\Bundle\HowToBundle\Controller\Security\Voter;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/voter/request")
 */
class RequestController extends Controller
{
    /**
     * @Route("", name="security_voter_beta_homepage")
     * @Template()
     */
    public function homepageAction()
    {
        return array();
    }

    /**
     * @Route("/app", name="security_voter_beta_app")
     * @Template()
     */
    public function appAction()
    {
        return array();
    }
}
