import "./styles/app.css";
import "./styles/home.css"
import "./styles/forms.css";

const $ = require("jquery");
require("bootstrap");
require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');

$(document).ready(function() {
    $("[data-toggle='popover']").popover();
});