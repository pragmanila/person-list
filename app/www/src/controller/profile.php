<?php //-->
/**
 * This file is part of a Custom Project.
 * (c) 2017-2019 Acme Inc.
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

use Cradle\Module\Utility\File;


/**
 * Render the Profile Create Page
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/profile/create', function ($request, $response) {
    //----------------------------//
    // 1. Route Permissions

    //----------------------------//
    // 2. Prepare Data
    $data = ['item' => $request->getPost()];

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'danger');
        $data['errors'] = $response->getValidation();
    }
    
    // remove the validation
    $response->removePage('flash');

    //----------------------------//
    // 3. Render Template
    $class = 'page-profile-create';
    $data['title'] = cradle('global')->translate('Create Profile');
    $body = cradle('/app/www')->template('profile/form', $data);
    
    //set content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //render page
}, 'render-www-page');

/**
 * Render the Profile Update Page
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/profile/update/:profile_id', function ($request, $response) {
    //----------------------------//
    // 1. Route Permissions

    //----------------------------//
    // 2. Prepare Data
    $data = ['item' => $request->getPost()];

    //if no item
    if (empty($data['item'])) {
        cradle()->trigger('profile-detail', $request, $response);

        //can we update ?
        if ($response->isError()) {
            //add a flash
            cradle('global')->flash($response->getMessage(), 'danger');
            return cradle('global')->redirect('/');
        }

        $data['item'] = $response->getResults();
    }

    if ($response->isError()) {
        $response->setFlash($response->getMessage(), 'danger');
        $data['errors'] = $response->getValidation();
    }
    
    // remove the validation
    $response->removePage('flash');

    //----------------------------//
    // 3. Render Template
    $class = 'page-profile-update';
    $data['title'] = cradle('global')->translate('Updating Profile');
    $body = cradle('/app/www')->template('profile/form', $data);

    //Set Content
    $response
        ->setPage('title', $data['title'])
        ->setPage('class', $class)
        ->setContent($body);

    //Render page
}, 'render-www-page');


/**
 * Process the Profile Create Page
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->post('/profile/create', function ($request, $response) {
    //----------------------------//
    // 1. Route Permissions
    //only for admin
    
    //----------------------------//
    // 2. Prepare Data
    //profile_slug is disallowed
    $request->removeStage('profile_slug');

    //profile_type is disallowed
    $request->removeStage('profile_type');

    //profile_flag is disallowed
    $request->removeStage('profile_flag');
    
    //----------------------------//
    // 3. Process Request
    cradle()->trigger('profile-create', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        return cradle()->triggerRoute('get', '/profile/create', $request, $response);
    }
    
    //it was good
    //add a flash
    cradle('global')->flash('Profile was Created', 'success');

    //redirect
    cradle('global')->redirect('/');
});

/**
 * Process the Profile Remove
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/profile/remove/:profile_id', function ($request, $response) {
    //----------------------------//
    // 1. Route Permissions
    //only for admin

    //----------------------------//
    // 2. Prepare Data
    // no data to preapre
    //----------------------------//
    // 3. Process Request
    cradle()->trigger('profile-remove', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        //add a flash
        cradle('global')->flash($response->getMessage(), 'danger');
    } else {
        //add a flash
        $message = cradle('global')->translate('Profile was Removed');
        cradle('global')->flash($message, 'success');
    }

    cradle('global')->redirect('/');
});

/**
 * Process the Profile Update Page
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->post('/profile/update/:profile_id', function ($request, $response) {
    //----------------------------//
    // 1. Route Permissions
    //only for admin

    //----------------------------//
    // 2. Prepare Data

    //profile_slug is disallowed
    $request->removeStage('profile_slug');

    //profile_type is disallowed
    $request->removeStage('profile_type');

    //profile_flag is disallowed
    $request->removeStage('profile_flag');

    //----------------------------//
    // 3. Process Request
    cradle()->trigger('profile-update', $request, $response);

    //----------------------------//
    // 4. Interpret Results
    if ($response->isError()) {
        $route = '/profile/update/' . $request->getStage('profile_id');
        return cradle()->triggerRoute('get', $route, $request, $response);
    }

    //it was good
    //add a flash
    cradle('global')->flash('Profile was Updated', 'success');

    //redirect
    cradle('global')->redirect('/');
});
