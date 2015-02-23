<?php

namespace HB\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('contenu')
            //->add('dateCreation')
            /*->add('auteur', 'entity', array(
					  'class'        => 'HBBlogBundle:Utilisateur',
					  'property'     => 'login',
            		  'expanded'	=> true,
            		  'required'    => false,
            		  'empty_value' => "aucun",
            		  'query_builder' => function(\HB\BlogBundle\Entity\UtilisateurRepository $r) {
            				return $r->getSelectList();
            			}
            )) */
            ->add('Créer', 'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HB\BlogBundle\Entity\Article'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'hb_blogbundle_article';
    }
}
