<?php

namespace Rouffj\Bundle\HowToBundle\Tests\Symfony\Security\Fixtures\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Joseph Rouff <rouffj@gmail.com>
 */
class BetaVoter implements VoterInterface
{
    private $authorizedUsernames;
    private $httpUtils;

    public function __construct(HttpUtils $httpUtils, array $authorizedUsernames)
    {
        $this->httpUtils = $httpUtils;
        $this->authorizedUsernames = $authorizedUsernames;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        if (!$object instanceof Request) { // this voter can be fired with is_granted so we should check of object is really a request
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if ($this->httpUtils->checkRequestPath($object, 'security_voter_beta_homepage')) {
            return VoterInterface::ACCESS_ABSTAIN;
        }

        if (is_object($token->getUser())) {
            if (in_array($token->getUser()->getUsername(), $this->authorizedUsernames)) {
                return VoterInterface::ACCESS_GRANTED;
            }
        }

        return VoterInterface::ACCESS_DENIED;
    }
}
