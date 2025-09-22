<?php
require_once __DIR__.'/router/router.php';

//************************************USERS
//CREATE
post('/create', 'usecases/create_user.php');
//UPATE QUESTIONS
post('/update-questions','usecases/update_questions.php');
// GET SCORE
get('/score/$user_id','usecases/get-score.php');

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','usecases/tests/404.php');
