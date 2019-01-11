(function ($) {
    'use strict';

    var nameInput = $("input#name");
    var emailInput = $("input#email");
    var phoneInput = $("input#phone");
    var timeInput = $("select#timeInput");
    var peopleInput = $("input#people");
    var dateInput = $("input#date");

    var issuesP = document.getElementById('issues');



        function IssueTracker() {
            this.issues = [];
        }
        IssueTracker.prototype = {
            add: function (issue) {
                this.issues.push(issue);
            },
            retrieve : function() {
                var message = "";
                switch (this.issues.length) {
                    case 0:
                        //do nothing because is already ""
                        break;
                    case 1:
                        message = "<b>Porfavor completa correctamente el siguiente campo:</b>  <br/><ul><li>" + this.issues[0]+"</li></ul>";
                        break;
                    default:
                        message = "<b>Porfavor completa correctamente los siguientes campos:</b> <br/><ul><li>" + this.issues.join("<br/></li><li>")+"</li></ul>";
                        break;
                }
                return message;
            }
        };

        $('#contactForm').submit(function ( event) {
            var name = nameInput.val();
            var email = emailInput.val();
            var phone = phoneInput.val();
            var time = timeInput.val();
            var people = peopleInput.val();
            var date = dateInput.val();
            console.log(time);

            var primeIssueTacker = new IssueTracker();

            function checkRequirements() {
                if(name.length <3){
                    primeIssueTacker.add("Nombre");
                }


                if (email == " ")
                {
                    primeIssueTacker.add("Correo");
                }


                if (isDateSelected(date) === false) {
                    primeIssueTacker.add("Colocar fecha");

                }


                if(people.length+1 <=1 ){
                    primeIssueTacker.add("Cantidad de personas");
                }
                if(phone.length <6){
                    primeIssueTacker.add("Teléfono");
                }
            };

            checkRequirements();

            var InputIssues = primeIssueTacker.retrieve();

            issuesP.innerHTML = InputIssues;


            if(InputIssues.length==0){
                postForm(event);
            }

            function postForm(event) {

                // Prevent spam click and default submit behaviour
                $("#btnSubmit").attr("disabled", true);
                event =  event || window.event;
                event.preventDefault();

                $.ajax({
                    url: "././php/contact_me.php",
                    type: "POST",
                    data: {
                        name: name,
                        phone: phone,
                        email: email,
                        date: date,
                        time: time,
                        people: people
                    },
                    cache: false,
                    success: function () {
                        // Enable button & show success message
                        $("#btnSubmit").attr("disabled", false);
                        $('#success').html("<div class='alert alert-success'>");
                        $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                        $('#success > .alert-success')
                            .append("<strong>Tu mensaje ha sido enviado. </strong>");
                        $('#success > .alert-success')
                            .append('</div>');

                        //clear all fields
                        alert("Tu reserva ha sido enviada. Pronto nos contactaremos contigo.");
                        $('#contactForm').trigger("reset");
                    },
                    error: function () {
                        // Fail message
                        $('#success').html("<div class='alert alert-danger'>");
                        $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                            .append("</button>");
                        $('#success > .alert-danger').append("<strong>Perdón " + name + ", no se ha enviado tu correo, intentalo más tarde porfavor!");
                        $('#success > .alert-danger').append('</div>');
                        $("#btnSubmit").attr("disabled", false);
                        //clear all fields
                        //$('#contactForm').trigger("reset");
                    }
                });

            }

            return false;
        });


        function isDateSelected(dateStr){
            var today =new Date();
            if (dateStr == " "){
                return false;
            } else if (dateStr < today) {
                return false;
            } else {
                return true;
            }
        }






        })(jQuery);
