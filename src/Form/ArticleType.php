<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'article',
                'attr'  => ['placeholder' => 'Le titre de votre article']
            ])
            ->add('intro', TextType::class, [
                'label' => 'Intro de l\'article',
                'attr'  => ['placeholder' => 'Une phrase d\'acroche']   
            ])
            ->add('image', UrlType::class, [
                'label' => 'Adresse de l\'image',
                'attr'  => ['placeholder' => 'Coller un lien d\'image']   
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Votre contenu',
                'attr'  => ['placeholder' => 'Dites-nous tout !']   
            ])
            ->add('Envoyer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
