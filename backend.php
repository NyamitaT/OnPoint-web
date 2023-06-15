<?php
// Function to filter meals based on selected filters
function filterMeals($time, $cost, $goal) {
    // Sample meal data
    $meals = 
    [
        ["name" => "Grilled Chicken Salad", "time" => "quick", "cost" => "cheap", "goal" => "weightLoss"],
        ["name" => "Pasta Carbonara", "time" => "moderate", "cost" => "moderate", "goal" => "maintenance"],
        ["name" => "Steak with Mashed Potatoes", "time" => "slow", "cost" => "expensive", "goal" => "muscleGain"],
        ["name" => "Ugali with Pork", "time" => "moderate", "cost" => "moderate", "goal" => "maintenance"],
        ["name" => "Chapati with bean stew", "time" => "slow", "cost" => "moderate", "goal" => "muscleGain"],
        ["name" => "Brownrice with beef steak+kachumbari", "time" => "slow", "cost" => "expensive", "goal" => "weightloss"]
    ];
    // Filter the meals based on the selected filters
    $filteredMeals = array_filter($meals, function($meal) use ($time, $cost, $goal) {
        return (
            ($time === "any" || $meal["time"] === $time) &&
            ($cost === "any" || $meal["cost"] === $cost) &&
            ($goal === "any" || $meal["goal"] === $goal)
        );
    });

    return array_values($filteredMeals); // Re-index the array keys
}

// Function to save the selected meal to the database
function saveSelectedMeal($mealName, $time, $cost, $goal) {
    // Configure the database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "point";

    // Create a new connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO selected_meals (meal_name, time_to_eat, cost, body_goals) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $mealName, $time, $cost, $goal);

    // Execute the statement
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Get the selected filters from the AJAX request
$timeFilter = $_GET["time"] ?? "any";
$costFilter = $_GET["cost"] ?? "any";
$goalFilter = $_GET["goal"] ?? "any";

// Filter the meals based on the selected filters
$filteredMeals = filterMeals($timeFilter, $costFilter, $goalFilter);

// Save the selected meals to the database
foreach ($filteredMeals as $meal) {
    saveSelectedMeal($meal["name"], $meal["time"], $meal["cost"], $meal["goal"]);
}

// Send the filtered meals as a JSON response
header("Content-Type: application/json");
echo json_encode($filteredMeals);
?>
