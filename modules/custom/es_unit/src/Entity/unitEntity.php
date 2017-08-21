<?php

/**
 * @file
 * Contains \Drupal\es_unit\Entity\unitEntity.
 */

namespace Drupal\es_unit\Entity;

use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;

/**
 * Defines the Unit entity.
 *
 * @ingroup es_unit
 *
 * @ContentEntityType(
 *   id = "unit",
 *   label = @Translation("Unit"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\es_unit\unitListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\es_unit\Form\unitForm",
 *       "add" = "Drupal\es_unit\Form\unitForm",
 *       "edit" = "Drupal\es_unit\Form\unitForm",
 *       "delete" = "Drupal\es_unit\Form\unit_DeleteForm",
 *     },
 *     "access" = "Drupal\es_unit\unitAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\es_unit\unitHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "es_unit",
 *   admin_permission = "administer unit entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "id",
 *   },
 *   links = {
 *     "canonical" = "/unit/{unit}",
 *     "add-form" = "/unit/add",
 *     "edit-form" = "/unit/{unit}/edit",
 *     "delete-form" = "/unit/{unit}/delete",
 *     "collection" = "/unit",
 *   },
 *   field_ui_base_route = "unit.settings"
 * )
 */
class unitEntity extends ContentEntityBase {

    public function label() {
        $model = $this->get('model');
        $model_id = $model->target_id;
        $model_label = $model->entity->label();
        $parent = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term")->loadParents($model_id);
        $brand = reset($parent);
        $brand_label = $brand->label();

        return $brand_label . ' ' . $model_label . ' (' . $this->get('year')->value . ')';
    }

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
        $fields['id'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('ID'))
            ->setDescription(t('The ID of the Unit'))
            ->setReadOnly(TRUE);


