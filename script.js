// Example: Simple form validation
document.querySelector('form').addEventListener('submit', function (event) {
    var amount = document.querySelector('input[name="amount"]').value;
    if (isNaN(amount) || amount <= 0) {
        alert("Please enter a valid amount");
        event.preventDefault();
    }
});
