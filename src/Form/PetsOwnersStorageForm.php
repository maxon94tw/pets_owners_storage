<?php

namespace Drupal\pets_owners_storage\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class PetsOwnersStorageForm.
 *
 * @package Drupal\pets_owners_storage\Form
 */
class PetsOwnersStorageForm extends FormBase {


  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pets_owners_storage_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $conn = Database::getConnection();
     $record = array();
    if (isset($_GET['num'])) {
        $query = $conn->select('pets_owners_storage', 'm')
            ->condition('id', $_GET['num'])
            ->fields('m');
        $record = $query->execute()->fetchAssoc();

    }

      $prefix = [
          'mr' => $this->t('mr'),
          'mrs' => $this->t('mrs'),
          'ms' => $this->t('ms'),
      ];

      $form['prefix'] = [
          '#type' => 'select',
          '#title' => $this->t('Prefix'),
          '#options' => $prefix,
          '#default_value' => (isset($record['prefix']) && $_GET['num']) ? $record['prefix']:'',
      ];

      $form['name'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Name'),
          '#maxlength' => 100,
          '#size' => 100,
          '#required' => TRUE,
          '#default_value' => (isset($record['name']) && $_GET['num']) ? $record['name']:'',
      ];

      $gender = [
          'male' => $this->t('male'),
          'female' => $this->t('female'),
          'unknown' => $this->t('unknown')
      ];

      $form['gender'] = [
          '#type' => 'radios',
          '#title' => $this->t('Gender'),
          '#options' => $gender,
          '#default_value' => (isset($record['gender']) && $_GET['num']) ? $record['gender']:'',
      ];

      $form['age'] = [
          '#type' => 'number',
          '#title' => $this->t('Age'),
          '#min' => 1,
          '#max' => 120,
          '#required' => TRUE,
      ];

      $condition = [];
      for ($i = 1; $i < 18; $i++) {
          $some_e = [':input[name="age"]' => ['value' => "$i"]];
          $condition[] = $some_e;
      }
      $form['parents'] = [
          '#type' => 'container',
          '#attributes' => [
              'class' => [
                  'accommodation',
              ],
          ],
          '#states' => [
              'visible' => $condition,
          ],
      ];

      $form['parents']['father'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Father`s name'),
          '#default_value' => (isset($record['father']) && $_GET['num']) ? $record['father']:'',
      ];

      $form['parents']['mother'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Mother`s name'),
          '#default_value' => (isset($record['mother']) && $_GET['num']) ? $record['mother']:'',
      ];

      $form['have_pets'] = [
          '#type' => 'checkbox',
          '#title' => $this->t('Have you some pets?'),
      ];

      $form['pets_name'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Name(s) of your pet(s)'),
          '#states' => [
              'invisible' => [
                  'input[name="have_pets"]' => [
                      'checked' => FALSE,
                  ],
              ],
          ],
          '#default_value' => (isset($record['pets_name']) && $_GET['num']) ? $record['pets_name']:'',
      ];

      $form['email'] = [
          '#type' => 'textfield',
          '#title' => $this->t('Email'),
          '#required' => TRUE,
          '#default_value' => (isset($record['email']) && $_GET['num']) ? $record['email']:'',
      ];

      $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Send'),
      ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state); // TODO: Change the autogenerated stub

        if (($form_state->getValue('age') < '1') || ($form_state->getValue('age') > '120')) {
            $form_state->setErrorByName('age', $this->t('Age should be more than 0 and less than 120'));
        }
        if (empty(trim($form_state->getValue('name'))) || (mb_strlen($form_state->getValue('name')) > 100)) {
            $form_state->setErrorByName('name', $this->t('Name should be 100 symbols max'));
        }
        if (!$form_state->getValue('email') || !filter_var($form_state->getValue('email'), FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('email', $this->t('Email is not correct'));
        }
    }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $field=$form_state->getValues();
    $prefix=$field['prefix'];
    $name=$field['name'];
    $gender=$field['gender'];
    $age=$field['age'];
    $father=$field['father'];
    $mother=$field['mother'];
    $pets_name=$field['pets_name'];
    $email=$field['email'];

    /*$insert = array('name' => $name, 'mobilenumber' => $number, 'email' => $email, 'age' => $age, 'gender' => $gender, 'website' => $website);
    db_insert('mydata')
    ->fields($insert)
    ->execute();

    if($insert == TRUE)
    {
      drupal_set_message("your application subimitted successfully");
    }
    else
    {
      drupal_set_message("your application not subimitted ");
    }*/

    if (isset($_GET['num'])) {
          $field  = array(
              'prefix' => $prefix,
              'name'   => $name,
              'gender' =>  $gender,
              'age' => $age,
              'father' => $father,
              'mother' => $mother,
              'pets_name' => $pets_name,
              'email' => $email,
          );
          $query = \Drupal::database();
          $query->update('pets_owners_storage')
              ->fields($field)
              ->condition('id', $_GET['num'])
              ->execute();
          drupal_set_message("succesfully updated");
          $form_state->setRedirect('pets_owners_storage.display_table_controller_display');

      }

       else
       {
           $field  = array(
               'prefix' => $prefix,
               'name'   => $name,
               'gender' =>  $gender,
               'age' => $age,
               'father' => $father,
               'mother' => $mother,
               'pets_name' => $pets_name,
               'email' => $email,
          );
           $query = \Drupal::database();
           $query ->insert('pets_owners_storage')
               ->fields($field)
               ->execute();
           drupal_set_message("succesfully saved");

           $response = new RedirectResponse("/drupal-8.8.1/pets_owners_storage/hello/table");
           $response->send();
       }
     }

}
