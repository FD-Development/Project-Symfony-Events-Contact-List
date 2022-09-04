<?php

/**
 * Contact type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ContactType.
 */
class ContactType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param FormBuilderInterface $builder Form Builder
     * @param array<string, mixed> $options Options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'name',
            TextType::class,
            [
                'label' => 'label.name',
                'required' => true,
                'attr' => ['max_length' => 155],
            ]
        );
        $builder->add(
            'surname',
            TextType::class,
            [
                'label' => 'label.surname',
                'required' => false,
                'attr' => ['max_length' => 155],
            ]
        );
        $builder->add(
            'telephone',
            TelType::class,
            [
                'label' => 'label.telephone',
                'required' => false,
            ]
        );
        $builder->add(
            'email',
            EmailType::class,
            [
                'label' => 'label.email',
                'required' => false,
            ]
        );
        $builder->add(
            'birthdate',
            DateType::class,
            [
                'label' => 'label.birthdate',
                'required' => false,
                'widget' => 'single_text',
                'input_format' => 'd-m-Y',
            ]
        );

        $builder->add(
            'category',
            EntityType::class,
            [
                'class' => Category::class,
                'choice_label' => function ($category): string {
                    return $category->getTitle();
                },
                'label' => 'label.category',
                'required' => true,
                'placeholder' => false,
            ]
        );

        $builder->add(
            'note',
            TextareaType::class,
            [
                'label' => 'label.note',
                'required' => false,
            ]
        );
    }

    /**
     * Configures the options for this type.
     *
     * @param OptionsResolver $resolver OptionsResolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Contact::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string Prefix
     */
    public function getBlockPrefix(): string
    {
        return 'contact';
    }
}
