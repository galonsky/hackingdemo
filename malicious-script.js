window.onload = function() {
    document.getElementById('form').onsubmit = function() {
        var password = document.getElementById('password').value;

        var message = "Muhahah! I am a malicious script that has been embeeded in the page due to an XSS exploit!"
        + " I have grabbed your password: '" + password + "'."
        + " If my programmer wanted, I could send your password to a malicious server to store and use against you!";

        alert(message);

        return true;
    };
}
