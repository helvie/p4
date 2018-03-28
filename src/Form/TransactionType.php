<?php
/**
 * Created by PhpStorm.
 * User: Sylvie
 * Date: 10/01/2018
 * Time: 23:07
 */

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;




class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('visitDate', DateType::class, [
                'label' => "A quelle date souhaitez-vous venir ?",
                'widget' => 'single_text'])

            ->add('nbPersons', NumberType::class, [
                'label' => "Combien de personnes serez-vous ?",
                'required' => false,
                ])

            ->add('halfDay', CheckboxType::class, array('required' => false, 'label' => false,))

            ->add('email', EmailType::class, array('required' => false,))

            ->add('persons', CollectionType::class, array(
                'required' => false,
                'entry_type' => PersonType::class,
                'entry_options' => array('label' => false),
            ))

            ->add('transactionCode', TextType::class, array('required' => false,))

            ->add('save', SubmitType::class, ['attr' => ['class' => 'btn btn btn-info btnSave']]);
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Transaction::class,
        ));
    }
}

