document.getElementById("registrationForm").addEventListener("submit", function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    fetch("registeration.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Registration successful: " + data.message);
            document.getElementById("registrationForm").reset();
            
        } else {
            alert("Registration failed: " + data.message);
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
});
