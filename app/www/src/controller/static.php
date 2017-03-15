<?php //-->

/**
 * Render the Home Page
 *
 * @param Request $request
 * @param Response $response
 */
$cradle->get('/', function ($request, $response) {
    //Prepare body
    $data = [];
    
    if (!$request->hasStage('range')) {
        $request->setStage('range', 50);
    }
    
    //filter possible sorting options
    //we do this to prevent SQL injections
    if (is_array($request->getStage('order'))) {
        $sortable = [
            'profile_name'
        ];

        foreach ($request->getStage('order') as $key => $direction) {
            if (!in_array($key, $sortable)) {
                $request->removeStage('order', $key);
            } else if ($direction !== 'ASC' && $direction !== 'DESC') {
                $request->removeStage('order', $key);
            }
        }
    }

    //trigger job
    cradle()->trigger('profile-search', $request, $response);
    $data = array_merge($request->getStage(), $response->getResults());

    //Render body
    $class = 'page-home';
    $title = cradle('global')->translate('Person List');
    $body = cradle('/app/www')->template('index', $data);

    //Set Content
    $response
        ->setPage('title', $title)
        ->setPage('class', $class)
        ->setContent($body);

    //Render blank page
}, 'render-www-page');
