function openSchedule(evt, scheduleTerm) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {                    
        tablinks[i].className = tablinks[i].className.replace(" active", " ");
    }
    document.getElementById(scheduleTerm).style.display = "block";
    evt.currentTarget.className += " active";
}

jQuery('.show-all-details').click(function(){
    jQuery(this).toggleClass('arrow-change');

    jQuery('.show-all-details-toggle').slideToggle();
    jQuery('#calculate').click();
})

jQuery(".schedule-tab a").click(function() {
    jQuery(".schedule-tablinks").removeClass("active");
    jQuery(this).addClass("active");
});

jQuery(document).ready(function () {
    jQuery("#calculate").click(function () {
        var principal = parseFloat(jQuery("#loan-amount").val());
        var term = parseInt(jQuery("#loan-term").val());
        var termUnit = jQuery("#term-unit").val();
        var apr = parseFloat(jQuery("#apr").val());

        if (!isNaN(principal) && !isNaN(term) && !isNaN(apr)) {
            if (termUnit === "years") {
                term *= 12; // Convert years to months
            }

            var monthlyRate = (apr / 100) / 12;
            var monthlyPayment = principal * (monthlyRate * Math.pow(1 + monthlyRate, term)) / (Math.pow(1 + monthlyRate, term) - 1);
            var totalInterest = (monthlyPayment * term) - principal;
            var totalAmountPaid = principal + totalInterest;

            jQuery(".monthly-payment").text("$" + monthlyPayment.toFixed(2));
            jQuery(".total-interest").text("$" + totalInterest.toFixed(2));
            jQuery(".total-amount-paid").text("$" + totalAmountPaid.toFixed(2));
            
            
            // Generate annual payment schedule
            var annualScheduleBody = jQuery("#annual-schedule-body");
            annualScheduleBody.empty();

            var balance = principal;
            var year = 1;

            while (balance > 0) {
                var annualInterestPaid = 0;
                var annualPrincipalPaid = 0;
                var yearEndingBalance = balance;

                for (var month = 1; month <= 12; month++) {
                    var monthlyInterestPayment = yearEndingBalance * monthlyRate;
                    var monthlyPrincipalPayment = monthlyPayment - monthlyInterestPayment;
                    yearEndingBalance -= monthlyPrincipalPayment;

                    annualInterestPaid += monthlyInterestPayment;
                    annualPrincipalPaid += monthlyPrincipalPayment;
                }

                annualScheduleBody.append(
                    "<tr>" +
                    "<td>" + year + "</td>" +
                    "<td>$" + formatNumber(balance) + "</td>" +
                    "<td>$" + formatNumber(annualInterestPaid) + "</td>" +
                    "<td>$" + formatNumber(annualPrincipalPaid) + "</td>" +
                    "<td>$" + formatNumber(yearEndingBalance) + "</td>" +
                    "</tr>"
                );

                balance = yearEndingBalance;
                year++;
            }
            
            // Generate monthly payment schedule
            var monthlyScheduleBody = jQuery("#monthly-schedule-body");
            monthlyScheduleBody.empty();

            var monthlyBalance = principal;
            var month = 1;

            while (monthlyBalance > 0) {
                var monthlyInterestPayment = monthlyBalance * monthlyRate;
                var monthlyPrincipalPayment = monthlyPayment - monthlyInterestPayment;
                var monthlyEndingBalance = monthlyBalance - monthlyPrincipalPayment;

                monthlyScheduleBody.append(
                    "<tr>" +
                    "<td>" + month + "</td>" +
                    "<td>$" + formatNumber(monthlyBalance) + "</td>" +
                    "<td>$" + formatNumber(monthlyInterestPayment) + "</td>" +
                    "<td>$" + formatNumber(monthlyPrincipalPayment) + "</td>" +
                    "<td>$" + formatNumber(monthlyEndingBalance) + "</td>" +
                    "</tr>"
                );

                monthlyBalance = monthlyEndingBalance;
                month++;
            }
        } else {
            alert("Please enter valid numbers for all fields.");
        }
    });
});

function formatNumber(number) {
    return (number === 0) ? '0.00' : number.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
        
