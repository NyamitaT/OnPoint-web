<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "onpoint";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the maximum cost and weight from the user input
$maxCost = $_GET['maxCost'];
$maxWeight = $_GET['maxWeight'];

// Construct the SQL query with conditions for cost and weight
$sql = "SELECT * FROM meals WHERE cost <= $maxCost AND weight <= $maxWeight";

// Execute the query and retrieve the results
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Initialize an array to store the meal plan data
    $mealPlanData = array();

    // Loop through each row of the result and store the data in the array
    while ($row = $result->fetch_assoc()) {
        $mealPlanData[] = array(
            'meal' => $row['meal_name'],
            'cost' => $row['cost'],
            'weight' => $row['weight']
        );
    }

    // Return the meal plan data as JSON
    echo json_encode($mealPlanData);
} else {
    // No meal plans found matching the criteria
    echo "No meal plans found.";
}

// Close the connection
$conn->close();
?>
