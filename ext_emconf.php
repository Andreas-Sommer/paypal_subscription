<?php

/***************************************************************
 * Extension Manager/Repository config file for ext "cart".
 *
 * Auto generated 07-05-2019 10:38
 *
 * Manual updates:
 * Only the data in the array - everything else is removed by next
 * writing. "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
  'title' => 'Paypal Subscription',
  'description' => 'Paypal Subscription for Cart',
  'category' => 'plugin',
  'version' => '0.1.0',
  'state' => 'beta',
  'uploadfolder' => true,
  'createDirs' => '',
  'clearcacheonload' => true,
  'author' => 'Andreas Sommer',
  'author_email' => 'sommer@belsignum.com',
  'author_company' => 'belsignum',
  'constraints' =>
  [
    'depends' =>
    [
      'typo3' => '8.7.0-8.7.99',
	  'cart' => '5.4.0',
	  'cart_products' => '1.0.2'
    ],
    'conflicts' =>
    [],
    'suggests' =>
    [
    ],
  ],
];

