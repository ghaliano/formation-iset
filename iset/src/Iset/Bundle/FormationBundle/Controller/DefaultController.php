<?php

namespace Iset\Bundle\FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Validator\Constraints as BaseConstraints;
use Iset\Bundle\FormationBundle\Entity\Offre;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class DefaultController extends Controller
{
    /**
     * @Route("/accueil", name="page_accueil")
     * @Template()
     */
    public function indexAction()
    {
        $this->getRequest()->getSession()->set('_locale', 'fr');
        
        return array();
    }

    /**
     * @Route("/changer-langue/{lng}", name="changer_langue")
     * @Template()
     */
    public function changerLangueAction($lng)
    {
        //$this->getRequest()->setLocale($lng);
        $this->getRequest()->getSession()->set('_locale', $lng);

        return $this->redirect(
            $this->generateUrl('page_accueil')
        );
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
        if (false === $this->get('security.context')->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException();
        }

        $offre = new Offre();
        $form = $this->createFormBuilder($offre)
            ->add('titre', 'text', array(
                'constraints' => array(
                    new BaseConstraints\NotBlank(array("message" => "Cette valeur ne doit pas être vide.")),
                    new BaseConstraints\Length(array('min' => 5))
                ),
                'required' => false,
                'label' => 'Titre de l\'offre'  
            ))
            ->add('description', 'textarea')
            ->add('categorie', 'entity', array(
                'class' => 'IsetFormationBundle:Categorie',
                'property' => 'titre'
            ))
            ->add('submit', 'submit')
            ->getForm()
        ;
        
        if ($this->getRequest()->getMethod() == "POST") {
            //Binding des données
            $form->submit($this->getRequest());
            if ($form->isValid()) {
                //lappel au service doctrine
                $em = $this->getDoctrine()->getManager();
                //Préparrer l'ordre sql'
                $em->persist($offre);
                //éxécuter la requette
                $em->flush();
                //Ajouter une information de success dans la session
                $this->getRequest()->getSession()->getFlashBag()->add(
                    'success', 'Offre inséré avec succes'
                );
                $this->getRequest()->getSession()->getFlashBag()->add(
                    'error', 'Redirection vers page accueil'
                );
                
                return $this->redirect(
                    $this->generateUrl('page_accueil')
                );
            }
        }

        return array(
            'formulaire' => $form->createView()
        );
    }

    /**
     * @Route("/offre", name="offre_accueil")
     * @Template()
     */
    public function offreListAction()
    {
        $filter = array();
        $motcle = $this->getRequest()->get('motcle');
        if ($motcle) {
            $filter['titre'] = $motcle;
        }
        $em = $this->getDoctrine()->getManager();
        $offres = $em->getRepository('IsetFormationBundle:Offre')->findBY(
            $filter,
            array('dateCreation' => 'desc')
        );

        return array('offres' => $offres);
    }

    /**
     * @Route("/offre/{id}", name="offre_detail")
     * @Template()
     */
    public function offreDetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $offre = $em->getRepository('IsetFormationBundle:Offre')->find($id);

        return array('offre' => $offre);
    }
}
