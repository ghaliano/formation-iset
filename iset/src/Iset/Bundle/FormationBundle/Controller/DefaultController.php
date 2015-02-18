<?php

namespace Iset\Bundle\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/accueil", name="page_accueil")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/calcul/{angle}/{method}", defaults={"method" = "sin"})
     * @Template()
     */
    public function calculAction($angle, $method)
    {
    	$trigo = $this->container->get('trigonometrie');

        return array(
        	
        	'angle' => $angle,
        	'method' => $method,
        	'result_cos' => $trigo->cos($angle),
        	'result_sin' => $trigo->sin($angle),
        	'result_tan' => $trigo->tan($angle)
    	);
    }

    /**
     * @Route("/offre/nouveau", name="offre_nouveau")
     * @Template()
     */
    public function offreNouveauAction()
    {
        return array();
    }
}
