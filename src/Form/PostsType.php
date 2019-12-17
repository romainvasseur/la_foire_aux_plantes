<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre de l\'annonce'
            ])
            ->add('description', null, [
                'label' => 'Description'
            ])
            ->add('dpt',ChoiceType::class, [
                'choices' => $this->getDepartement(),
                'label' => 'Département'
            ])
            ->add('postal', null, [
                'label' => 'Code postal 5 chiffres'
            ])
            ->add('city', null, [
                'label' => 'Ville'
            ])
            ->add('price', null, [
                'label' => 'Prix'
            ])
            ->add('quantity', null, [
                'label' => 'Quantité disponible'
            ])
            ->add('category', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Catégorie'
            ])
            ->add('posttype', ChoiceType::class, [
                'choices' => $this->getTypeName(),
                'label' => 'Type d\'annonce'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }

    private function getChoices()
    {
        $choices = Posts::CATEGORY;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getTypeName()
    {
        $choices = Posts::TYPE;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }

    private function getDepartement()
    {
        $choices = Posts::DEPARTEMENT;
        $output = [];
        foreach($choices as $k => $v){
            $output[$v] = $k;
        }
        return $output;
    }
}
