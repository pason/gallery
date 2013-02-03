<?php

/**
 * 
 * @author Pason Slawomir
 *
 */

namespace Pason\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    
	/**
	 * Index Action
	 * @Template()
	 */
	public function indexAction(){
		$em = $this->getDoctrine()->getEntityManager();
		$users = $em->getRepository('PasonGalleryBundle:User')->findBy(array('isPrivate' => false));
		
		
    	return array('users' => $users);
	}
    
	/**
	 * gallery Action
	 * @Template()
	 */
	public function galleryAction($slug){
		$em = $this->getDoctrine()->getEntityManager();
		$gallery = $em->getRepository('PasonGalleryBundle:User')->findOneBy(array('slug' => $slug));
		$users = $em->getRepository('PasonGalleryBundle:User')->findBy(array('isPrivate' => false));
		$userlogged = $this->container->get('security.context')->getToken()->getUser();
		if(!$gallery or ($gallery->getIsPrivate() == true and (is_string($userlogged) or $userlogged->getSlug() != $slug))){
			throw $this->createNotFoundException('Nie ma takiej galerii');		
		}
		
		return array('users' => $users, 'gallery' => $gallery, 'slug' => $slug);
	}
	
    
  
    
}
