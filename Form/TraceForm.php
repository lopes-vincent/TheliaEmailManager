<?php

namespace TheliaEmailManager\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use TheliaEmailManager\DataTransformer\EmailListTransformer;

/**
 * @author Gilles Bourgeat <gilles.bourgeat@gmail.com>
 */
class TraceForm extends BaseForm
{
    const FIELD_ID = 'id';
    const FIELD_TITLE = 'title';
    const FIELD_DESCRIPTION = 'description';
    const FIELD_DISABLE_HISTORY = 'disable_history';
    const FIELD_DISABLE_SENDING = 'disable_sending';
    const FIELD_FORCE_SAME_CUSTOMER_DISABLE = 'force_same_customer_disable';
    const FIELD_EMAIL_BCC = 'email_bcc';
    const FIELD_EMAIL_REDIRECT = 'email_redirect';

    /**
     * @return string
     */
    public function getName()
    {
        return Forms::TRACE_UPDATE;
    }

    public function buildForm()
    {
        $this->formBuilder
            ->add(self::FIELD_ID, HiddenType::class, [
                'constraints' => [
                    new GreaterThan(['value' => 0])
                ],
                'required'    => true
            ])
            ->add(self::FIELD_TITLE, TextType::class, [
                'constraints' => [
                    new NotBlank()
                ],
                'required' => true,
                'label' => $this->trans('The title of this trace'),
                'label_attr'  => [
                    'for' => self::FIELD_TITLE,
                    'help' => $this->trans('The code of this trace'),
                ]
            ])
            ->add(self::FIELD_DESCRIPTION, TextareaType::class, [
                'required' => false,
                'label' => $this->trans('The description of this trace'),
                'label_attr'  => ['for' => self::FIELD_DESCRIPTION]
            ])
            ->add(self::FIELD_DISABLE_HISTORY, ChoiceType::class, [
                'choices' => [
                    1 => $this->trans('Yes'),
                    0 => $this->trans('No')
                ],
                'required'    => true,
                'label' => $this->trans('Disable the history of emails for this trace'),
                'label_attr'  => ['for' => self::FIELD_DISABLE_HISTORY]
            ])
            ->add(self::FIELD_DISABLE_SENDING, ChoiceType::class, [
                'choices' => [
                    1 => $this->trans('Yes'),
                    0 => $this->trans('No')
                ],
                'required'    => true,
                'label' => $this->trans('Disable the sending of emails for this trace'),
                'label_attr'  => ['for' => self::FIELD_DISABLE_SENDING]
            ])
            ->add(self::FIELD_FORCE_SAME_CUSTOMER_DISABLE, ChoiceType::class, [
                'choices' => [
                    1 => $this->trans('Yes'),
                    0 => $this->trans('No')
                ],
                'required'    => true,
                'label' => $this->trans('Force the sending of emails for this trace'),
                'label_attr'  => [
                    'for' => self::FIELD_FORCE_SAME_CUSTOMER_DISABLE,
                    'help' => $this->trans('The emails will be send same if the user no longer wishes to receive'),
                    ]
            ])
            ->add(self::FIELD_EMAIL_BCC, TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new Callback([
                        'methods' => [[$this, 'checkEmailList']]
                    ])
                ],
                'label' => $this->trans('List of email Bcc'),
                'label_attr'  => [
                    'for' => self::FIELD_EMAIL_BCC,
                    'help' => $this->trans('List of emails separated by comma')
                ]
            ])
            ->add(self::FIELD_EMAIL_REDIRECT, TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new Callback([
                        'methods' => [[$this, 'checkEmailList']]
                    ])
                ],
                'label' => $this->trans('List of email for redirection'),
                'label_attr'  => [
                    'for' => self::FIELD_EMAIL_REDIRECT,
                    'help' => $this->trans('List of emails separated by comma')
                ]
            ])
        ;
    }

    public function checkEmailList($value, ExecutionContextInterface $context)
    {
        try {
            (new EmailListTransformer($this->translator))->reverseTransform($value);
        } catch (\Exception $e) {
            $context->addViolation($e);
        }
    }
}
