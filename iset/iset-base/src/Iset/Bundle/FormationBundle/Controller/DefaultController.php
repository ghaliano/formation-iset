<?php

namespace Iset\Bundle\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints as BaseConstraints;

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
        $form = $this->createFormBuilder()
            ->add('titre', 'text', array(
                'constraints' => array(
                    new BaseConstraints\NotBlank(array("message" => "Cette valeur ne doit pas être vide.")),
                    new BaseConstraints\Length(array('min' => 5))
                ),
                'required' => false,
                'label' => 'Titre de l\'offre'  
            ))
            ->add('description', 'textarea')
            ->add('category', 'choice', array(
                'empty_value' => 'Choisissez une option',
                'choices' => array(
                    'Informatique', 
                    'Mecanique',
                    'Economie'
                )
            ))
            ->add('submit', 'submit')
            ->getForm()
        ;
        
        if ($this->getRequest()->getMethod() == "POST") {
            //Binding des données
            $form->submit($this->getRequest());
            if ($form->isValid()) {

            }
        }

        return array(
            'formulaire' => $form->createView()
        );
    }
}
