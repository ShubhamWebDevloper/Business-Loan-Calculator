<?php
/*
Plugin Name: Business Loan Calculator
Description: This is a Business Loan Calculator plugin for WordPress. With this plugin you can check monthly and annual payments for a business loan in details. Shortcode [loan_calculator]
Version: 1.0
Author: Shubham Verma
*/

function enqueue__bloan_plugin_assets() {
    // Enqueue the JavaScript file
    wp_enqueue_script('loan-script', plugin_dir_url(__FILE__) . '/assets/js/b_loan_calculator_script.js', array('jquery'), '1.0', true);

    // Enqueue the CSS file
    wp_enqueue_style('loan-styles', plugin_dir_url(__FILE__) . '/assets/css/business_loan_cal_style.css', array(), '1.0');
}

add_action('wp_enqueue_scripts', 'enqueue__bloan_plugin_assets');


// Loan Calculator
function loan_calculator_func()
{
    ob_start();
    ?>
    <div id="loan-calculator">
        <div class="loan-calculator-header">
            <h2>Loan Calculator</h2>
            <p>Calculate the costs and payments of a business loan.</p>
        </div>
        <div class="loan-calculator-field">
            <div class="loan-amount">
                <label for="loan-amount"><b>Loan Amount ($):</b></label>
                <input type="number" id="loan-amount" value="50000"><br><br>
            </div>
            <div class="loan-term">
                <div class="loan-term-field">
                    <label for="loan-term"><b>Loan Term:</b></label>
                    <input type="number" id="loan-term" value="5">
                </div>
                <div class="select-unit">
                    <select id="term-unit">
                        <option value="years">Years</option>
                        <option value="months">Months</option>                        
                    </select><br><br>
                </div>
            </div>
            <div class="apr">
                <label for="apr"><b>APR (%):</b></label>
                <input type="number" step="0.01" id="apr" value="5"><br><br>
            </div>
        </div>
        <div class="clc-btn" style="text-align:center;">
            <button id="calculate">Calculate</button>
        </div>

        <div class="sfs-total-cost-wrapper" style="text-align: center;">
            <div class="total-cost-title">
                <h3><b>Total Cost</b></h3>
            </div>
            <div class="total-cost-amaunt">
                <div id="result">
                    <h1><span class="total-amount-paid">$56613.70</span></h1>
                    <div class="inner-result">
                        <div>
                            <p>Monthly Payment: </p>
                        </div>
                        <div><span class="monthly-payment">$943.56</span></div>
                    </div>
                    <div class="inner-result">
                        <div>
                            <p>Total Interest: </p>
                        </div>
                        <div><span class="total-interest">$6613.70</span></div>
                    </div>
                </div>
            </div>
            <div class="tc-graph-btn">
                <a href="javascript:void(0);" class="show-all-details"> Show Amortization Schedule <i class="fa fa-chevron-down"></i></a>
            </div>
        </div>

        <div class="show-all-details-toggle" style="display: none;">
            <div class="sfs-graph-wrapper">
                <div id="result" class="result-wrapper">
                    <div class="inner-result">
                        <div class="result-data">
                            <h3>Monthly Payment </h3>
                        </div>
                        <div class="month-pricing">
                            <span class="monthly-payment">$943.56</span>
                            <span class="sub-title">(Before taxes and fees)</span>
                        </div>
                    </div>
                    <div class="inner-result">
                        <div class="result-data">
                            <h3>Total Interest</h3>
                        </div>
                        <div><span class="total-interest">$6,613.70</span></div>
                    </div>
                    <div class="inner-result">
                        <div class="result-data">
                            <h3>Total Amount Paid </h3>
                        </div>
                        <div class="month-pricing">
                            <span class="total-amount-paid">$56,613.70</span>
                            <span class="sub-title">Over the loan term</span>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="schedule-secton">
                <h3> Annnual Amortization Schedule</h3>
                <div class="schedule-tab">
                    <a class="schedule-tablinks active" onclick="openSchedule(event, 'annuale-schedule')">Payment Schedule</a>
                    <a class="schedule-tablinks" onclick="openSchedule(event, 'monthly-schedule')">Monthly Schedule</a>
                </div>
                <div id="annuale-schedule" class="tabcontent" style="display: block;">
                    <div id="schedule">
                        <table>
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Beginning Balance</th>
                                    <th>Interest</th>
                                    <th>Principal</th>
                                    <th>Ending Balance</th>
                                </tr>
                            </thead>
                            <tbody id="annual-schedule-body"></tbody>
                        </table>
                    </div>
                </div>

                <div id="monthly-schedule" class="tabcontent">
                    <div id="monthly-schedule">
                        <table>
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Beginning Balance</th>
                                    <th>Interest</th>
                                    <th>Principal</th>
                                    <th>Ending Balance</th>
                                </tr>
                            </thead>
                            <tbody id="monthly-schedule-body"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        return $content;
}
add_shortcode('loan_calculator', 'loan_calculator_func');
