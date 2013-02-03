<?php

/**
 *
* @author Pason Slawomir
* @class PanelController
*/

namespace Pason\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pason\GalleryBundle\Form\Media;
use Pason\GalleryBundle\Entity\File;

/**
 * Panel
 * @author slawomir
 *
 */

class PanelController extends Controller
{

	/**
	 * Index Action
	 * @Template()
	 */
	public function indexAction(){
		$request  = $this->getRequest();
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->container->get('security.context')->getToken()->getUser();
		
		$file = new File();
		$form = $this->createForm(new Media(), $file);
		
		if ($request->getMethod() == 'POST') {
			$form->bindRequest($request);
			if ($form->isValid()) {
				$em = $this->getDoctrine()->getEntityManager();
				$file->setUser($user);
				$em->persist($file);
				$em->flush();
				
				$this->get('session')->setFlash('success', 'Wgrano nowy plik do galerii');
			}
		}
		
		$gallery = $em->getRepository('PasonGalleryBundle:File')->findBy(array('user' => $user->getId(), 'deletedAt' => null ));
		$users = $em->getRepository('PasonGalleryBundle:User')->findBy(array('isPrivate' => false));
		
		return array('users'=> $users, 'gallery' => $gallery, 'form' => $form->createView());
	}
	
	/**
	 * Delete media file
	 * @param int $id
	 * @return resonse
	 */
	public function removeAction($id){
		$request  = $this->getRequest();
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->container->get('security.context')->getToken()->getUser();
		$file = $em->getRepository('PasonGalleryBundle:File')->findOneBy(array('user' => $user->getId(), 'id' => $id));
		if($file){
			$file->setDeletedAt(new \DateTime('now'));
			$em->persist($file);
			$em->flush();
			$this->get('session')->setFlash('success', 'Pomyślnie skasowano plik');
		}
		
		return $this->redirect(
				$this->generateUrl("pason_gallery_panel")
		);
		
	}
	
	/**
	 * 
	 */
	public function privatechangeAction(){
		$request  = $this->getRequest();
		$em = $this->getDoctrine()->getEntityManager();
		$user = $this->container->get('security.context')->getToken()->getUser();
		if($user->getIsPrivate()){
			$user->setIsPrivate(false);
		} else {
			$user->setIsPrivate(true);
		}
		$em->persist($user);
		$em->flush();
		
		$response = new Response(json_encode(array('status' => 'success')));
		return $response;
		
	}
	
	


	

}
