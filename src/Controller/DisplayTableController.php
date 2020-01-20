<?php

namespace Drupal\pets_owners_storage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

/**
 * Class DisplayTableController.
 *
 * @package Drupal\pets_owners_storage\Controller
 */
class DisplayTableController extends ControllerBase {


  public function getContent() {
    // First we'll tell the user what's going on. This content can be found
    // in the twig template file: templates/description.html.twig.
    // @todo: Set up links to create nodes and point to devel module.
    $build = [
      'description' => [
        '#theme' => 'mydata_description',
        '#description' => 'foo',
        '#attributes' => [],
      ],
    ];
    return $build;
  }

  /**
   * Display.
   *
   * @return string
   *   Return Hello string.
   */
  public function display() {
    /**return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: display with parameter(s): $name'),
    ];*/

    //create table header
    $header_table = array(
     'id' => t('ID'),
     'prefix' => t('Prefix'),
     'name' => t('Name'),
     'gender' => t('Gender'),
     'age' => t('Age'),
     'father' => t('Father`s name'),
     'mother' => t('Mother`s name'),
     'pets_name' => t('Pets name'),
     'email' => t('Email'),
     'opt' => t('Delete'),
     'opt1' => t('Edit'),
    );

//select records from table
    $query = \Drupal::database()->select('pets_owners_storage', 'm');
      $query->fields('m', ['id','prefix','name','gender','age','father','mother','pets_name','email']);
      $results = $query->execute()->fetchAll();
        $rows=array();
    foreach($results as $data){
        $delete = Url::fromUserInput('/pets_owners_storage/form/delete/'.$data->id);
        $edit   = Url::fromUserInput('/pets_owners_storage/form/pets_owners_storage?num='.$data->id);

      //print the data from table
             $rows[] = array(
            'id' => $data->id,
            'prefix' => $data->prefix,
            'name' => $data->name,
            'gender' => $data->gender,
            'age' => $data->age,
            'father' => $data->father,
            'mother' => $data->mother,
            'pets_name' => $data->pets_name,
            'email' => $data->email,

            \Drupal::l('Delete', $delete),
            \Drupal::l('Edit', $edit),
            );

    }
    //display data in site
    $form['table'] = [
            '#type' => 'table',
            '#header' => $header_table,
            '#rows' => $rows,
            '#empty' => t('No users found'),
        ];
//        echo '<pre>';print_r($form['table']);exit;
        return $form;

  }

}
