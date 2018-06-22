<?php
/**
 * Created by PhpStorm.
 * User: kevinhuang
 * Date: 2018/6/22
 * Time: 下午 08:49
 */

namespace AppBundle\Form;


use AppBundle\AppBundle;
use AppBundle\Entity\Programmer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProgrammerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname',null)
            ->add('avatarNumber',ChoiceType::class,[
                'choices' => [
                    1 => 'Girl (green)',
                    2 => 'Boy',
                    3 => 'Cat',
                    4 => 'Boy with Hot',
                    5 => 'Happy Robot',
                    6 => 'Girl (purple)'
                ]
            ])
            ->add('tagLine',TextareaType::class)
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programmer::class
        ]);
    }


    public function getName()
    {
       return 'programmer';
    }
}