function validateForm() {
    var ssn = document.forms["customerForm"]["CSSN"].value;
    var ssnPattern = /^\d{3}-\d{2}-\d{4}$/;
    if (!ssnPattern.test(ssn)) {
        alert("Invalid SSN format. Correct format is XXX-XX-XXXX.");
        return false;
    }
    return true;
}
