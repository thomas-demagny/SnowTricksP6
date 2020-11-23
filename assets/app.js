import "./styles/app.css";
//import "./styles/home.css";

const $ = require("jquery");
require("bootstrap");

$(document).ready(function() {
    $("[data-toggle='popover']").popover();
});