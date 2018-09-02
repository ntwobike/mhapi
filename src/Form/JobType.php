<?php

namespace App\Form;

use App\Entity\Job;
use App\Form\Transformer\CategoryIdTransformer;
use App\Form\Transformer\UserIdTransformer;
use App\Form\Transformer\ZipcodeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    /**
     * @var UserIdTransformer
     */
    protected $userIdTransformer;

    /**
     * @var CategoryIdTransformer
     */
    protected $categoryIdTransformer;

    /**
     * @var ZipcodeTransformer
     */
    protected $zipcodeTransformer;

    /**
     * JobType constructor.
     *
     * @param CategoryIdTransformer $categoryIdTransformer
     * @param ZipcodeTransformer    $zipcodeTransformer
     * @param UserIdTransformer     $userIdTransformer
     */
    public function __construct(
        CategoryIdTransformer $categoryIdTransformer,
        ZipcodeTransformer $zipcodeTransformer,
        UserIdTransformer $userIdTransformer
    ) {
        $this->categoryIdTransformer = $categoryIdTransformer;
        $this->zipcodeTransformer    = $zipcodeTransformer;
        $this->userIdTransformer     = $userIdTransformer;
    }

    /**
     * @author Nadeen Nilanka <ntwobike@gmail.com>
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('due_date', DateTimeType::class, [
                'widget'        => 'single_text',
                'format'        => 'yyyy-MM-dd',
                'property_path' => 'dueDate',
            ])
            ->add('category_id', NumberType::class, [
                'invalid_message' => 'Invalid category received',
                'property_path'   => 'category',
            ])
            ->add('zipcode', TextType::class, [
                'invalid_message' => 'Invalid zipcode received',
                'property_path'   => 'location',
            ])
            ->add('created_by', NumberType::class, [
                'invalid_message' => 'Invalid user id received'
            ]);

        $builder->get('category_id')
            ->addModelTransformer($this->categoryIdTransformer);
        $builder->get('zipcode')
            ->addModelTransformer($this->zipcodeTransformer);
        $builder->get('created_by')
            ->addModelTransformer($this->userIdTransformer);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'      => Job::class,
            'csrf_protection' => false,
        ]);
    }
}
