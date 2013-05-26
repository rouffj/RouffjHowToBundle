<?php

namespace Rouffj\Bundle\HowToBundle\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/voter")
 */
class VoterController extends Controller
{
    /**
     * @Route("/1", name="security_voter_beta_homepage")
     * @Template()
     */
    public function firstAction()
    {
        return array();
    }

    /**
     * @Route("/1/app", name="security_voter_beta_app")
     * @Template()
     */
    public function secAction()
    {
        return array();
    }
}
