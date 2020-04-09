<!DOCTYPE html>
<html lang="en">
​
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Pin</title>
​
    <!-- Custom CSS-->
    <style>
        .checkbox-appended {
            margin-top: .4rem !important;
        }
​
        small#pinInfo {
            padding: 5px 10px;
            border-left: 4px solid #02b3e4;
        }
​
        label.custom-label {
            padding-left: 5px;
            font-size: small;
            font-weight: bold;
        }
    </style>
​
</head>
​
<body>
​
    <div class="container">
        <div class="row">
            <form>
                <div class="form-group">
                    <label class="custom-label" for="myPayPin">Create myPay PIN</label>
                    <div class="row">
                        <div class="col-auto">
                            <div class="input-group">
                                <input type="password" class="form-control" id="myPayPin" aria-describedby="pinInfo">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input mt-2" id="showMe">
                                            <label class="form-check-label" for="showMe">Show</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
​
                        </div>
                        <div class="col-auto">
                            <small id="pinInfo" class="form-text text-muted">Your PIN should be 4 digits. It cannot
                                contain repeated or consecutive numbers.</small>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary" id="pinSubmitBtn" disabled>Submit</button>
            </form>
        </div>
    </div>
​
​
​
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
        crossorigin="anonymous"></script>
    <!-- Normal SweetAlert-->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha256-KsRuvuRtUVvobe66OFtOQfjP8WA2SzYsmm4VPfMnxms=" crossorigin="anonymous"></script> -->
    <!-- SweetAlert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
​
    <!-- Custom JavaScript -->
    <script>
        //Bind thes page elements to these varibales
        let myPayPin = document.getElementById("myPayPin");
        let showMe = document.getElementById("showMe");
        let pinSubmitBtn = document.getElementById("pinSubmitBtn");
​
        //Fxn to toggle the show or hide status of the entered PIN
        function showOrHideMyPin() {
            if (showMe.checked) { myPayPin.setAttribute('type', 'text'); }
            else { myPayPin.setAttribute('type', 'password'); }
        }
​
        //Fxn to validate the PIN
        function validatePinDigits() {
            var pinDigits = myPayPin.value;
            var pinLen = pinDigits.length;
            var errMsg = "", msgExtra = "";
            var pattern = /^\d{4}$/;
            var result = pattern.test(pinDigits);
            //console.log(pinDigits);
            //console.log(result);
            if (!result && pinDigits.length > 0) {
                errMsg = "Your PIN should contain numbers only, four digits.";
                //return false;
            }
            //Loop i
            for (var i = 0; i <= (pinLen - 2); i++) {
                //console.log(pinDigits[i] + " vs " + pinDigits[i + 1]);
                if (parseInt(pinDigits[i]) == (parseInt(pinDigits[i + 1]) - 1)) {
                    errMsg = "Your PIN contains consecutive numbers e.g. ";
                    errMsg += pinDigits[i] + " and " + pinDigits[i + 1];
                    break;
                }
                if (parseInt(pinDigits[i]) == (parseInt(pinDigits[i + 1]) + 1)) {
                    errMsg = "Your PIN contains consecutive numbers e.g. ";
                    errMsg += pinDigits[i] + " and " + pinDigits[i + 1];
                    break;
                }
                // Loop j
                for (var j = (i + 1); j <= (pinLen - 1); j++) {
                    //console.log(pinDigits[i] + " vs " + pinDigits[j]);
                    if (parseInt(pinDigits[i]) == parseInt(pinDigits[j])) {
                        msgExtra = "Your PIN contains repeated digits e.g. " + pinDigits[i];
                        break;
                    }
                }
            }
​
            //Consolidate the error messages
            errMsg = msgExtra == "" ? errMsg : errMsg + "\n" + msgExtra;
            if (errMsg != "") {
                //swal("Pin Error", errMsg, "success");
                Swal.fire({
                    title: 'Pin Error',
                    icon: 'error',
                    html: errMsg,
                    position: 'top-end',
                    timer: 6000,
                    showCloseButton: false,
                    showCancelButton: false,
                    showConfirmButton: true,
                    focusConfirm: true,
                    confirmButtonText:
                        '<i class="fa fa-thumbs-down"></i> Retry Again!!',
                    confirmButtonAriaLabel: 'Thumbs down, retry!',
                    cancelButtonText:
                        '<i class="fa fa-thumbs-down"></i>',
                    cancelButtonAriaLabel: 'Thumbs down'
                })
            }
            else if (result) { pinSubmitBtn.disabled = false; }
​
        }
​
        //Add a click event listenere to the SHOW ME checkbox
        showMe.addEventListener("click", showOrHideMyPin);
        //Add a focusout event listener to the MY-PAY-PIN input field
        myPayPin.addEventListener("focusout", validatePinDigits);
​
    </script>
</body>
​
</html>















