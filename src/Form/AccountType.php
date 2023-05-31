<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prenom",
                "attr" => ["placeholder" => "Votre prénom"]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom de famille",
                "attr" => ["placeholder" => "Votre nom de famille"]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "attr"  => ["placeholder" => "Votre email"]
            ])
            ->add('hash', PasswordType::class, [
                "label" => "Mot de passe",
                "attr"  => ["placeholder" => "Votre mot de passe"]
            ])
            ->add('passwordConfirm', PasswordType::class, [
                "label" => "Confirmation de mot de passe",
                "attr"  => ["placeholder" => "Retapez votre mot de passe"]
            ])
            ->add('avatar', UrlType::class, [
                'label' => 'Lien de votre avatar',
                'attr'  => ['placeholder' => 'Coller un lien d\'image']   
            ])
            ->add('presentation', TextType::class, [
                "label" => "",
                "attr"  => ["placeholder" => "Un petit slogan ? Une inspiration a partager ? C'est ici !"]
            ])
            ->add('Inscription', SubmitType::class)
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
