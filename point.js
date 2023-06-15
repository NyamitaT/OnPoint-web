document.addEventListener("DOMContentLoaded", function() {
    // Sample meal data
    const meals = [
      { name: "Grilled Chicken Salad", time: "quick", cost: "cheap", goal: "weightLoss" },
      { name: "Pasta Carbonara", time: "moderate", cost: "moderate", goal: "maintenance" },
      { name: "Steak with Mashed Potatoes", time: "slow", cost: "expensive", goal: "muscleGain" },
      // Add more meal data here...
    ];
  
    const mealList = document.getElementById("mealList");
    const timeFilter = document.getElementById("timeFilter");
    const costFilter = document.getElementById("costFilter");
    const goalFilter = document.getElementById("goalFilter");
    const filterButton = document.getElementById("filterButton");
  
    // Display all meals initially
    displayMeals(meals);
  
    // Add event listener to the filter button
    filterButton.addEventListener("click", applyFilters);
  
    function displayMeals(meals) {
      mealList.innerHTML = "";
      if (meals.length === 0) {
        const noResultsMessage = document.createElement("div");
        noResultsMessage.textContent = "No meals match the selected filters.";
        mealList.appendChild(noResultsMessage);
      } else {
        meals.forEach(function(meal) {
          const mealDiv = document.createElement("div");
          mealDiv.classList.add("meal");
          mealDiv.textContent = meal.name;
          mealList.appendChild(mealDiv);
        });
      }
    }
  
    function applyFilters() {
      const timeValue = timeFilter.value;
      const costValue = costFilter.value;
      const goalValue = goalFilter.value;
  
      const filteredMeals = meals.filter(function(meal) {
        return (
          (timeValue === "any" || meal.time === timeValue) &&
          (costValue === "any" || meal.cost === costValue) &&
          (goalValue === "any" || meal.goal === goalValue)
        );
      });
  
      displayMeals(filteredMeals);
    }
  });
