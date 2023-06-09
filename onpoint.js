function generateMealPlan() {
  // Get user inputs
  var maxCost = document.getElementById('cost').value;
  var maxWeight = document.getElementById('weight').value;
  var bodyGoals = document.getElementById('body-goals').value;

 // Perform AJAX request
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var mealPlanData = JSON.parse(xhr.responseText);
                displayMealPlan(mealPlanData);
            } else {
                console.error('Request failed. Status:', xhr.status);
            }
        }
    };

    // Update the URL with the maximum cost and weight values
    var url = 'mealplan.php?maxCost=' + maxCost + '&maxWeight=' + maxWeight;
    xhr.open('GET', url, true);
    xhr.send();
}

function displayMealPlan(mealPlanData) {
    // Clear previous meal plan results
    var mealPlanBody = document.getElementById('meal-plan-body');
    mealPlanBody.innerHTML = '';

    // Display the meal plan results
    mealPlanData.forEach(function(item) {
        var row = document.createElement('tr');
        row.innerHTML = '<td>' + item.meal + '</td>' +
            '<td>' + item.cost + '</td>' +
            '<td>' + item.weight + '</td>';
        mealPlanBody.appendChild(row);
    });
}
