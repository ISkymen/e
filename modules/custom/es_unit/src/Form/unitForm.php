<?php

/**
 * @file
 * Contains \Drupal\es_unit\Form\unitForm.
 */

namespace Drupal\es_unit\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for "Unit" edit forms.
 *
 * @ingroup es_unit
 */
class unitForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\es_unit\Entity\unitEntity */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Unit.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Unit.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.unit.canonical', ['unit' => $entity->id()]);
  }

}
