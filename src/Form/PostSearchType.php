<?php

namespace App\Form;

use App\Entity\PostSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dpt', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Ain' => 96,
                    'Aisne' => 1,
                    'Allier' => 2,
                    'Alpes-de-Haute-Provence' => 3,
                    'Hautes-Alpes' => 4,
                    'Alpes-Maritimes' => 5,
                    'Ardèche' => 6,
                    'Ardennes' => 7,
                    'Ariège' => 8,
                    'Aube' => 9,
                    'Aude' => 10,
                    'Aveyron' => 11,
                    'Bouches-du-Rhône' => 12,
                    'Calvados' => 13,
                    'Cantal' => 14,
                    'Charente' => 15,
                    'Charente-Maritime' => 16,
                    'Cher' => 17,
                    'Corrèze' => 18,
                    'Corse-du-Sud' => 19,
                    'Haute-Corse' => 20,
                    'Côte-d\'Or' => 21,
                    'Côtes-d\'Armor' => 22,
                    'Creuse' => 23,
                    'Dordogne' => 24,
                    'Doubs' => 25,
                    'Drôme' => 26,
                    'Eure' => 27,
                    'Eure-et-Loir' => 28,
                    'Finistère' => 29,
                    'Gard' => 30,
                    'Haute-Garonne' => 31,
                    'Gers' => 32,
                    'Gironde' => 33,
                    'Hérault' => 34,
                    'Ille-et-Vilaine' => 35,
                    'Indre' => 36,
                    'Indre-et-Loire' => 37,
                    'Isère' => 38,
                    'Jura' => 39,
                    'Landes' => 40,
                    'Loir-et-Cher' => 41,
                    'Loire' => 42,
                    'Haute-Loire' => 43,
                    'Loire-Atlantique' => 44,
                    'Loiret' => 45,
                    'Lot' => 46,
                    'Lot-et-Garonne' => 47,
                    'Lozère' => 48,
                    'Maine-et-Loire' => 49,
                    'Manche' => 50,
                    'Marne' => 51,
                    'Haute-Marne' => 52,
                    'Mayenne' => 53,
                    'Meurthe-et-Moselle' => 54,
                    'Meuse' => 55,
                    'Morbihan' => 56,
                    'Moselle' => 57,
                    'Nièvre' => 58,
                    'Nord' => 59,
                    'Oise' => 60,
                    'Orne' => 61,
                    'Pas-de-Calais' => 62,
                    'Puy-de-Dôme' => 63,
                    'Pyrénées-Atlantiques' => 64,
                    'Hautes-Pyrénées' => 65,
                    'Pyrénées-Orientales' => 66,
                    'Bas-Rhin' => 67,
                    'Haut-Rhin' => 68,
                    'Rhône' => 69,
                    'Haute-Saône' => 70,
                    'Saône-et-Loire' => 71,
                    'Sarthe' => 72,
                    'Savoie' => 73,
                    'Haute-Savoie' => 74,
                    'Paris' => 75,
                    'Seine-Maritime' => 76,
                    'Seine-et-Marne' => 77,
                    'Yvelines' => 78,
                    'Deux-Sèvres' => 79,
                    'Somme' => 80,
                    'Tarn' => 81,
                    'Tarn-et-Garonne' => 82,
                    'Var' => 83,
                    'Vaucluse' => 84,
                    'Vendée' => 85,
                    'Vienne' => 86,
                    'Haute-Vienne' => 87,
                    'Vosges' => 88,
                    'Yonne' => 89,
                    'Territoire de Belfort' => 90,
                    'Essonne' => 91,
                    'Hauts-de-Seine' => 92,
                    'Seine-Saint-Denis' => 93,
                    'Val-de-Marne' => 94,
                    'Val-d\'Oise' => 95
                ],
                'label' => 'Département',
            ])
            ->add('posttype', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Echange' => 4,
                    'Don' => 1,
                    'Vente' => 2,
                    'Recherche' => 3
                ],
                'label' => 'Type d\'annonce',
            ])
            ->add('category', ChoiceType::class, [
                'required' => false,
                'choices'  => [
                    'Plantes' => 8,
                    'Boutures' => 1,
                    'Graines' => 2,
                    'Pot(s)/Cache-pot(s)' => 3,
                    'Engrais' => 4,
                    'Terreaux' => 5,
                    'Outils' => 6,
                    'Divers' => 7
                ],
                'label' => 'Catégorie',
            ])
            ->add('description', TextType::class, [
                'required' => false,
                'label' => 'Contient :',
            ])
            ->add('title', TextType::class, [
                'required' => false,
                'label' => 'Titre :',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PostSearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return "";
    }
}
