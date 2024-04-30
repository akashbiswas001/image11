<?php
    $title = $_POST['title'];
    $description = $_POST['description'];

    $con = new mysqli('localhost', 'root', '', 'myimage');

    if($con->connect_error) {
        $response = array('status' => 'error', 'message' => 'Connection Failed: ' . $con->connect_error);
    } else {
        $stmt = $con->prepare("INSERT INTO image (title, description) VALUES (?, ?)");

        if (!$stmt) {
            $response = array('status' => 'error', 'message' => 'Error in preparing statement: ' . $con->error);
        } else {
            $stmt->bind_param("ss", $title, $description);

            if (!$stmt->execute()) {
                $response = array('status' => 'error', 'message' => 'Error in executing statement: ' . $stmt->error);
            } else {
                $response = array('status' => 'success', 'message' => 'Image Uploaded Successfully');
            }

            $stmt->close();
        }

        $con->close();
    }

    // Send the JSON response
    echo json_encode($response);
?>
