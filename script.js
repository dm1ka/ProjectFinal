document.addEventListener("DOMContentLoaded", function () {
    const cipherForm = document.querySelector("form[action='process.php']");
    const text = document.getElementById("text");
    const file = document.getElementById("file");
    const keyInput = document.getElementById("key");
    const keyStrength = document.getElementById("keyStrength");

    if (cipherForm) {
        cipherForm.addEventListener("submit", function (e) {
            if (!text.value.trim() && file.files.length === 0) {
                e.preventDefault();
                alert("Wprowadź tekst lub załaduj plik .txt");
            }
        });
    }

    if (keyInput && keyStrength) {
        keyInput.addEventListener("input", function () {
            const key = keyInput.value;
            let strength = "Bardzo słaby";
            let color = "red";

            if (key.length >= 12 && /[A-Z]/.test(key) && /[a-z]/.test(key) && /\d/.test(key)) {
                strength = "Silny klucz";
                color = "green";
            } else if (key.length >= 8 && /[A-Za-z]/.test(key) && /\d/.test(key)) {
                strength = "Średni";
                color = "orange";
            } else if (key.length >= 5) {
                strength = "Słaby";
                color = "darkorange";
            }

            keyStrength.textContent = "Siła klucza: " + strength;
            keyStrength.style.color = color;
        });
    }
});
