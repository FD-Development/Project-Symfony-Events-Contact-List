<?php

/**
 * Event type.
 */

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class EventType.
 */
class EventType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * @param array<string, mixed> $options
     *
     * @see FormTypeExtensionInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'label.title',
                'required' => true,
                'attr' => ['max_length' => 255],
            ]);
        $builder->add(
                'duration_from',
                DateTimeType::class,
            [
                'date_label' => 'label.date_form',
                'time_label' => 'label.time',
                'required' => true,
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'input_format' => 'd-m-Y H:i:s',
                'placeholder' =>['hour' => '00', 'minute' => '00'],

            ]
        );
        $builder->add(
            'duration_to',
            DateTimeType::class,
            [
                'date_label' => 'label.date_form',
                'time_label' => 'label.time',
                'required' => true,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'input_format' => 'd-m-Y H:i:s',
                'placeholder' =>['hour' => '00', 'minute' => '00'],

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
                'required' => false,
                'placeholder' => 'label.none',
            ]
        );

        // TU DODAĆ TAGI JAK BĘDĄ IMPLEMENTOWANE

        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'label.description',
                'required' => false,
            ]);
    }

    /**
     * Configures the options for this type.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => Event::class]);
    }

    /**
     * Returns the prefix of the template block name for this type.
     *
     * The block prefix defaults to the underscored short class name with
     * the "Type" suffix removed (e.g. "UserProfileType" => "user_profile").
     *
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'event';
    }
}
