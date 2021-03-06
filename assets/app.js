/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';
import $ from 'jquery'

let $container = $('.buttons')
let $currentNumber = $('.current-number')
$container.find('a').on('click', function(e) {
    e.preventDefault();
    let $link = $(e.currentTarget);
    $.ajax({
        url: '/' + $link.data('key'),
        method: 'POST'
    }).then(function(data) {
        $currentNumber.find('.number').text(data.calculator);
    })
})