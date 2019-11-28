<?php
  \OCP\User::checkLoggedIn();

  if (!\OCP\App::isEnabled('flowupload')) {
  	http_response_code(403);
  }

  function getAllLocations() {
    // ToDo: Return locations from database
    return array('/flowupload/');
    //return array();
  }

  function addNewLocation($location) {
  	$location = preg_replace('/(\.\.\/|~|\/\/)/i', '', '/'.$location.'/');
    $location = preg_replace('/[^a-z0-9äöüß \(\)\.\-_\/]/i', '', $location);
  	$location = trim($location);

    //Add to database
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_POST = json_decode(file_get_contents('php://input'), true);

    if (isset($_POST['location']) && \OC\Files\Filesystem::isValidPath($_POST['location'])) {
      $locations = getAllLocations();

      foreach ($locations as $location) {
        if ($location['location'] === $_POST['location']) {
          http_response_code(409);
          die();
        }
      }

      http_response_code(201);

      $location = addNewLocation($_POST['location']);
    }
    else {
      http_response_code(400);
    }

    die();
  }

  echo json_encode(getAllLocations());
?>