        $fields['short_description'] = BaseFieldDefinition::create('string')
            ->setLabel(t('short_description'))
            ->setDescription(t('The short_description of the Unit'))
            ->setSettings([
                'max_length' => 255,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'string_textfield',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['full_description'] = BaseFieldDefinition::create('text_long')
            ->setLabel(t('full_description'))
            ->setDescription(t('The full_description of the Unit'))
            ->setSettings([
                'max_length' => 255,
                'text_processing' => 0,
            ])
            ->setDefaultValue('')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'text_textfield',
                'weight' => -4,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);


        $fields['category'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Category'))
            ->setDescription(t('Unit category'))
            ->setSetting('target_type', 'taxonomy_term')
            ->setSetting('handler', 'default:taxonomy_term')
            ->setSetting('handler_settings',
                array(
                    'auto_create'    => TRUE,
                    'target_bundles' => array(
                        'categories' => 'categories'
                    )))
            ->setDisplayOptions('form', array(
                'type'     => 'entity_reference_autocomplete',
                'settings' => array(
                    'match_operator' => 'CONTAINS',
                    'size'           => 60,
                    'placeholder'    => ''
                ),
                'weight'   => 1
            ))
            ->setDisplayOptions('view', array(
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 1,
            ))
            ->setRequired(TRUE)
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['options'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Options'))
            ->setDescription(t('Unit options'))
            ->setSetting('target_type', 'taxonomy_term')
            ->setSetting('handler', 'default:taxonomy_term')
            ->setSetting('handler_settings',
                array(
                    'auto_create'    => TRUE,
                    'target_bundles' => array(
                        'options' => 'options'
                    )))
            ->setDisplayOptions('form', array(
                'type'     => 'entity_reference_autocomplete',
                'settings' => array(
                    'match_operator' => 'CONTAINS',
                    'size'           => 60,
                    'placeholder'    => ''
                ),
                'weight'   => 1
            ))
            ->setDisplayOptions('view', array(
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 1,
            ))
            ->setRequired(TRUE)
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['model'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('Model'))
            ->setDescription(t('Unit model'))
            ->setSetting('target_type', 'taxonomy_term')
            ->setSetting('handler', 'default:taxonomy_term')
            ->setSetting('handler_settings',
                array(
                    'auto_create'    => TRUE,
                    'target_bundles' => array(
                        'models' => 'models'
                    )))
            ->setDisplayOptions('form', array(
                'type'     => 'options_shs', // TODO implement dependencies
                'weight'   => 1
            ))
            ->setDisplayOptions('view', array(
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 1,
            ))
            ->setRequired(TRUE)
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);


        $fields['weight'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('weight'))
            ->setDescription(t('weight'))
            ->setSettings(array(
                'size' => 'small',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);


        $fields['price'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('price'))
            ->setDescription(t('price'))
            ->setSettings(array(
                'size' => 'medium',
                'prefix' => '€ '
            ))
            ->setDisplayOptions('view', array(
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['kilometers'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('kilometers'))
            ->setDescription(t('kilometers'))
            ->setSettings(array(
                'size' => 'medium',
                'suffix' => ' km'
            ))
            ->setDisplayOptions('view', array(
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['year'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Year'))
            ->setDescription(t('Build year'))
            ->setSettings(array(
                'size' => 'small',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['cylinder_capacity'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Cylinder capacity'))
            ->setDescription(t('Cylinder capacity for the unit'))
            ->setSettings(array(
                'size' => 'small',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['hp'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Horsepower'))
            ->setSettings(array(
                'size' => 'small',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['chairs'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Chairs count'))
            ->setSettings(array(
                'size' => 'tiny',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['doors'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Doors count'))
            ->setSettings(array(
                'size' => 'tiny',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['cylinder'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Cylinder count'))
            ->setSettings(array(
                'size' => 'tiny',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['transmission'] = BaseFieldDefinition::create('list_string')
            ->setLabel(t('Transmission'))
            ->setDescription(t('The transmission for the unit.'))
            ->setSettings(array(
                'allowed_values' => array(
                    'manual' => 'Manual',
                    'automatic' => 'Automatic',
                    'semi_automatic' => 'Semi automatic',
                ),
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'options_select',
                'weight' => -4,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);


        $fields['gears'] = BaseFieldDefinition::create('integer')
            ->setLabel(t('Gears count'))
            ->setSettings(array(
                'size' => 'tiny',
            ))
            ->setDefaultValue('0')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => 4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'integer',
                'weight' => 6,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['fuel'] = BaseFieldDefinition::create('list_string')
            ->setLabel(t('Fuel'))
            ->setDescription(t('The fuel for the unit.'))
            ->setSettings(array(
                'allowed_values' => array(
                    'diesel' => 'Diesel',
                    'petrol' => 'Petrol',
                    'electro' => 'Electro',
                ),
            ))
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'options_select',
                'weight' => -4,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel(t('User Name'))
            ->setDescription(t('The Name of the associated user.'))
            ->setSetting('target_type', 'user')
            ->setSetting('handler', 'default')
            ->setDefaultValueCallback('Drupal\es_unit\Entity\unitEntity::getCurrentUserId')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'entity_reference_label',
                'weight' => -3,
            ))
            ->setDisplayOptions('form', array(
              // Hide field

                'type' => 'entity_reference_autocomplete',
                'settings' => array(
                    'match_operator' => 'CONTAINS',
                    'size' => 60,
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ),
                'weight' => -3,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['image'] = BaseFieldDefinition::create('image')
            ->setLabel(t('Image'))
            ->setSetting('target_type', 'file')
            ->setSetting('file_extensions', 'jpg jpeg png')
            ->setSetting('file_directory', 'images/unit')
            ->setSetting('title_field', FALSE)
            ->setSetting('title_field_required', FALSE)
            ->setSetting('alt_field', FALSE)
            ->setSetting('alt_field_required', FALSE)
            ->setSetting('min_resolution', '300x300')
            ->setSetting('max_resolution', '2000x2000')
            ->setSetting('max_filesize', '1 Mb')
            ->setDescription(t('The image associated with Unit'))
            ->setDefaultValue('')
            ->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'image',
                'weight' => -4,
            ])
            ->setDisplayOptions('form', [
                'type' => 'image',
                'weight' => 8,
            ])
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        $fields['specialities'] = BaseFieldDefinition::create('string')
            ->setLabel(t('Specialities'))
            ->setDescription(t('The specialities of the Unit'))
            ->setSettings(array(
                'max_length' => 255,
                'text_processing' => 0,
            ))
            ->setDefaultValue('')
            ->setDisplayOptions('view', array(
                'label' => 'above',
                'type' => 'string',
                'weight' => -4,
            ))
            ->setDisplayOptions('form', array(
                'type' => 'string_textfield',
                'weight' => -4,
            ))
            ->setDisplayConfigurable('form', TRUE)
            ->setDisplayConfigurable('view', TRUE);

        return $fields;
    }

  /**
   * Default value callback for 'user' base field definition.
   *
   * @see ::baseFieldDefinitions()
   *
   * @return array
   *   An array of default values.
   */
  static function getCurrentUserId() {
    return \Drupal::currentUser()->id();
  }
}
