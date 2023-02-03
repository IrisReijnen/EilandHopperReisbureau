
function validate_cc(cc_number, cc_expiry, cc_cvc)
    // adapted from https://www.w3schools.com/js/js_validation.asp
    // string manipulations from https://www.w3schools.com/jsref/jsref_obj_string.asp
    {
    if (!/[0-9]{16}/.test(cc_number)) { 
        alert("Please provide valid creditcard number.");
        return false;
    }
    if (!/[0-9][0-9]\/[0-9][0-9]/.test(cc_expiry)) { 
        alert("Date must be in format dd/mm.");
        return false;
    }
    if (!/[0-9]{3}/.test(cc_cvc)) { 
        alert("Please provide valid CVC code.");
        return false;
    }
    return true;
    }
