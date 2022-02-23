<?php

namespace App\Form;

use App\Entity\Categoryexercice;
use App\Entity\Exercice;
use App\Repository\CategoryexerciceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExerciceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('nbrset')
            ->add('photo', FileType::class, [
                'mapped' => false
            ])
            ->add('categoryexercice',EntityType::class ,[
            'class'=>Categoryexercice ::class,
           'choice_label'=> 'name',
           'placeholder' => 'please choose a reservation',
              'query_builder'=>function(CategoryexerciceRepository $catrepo){
            return $catrepo->createQueryBuilder('c');

        }
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Exercice::class,
        ]);
    }
}
