<?php

namespace Pason\GalleryBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Media extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options){
		
		$builder
			->add('file','file',array('label' => 'Dodaj zdjęcie:', 'required' => true));
		
	}

	
	public function getDefaultOptions(array $options)
	{
		return array(
			'data_class' => 'Pason\GalleryBundle\Entity\File',
		);
	}
	
	public function getName()
	{
		return 'upload';
	}
}