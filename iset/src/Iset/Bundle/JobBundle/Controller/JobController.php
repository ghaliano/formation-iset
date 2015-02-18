<?php

namespace Iset\Bundle\JobBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class JobController extends Controller
{
    /**
     * @Route("/offre", name="offre_index")
     * @Template()
     */
    public function offreAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/offre/{id}", name="offre_detail")
     * @Template()
     */
    public function detailAction($name)
    {
        return array('name' => $name);
    }

    /**
     * @Route("/offre/nouveau", name="offre_nouveau")
     * @Template()
     */
    public function nouveauAction($name)
    {
        return array('name' => $name);
    }
}
