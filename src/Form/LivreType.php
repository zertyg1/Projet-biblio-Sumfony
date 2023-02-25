<?php

namespace App\Form;

use App\Entity\Livre;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('quatrieme', TextareaType::class , ["attr" => array("rows" => 7 , "cols" => 10 )])
            ->add('dateParution', DateType::class, array("widget" => "single_text"))
            ->add('empruntPossible')
            ->add('auteurs', null ,  ["expanded" => "true","query_builder" => (function(EntityRepository $er){
                return $er->getAuteurByOrder();
            })])

            ->addEventListener( //Listener pour vérifier qu'il y a au moins un acteur de rentré dans le form
                FormEvents::POST_SUBMIT,
                function (FormEvent $event){
                    $data = $event->getData();
                    /* @var $data \App\Entity\Livre */
                    if (count($data->getAuteurs()) == 0){
                        $event->getForm()->get("auteurs")
                            ->addError(new \Symfony\Component\Form\FormError('Il faut au moins 1 auteur'));
                    }
                }
            )

            ->addEventListener( //Listener pour vérifier qu'il y a max 3 acteur de rentré dans le form
                FormEvents::POST_SUBMIT,
                function (FormEvent $event){
                    $data = $event->getData();
                    /* @var $data \App\Entity\Livre */
                    if (count($data->getAuteurs()) > 3 ){
                        $event->getForm()->get("auteurs")
                            ->addError(new \Symfony\Component\Form\FormError('Il faut maximum 3 auteurs'));
                    }
                }
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
