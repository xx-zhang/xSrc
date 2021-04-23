<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>系统发生错误</title>
<link href="//cdn.bootcss.com/bootstrap/4.0.0-alpha.5/css/bootstrap.css" rel="stylesheet">
<style type="text/css">
*{ padding: 0; margin: 0; }
html{ overflow-y: scroll; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px; }
img{ border: 0; }
.error{ padding: 24px 48px; }
.face{ font-size: 100px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
h1{ font-size: 32px; line-height: 48px; }
.error .content{ padding-top: 10px}
.error .info{ margin-bottom: 12px; }
.error .info .title{ margin-bottom: 3px; }
.error .info .title h3{ color: #000; font-weight: 700; font-size: 16px; }
.error .info .text{ line-height: 24px; }
.copyright{ padding: 12px 48px; color: #999; }
.copyright a{ color: #000; text-decoration: none; }

.bd-booticon {
  display: block;
  width: 9rem;
  height: 9rem;
  font-size: 6.5rem;
  line-height: 9rem;
  color: #fff;
  text-align: center;
  cursor: default;
  background-color: #563d7c;
  border-radius: 15%;
}

.bd-booticon.inverse {
  color: #563d7c;
  background-color: #fff;
}

.bd-booticon.outline {
  background-color: transparent;
  border: 1px solid #cdbfe3;
}

.bd-navbar {
  padding-right: 0;
  padding-left: 0;
}

.bd-navbar .navbar-nav .nav-link {
  color: #8e869d;
}

.bd-navbar .navbar-nav .nav-link.active, .bd-navbar .navbar-nav .nav-link:hover, .bd-navbar .navbar-nav .nav-link:focus {
  color: #373a3c;
  background-color: transparent;
}

.bd-navbar .navbar-nav .nav-link.active {
  font-weight: 500;
  color: #121314;
}

.bd-navbar .dropdown-menu {
  font-size: inherit;
}

@media (max-width: 767px) {
  .bd-navbar .nav-link {
    float: none;
  }
  .bd-navbar .nav-link + .nav-link {
    margin-left: 0;
  }
}

.bd-masthead {
  position: relative;
  padding: 3rem 15px 2rem;
  color: #cdbfe3;
  text-align: center;
  background-image: -webkit-linear-gradient(315deg, #271b38, #563d7c, #7952b3);
  background-image: -o-linear-gradient(315deg, #271b38, #563d7c, #7952b3);
  background-image: linear-gradient(135deg, #271b38, #563d7c, #7952b3);
}

.bd-masthead .bd-booticon {
  margin: 0 auto 2rem;
  color: #cdbfe3;
  border-color: #cdbfe3;
}

.bd-masthead h1 {
  font-weight: 300;
  line-height: 1;
}

.bd-masthead .lead {
  margin-right: auto;
  margin-bottom: 2rem;
  margin-left: auto;
  font-size: 1.25rem;
  color: #fff;
}

.bd-masthead .version {
  margin-top: -1rem;
  margin-bottom: 2rem;
}

.bd-masthead .btn {
  width: 100%;
  padding: 1rem 2rem;
  font-size: 1.25rem;
  font-weight: 500;
  color: #ffe484;
  border-color: #ffe484;
}

.bd-masthead .btn:hover {
  color: #2a2730;
  background-color: #ffe484;
  border-color: #ffe484;
}

.bd-masthead .carbonad {
  margin-bottom: -2rem !important;
}

@media (min-width: 576px) {
  .bd-masthead {
    padding-top: 8rem;
    padding-bottom: 2rem;
  }
  .bd-masthead .btn {
    width: auto;
  }
  .bd-masthead .carbonad {
    margin-bottom: 0 !important;
  }
}

@media (min-width: 768px) {
  .bd-masthead {
    padding-bottom: 4rem;
  }
  .bd-masthead .bd-header {
    margin-bottom: 4rem;
  }
  .bd-masthead h1 {
    font-size: 4rem;
  }
  .bd-masthead .lead {
    font-size: 1.5rem;
  }
  .bd-masthead .carbonad {
    margin-top: 3rem !important;
  }
}

@media (min-width: 992px) {
  .bd-masthead .lead {
    width: 85%;
    font-size: 2rem;
  }
}

.bd-featurette {
  padding-top: 3rem;
  padding-bottom: 3rem;
  font-size: 1rem;
  line-height: 1.5;
  color: #555;
  text-align: center;
  background-color: #fff;
  border-top: 1px solid #eee;
}

.bd-featurette .highlight {
  text-align: left;
}

.bd-featurette .lead {
  margin-right: auto;
  margin-bottom: 2rem;
  margin-left: auto;
  font-size: 1rem;
  text-align: center;
}

@media (min-width: 576px) {
  .bd-featurette {
    text-align: left;
  }
}

@media (min-width: 768px) {
  .bd-featurette .col-sm-6:first-child {
    padding-right: 45px;
  }
  .bd-featurette .col-sm-6:last-child {
    padding-left: 45px;
  }
}

.bd-featurette-title {
  margin-bottom: .5rem;
  font-size: 2rem;
  font-weight: normal;
  color: #333;
  text-align: center;
}

.half-rule {
  width: 6rem;
  margin: 2.5rem auto;
}

@media (min-width: 576px) {
  .half-rule {
    margin-right: 0;
    margin-left: 0;
  }
}

.bd-featurette h4 {
  margin-top: 1rem;
  margin-bottom: .5rem;
  font-weight: normal;
  color: #333;
}

.bd-featurette-img {
  display: block;
  margin-bottom: 1.25rem;
  color: #333;
}

.bd-featurette-img:hover {
  color: #0275d8;
  text-decoration: none;
}

.bd-featurette-img img {
  display: block;
  margin-bottom: 1rem;
}

@media (min-width: 480px) {
  .bd-featurette .img-fluid {
    margin-top: 2rem;
  }
}

@media (min-width: 768px) {
  .bd-featurette {
    padding-top: 6rem;
    padding-bottom: 6rem;
  }
  .bd-featurette-title {
    font-size: 2.5rem;
  }
  .bd-featurette-title + .lead {
    font-size: 1.5rem;
  }
  .bd-featurette .lead {
    max-width: 80%;
  }
  .bd-featurette .img-fluid {
    margin-top: 0;
  }
}

.bd-featured-sites {
  margin-right: -1px;
  margin-left: -1px;
}

.bd-featured-sites .col-xs-6 {
  padding: 1px;
}

.bd-featured-sites .img-fluid {
  margin-top: 0;
}

@media (min-width: 768px) {
  .bd-featured-sites .col-sm-3:first-child img {
    border-top-left-radius: .25rem;
    border-bottom-left-radius: .25rem;
  }
  .bd-featured-sites .col-sm-3:last-child img {
    border-top-right-radius: .25rem;
    border-bottom-right-radius: .25rem;
  }
}

#carbonads {
  display: block;
  padding: 15px 15px 15px 160px;
  margin: 50px -15px 0;
  overflow: hidden;
  font-size: 13px;
  line-height: 1.5;
  text-align: left;
  border: solid #866ab3;
  border-width: 1px 0 0;
}

#carbonads a {
  color: #fff;
  text-decoration: none;
}

@media (min-width: 576px) {
  #carbonads {
    max-width: 330px;
    margin: 50px auto 0;
    border-width: 1px;
    border-radius: 4px;
  }
}

@media (min-width: 992px) {
  #carbonads {
    position: absolute;
    top: 0;
    right: 15px;
    margin-top: 0;
  }
  .bd-masthead #carbonads {
    position: static;
  }
}

.carbon-img {
  float: left;
  margin-left: -145px;
}

.carbon-poweredby {
  display: block;
  color: #cdbfe3 !important;
}

.bd-content > table {
  display: block;
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  overflow-y: auto;
}

.bd-content > table > thead > tr > th,
.bd-content > table > thead > tr > td,
.bd-content > table > tbody > tr > th,
.bd-content > table > tbody > tr > td,
.bd-content > table > tfoot > tr > th,
.bd-content > table > tfoot > tr > td {
  padding: 0.75rem;
  vertical-align: top;
  border: 1px solid #eceeef;
}

.bd-content > table > thead > tr > th > p:last-child,
.bd-content > table > thead > tr > td > p:last-child,
.bd-content > table > tbody > tr > th > p:last-child,
.bd-content > table > tbody > tr > td > p:last-child,
.bd-content > table > tfoot > tr > th > p:last-child,
.bd-content > table > tfoot > tr > td > p:last-child {
  margin-bottom: 0;
}

.bd-content > table td:first-child > code {
  white-space: nowrap;
}

.bd-content > h2:not(:first-child) {
  margin-top: 3rem;
}

.bd-content > h3 {
  margin-top: 1.5rem;
}

.bd-content > ul li,
.bd-content > ol li {
  margin-bottom: .25rem;
}

@media (min-width: 576px) {
  .bd-title {
    font-size: 3rem;
  }
  .bd-title + p {
    font-size: 1.25rem;
    font-weight: 300;
  }
}

#markdown-toc > li:first-child {
  display: none;
}

#markdown-toc ul {
  padding-left: 2rem;
  margin-top: .25rem;
  margin-bottom: .25rem;
}

.bd-pageheader {
  padding: 2rem 15px;
  margin-bottom: 1.5rem;
  color: #cdbfe3;
  text-align: center;
  background-color: #563d7c;
}

.bd-pageheader .container {
  position: relative;
}

.bd-pageheader h1 {
  font-size: 3rem;
  font-weight: normal;
  color: #fff;
}

.bd-pageheader p {
  margin-bottom: 0;
  font-size: 1.25rem;
  font-weight: 300;
}

@media (min-width: 576px) {
  .bd-pageheader {
    padding-top: 4rem;
    padding-bottom: 4rem;
    margin-bottom: 3rem;
    text-align: left;
  }
  .bd-pageheader .carbonad {
    margin: 2rem 0 0 !important;
  }
}

@media (min-width: 768px) {
  .bd-pageheader h1 {
    font-size: 4rem;
  }
  .bd-pageheader p {
    font-size: 1.5rem;
  }
}

@media (min-width: 992px) {
  .bd-pageheader h1,
  .bd-pageheader p {
    margin-right: 380px;
  }
  .bd-pageheader .carbonad {
    position: absolute;
    top: 0;
    right: .75rem;
    margin: 0 !important;
  }
}

#skippy {
  display: block;
  padding: 1em;
  color: #fff;
  background-color: #563d7c;
  outline: 0;
}

#skippy .skiplink-text {
  padding: .5em;
  outline: 1px dotted;
}

@media (min-width: 768px) {
  .bd-sidebar {
    padding-left: 1rem;
  }
}

.bd-search {
  position: relative;
  margin-bottom: 1.5rem;
}

.bd-search .form-control {
  height: 2.45rem;
  padding-top: .4rem;
  padding-bottom: .4rem;
  background-color: #fafafa;
}

.bd-search .form-control:focus {
  background-color: #fff;
}

.bd-search-results {
  right: 0;
  display: block;
  padding: 0;
  overflow: hidden;
  font-size: .9rem;
}

.bd-search-results:empty {
  display: none;
}

.bd-search-results .dropdown-item {
  padding-right: .75rem;
  padding-left: .75rem;
}

.bd-search-results .dropdown-item:first-child {
  margin-top: .25rem;
}

.bd-search-results .dropdown-item:last-child {
  margin-bottom: .25rem;
}

.bd-search-results .no-results {
  padding: .75rem 1rem;
  color: #7a7a7a;
  text-align: center;
  white-space: normal;
}

.bd-sidenav {
  display: none;
}

.bd-toc-link {
  display: block;
  padding: .25rem .75rem;
  color: #55595c;
}

.bd-toc-link:hover,
.bd-toc-link:focus {
  color: #0275d8;
  text-decoration: none;
}

.active > .bd-toc-link {
  font-weight: 500;
  color: #373a3c;
}

.active > .bd-sidenav {
  display: block;
}

.bd-toc-item.active {
  margin-top: 1rem;
  margin-bottom: 1rem;
}

.bd-toc-item:first-child {
  margin-top: 0;
}

.bd-toc-item:last-child {
  margin-bottom: 2rem;
}

.bd-sidebar .nav > li > a {
  display: block;
  padding: .25rem .75rem;
  font-size: 90%;
  color: #99979c;
}

.bd-sidebar .nav > li > a:hover,
.bd-sidebar .nav > li > a:focus {
  color: #0275d8;
  text-decoration: none;
  background-color: transparent;
}

.bd-sidebar .nav > .active > a,
.bd-sidebar .nav > .active:hover > a,
.bd-sidebar .nav > .active:focus > a {
  font-weight: 500;
  color: #373a3c;
  background-color: transparent;
}

.bd-footer {
  padding: 4rem 0;
  margin-top: 4rem;
  font-size: 85%;
  text-align: center;
  background-color: #f7f7f7;
}

.bd-footer a {
  font-weight: 500;
  color: #55595c;
}

.bd-footer a:hover {
  color: #0275d8;
}

.bd-footer p {
  margin-bottom: 0;
}

@media (min-width: 576px) {
  .bd-footer {
    text-align: left;
  }
}

.bd-footer-links {
  padding-left: 0;
  margin-bottom: 1rem;
}

.bd-footer-links li {
  display: inline-block;
}

.bd-footer-links li + li {
  margin-left: 1rem;
}

.bd-example-row .row + .row {
  margin-top: 1rem;
}

.bd-example-row .row > .col,
.bd-example-row .row > [class^="col-"] {
  padding-top: .75rem;
  padding-bottom: .75rem;
  background-color: rgba(86, 61, 124, 0.15);
  border: 1px solid rgba(86, 61, 124, 0.2);
}

.bd-example-row .flex-items-xs-top,
.bd-example-row .flex-items-xs-middle,
.bd-example-row .flex-items-xs-bottom {
  min-height: 6rem;
  background-color: rgba(255, 0, 0, 0.1);
}

.bd-example-row-flex-cols .row {
  min-height: 10rem;
  background-color: rgba(255, 0, 0, 0.1);
}

.bd-example-container {
  min-width: 16rem;
  max-width: 25rem;
  margin-right: auto;
  margin-left: auto;
}

.bd-example-container-header {
  height: 3rem;
  margin-bottom: .5rem;
  background-color: #daeeff;
  border-radius: .25rem;
}

.bd-example-container-sidebar {
  float: right;
  width: 4rem;
  height: 8rem;
  background-color: #fae3c4;
  border-radius: .25rem;
}

.bd-example-container-body {
  height: 8rem;
  margin-right: 4.5rem;
  background-color: #957bbe;
  border-radius: .25rem;
}

.bd-example-container-fluid {
  max-width: none;
}

.bd-example {
  position: relative;
  padding: 1rem;
  margin: 1rem -1rem;
  border: solid #f7f7f9;
  border-width: .2rem 0 0;
}

.bd-example::after {
  content: "";
  display: table;
  clear: both;
}

@media (min-width: 576px) {
  .bd-example {
    padding: 1.5rem;
    margin-right: 0;
    margin-bottom: 0;
    margin-left: 0;
    border-width: .2rem;
  }
}

.bd-example + .highlight,
.bd-example + .clipboard + .highlight {
  margin-top: 0;
}

.bd-example + p {
  margin-top: 2rem;
}

.bd-example .container {
  width: auto;
}

.bd-example > .form-control + .form-control {
  margin-top: .5rem;
}

.bd-example > .card {
  max-width: 20rem;
}

.bd-example > .nav + .nav,
.bd-example > .alert + .alert,
.bd-example > .navbar + .navbar,
.bd-example > .progress + .progress,
.bd-example > .progress + .btn {
  margin-top: 1rem;
}

.bd-example > .dropdown-menu:first-child {
  position: static;
  display: block;
}

.bd-example > .form-group:last-child {
  margin-bottom: 0;
}

.bd-example > .close {
  float: none;
}

.bd-example-type .table .type-info {
  color: #999;
  vertical-align: middle;
}

.bd-example-type .table td {
  padding: 1rem 0;
  border-color: #eee;
}

.bd-example-type .table tr:first-child td {
  border-top: 0;
}

.bd-example-type h1,
.bd-example-type h2,
.bd-example-type h3,
.bd-example-type h4,
.bd-example-type h5,
.bd-example-type h6 {
  margin: 0;
}

.bd-example-bg-classes p {
  padding: 1rem;
}

.bd-example > img + img {
  margin-left: .5rem;
}

.bd-example > .btn-group {
  margin-top: .25rem;
  margin-bottom: .25rem;
}

.bd-example > .btn-toolbar + .btn-toolbar {
  margin-top: .5rem;
}

.bd-example-control-sizing select,
.bd-example-control-sizing input[type="text"] + input[type="text"] {
  margin-top: .5rem;
}

.bd-example-form .input-group {
  margin-bottom: .5rem;
}

.bd-example > textarea.form-control {
  resize: vertical;
}

.bd-example > .list-group {
  max-width: 400px;
}

.bd-example .navbar-fixed-top {
  position: static;
  margin: -1rem -1rem 1rem;
}

.bd-example .navbar-fixed-bottom {
  position: static;
  margin: 1rem -1rem -1rem;
}

@media (min-width: 576px) {
  .bd-example .navbar-fixed-top {
    margin: -1.5rem -1.5rem 1rem;
  }
  .bd-example .navbar-fixed-bottom {
    margin: 1rem -1.5rem -1.5rem;
  }
}

.bd-example .pagination {
  margin-top: .5rem;
  margin-bottom: .5rem;
}

.bd-example-modal {
  background-color: #f5f5f5;
}

.bd-example-modal .modal {
  position: relative;
  top: auto;
  right: auto;
  bottom: auto;
  left: auto;
  z-index: 1;
  display: block;
}

.bd-example-modal .modal-dialog {
  left: auto;
  margin-right: auto;
  margin-left: auto;
}

.bd-example > .dropdown > .dropdown-toggle {
  float: left;
}

.bd-example > .dropdown > .dropdown-menu {
  position: static;
  display: block;
  margin-bottom: .25rem;
  clear: left;
}

.bd-example-tabs .nav-tabs {
  margin-bottom: 1rem;
}

.bd-example-tooltips {
  text-align: center;
}

.bd-example-tooltips > .btn {
  margin-top: .25rem;
  margin-bottom: .25rem;
}

.bd-example-popover-static {
  padding-bottom: 1.5rem;
  background-color: #f9f9f9;
}

.bd-example-popover-static .popover {
  position: relative;
  display: block;
  float: left;
  width: 260px;
  margin: 1.25rem;
}

.tooltip-demo a {
  white-space: nowrap;
}

.bd-example-tooltip-static .tooltip {
  position: relative;
  display: inline-block;
  margin: 10px 20px;
  opacity: 1;
}

.scrollspy-example {
  position: relative;
  height: 200px;
  margin-top: .5rem;
  overflow: auto;
}

.bd-example > .bg-primary:not(.navbar),
.bd-example > .bg-success:not(.navbar),
.bd-example > .bg-info:not(.navbar),
.bd-example > .bg-warning:not(.navbar),
.bd-example > .bg-danger:not(.navbar),
.bd-example > .bg-inverse:not(.navbar) {
  padding: .5rem;
  margin-top: .5rem;
  margin-bottom: .5rem;
}

.highlight {
  padding: 1rem;
  margin: 1rem -15px;
  background-color: #f7f7f9;
}

@media (min-width: 576px) {
  .highlight {
    padding: 1.5rem;
    margin-right: 0;
    margin-left: 0;
  }
}

.highlight pre {
  padding: 0;
  margin-top: 0;
  margin-bottom: 0;
  background-color: transparent;
  border: 0;
}

.highlight pre code {
  font-size: inherit;
  color: #373a3c;
}

.table-responsive .highlight pre {
  white-space: normal;
}

.bd-table th small,
.responsive-utilities th small {
  display: block;
  font-weight: normal;
  color: #999;
}

.responsive-utilities tbody th {
  font-weight: normal;
}

.responsive-utilities td {
  text-align: center;
}

.responsive-utilities .is-visible {
  color: #468847;
  background-color: #dff0d8 !important;
}

.responsive-utilities .is-hidden {
  color: #ccc;
  background-color: #f9f9f9 !important;
}

.responsive-utilities-test {
  margin-top: .25rem;
}

.responsive-utilities-test .col-xs-6 {
  margin-top: .5rem;
  margin-bottom: .5rem;
}

.responsive-utilities-test span {
  display: block;
  padding: 1rem .5rem;
  font-size: 1rem;
  font-weight: bold;
  line-height: 1.1;
  text-align: center;
  border-radius: .25rem;
}

.visible-on .col-xs-6 > .not-visible,
.hidden-on .col-xs-6 > .not-visible {
  color: #999;
  border: 1px solid #ddd;
}

.visible-on .col-xs-6 .visible,
.hidden-on .col-xs-6 .visible {
  color: #468847;
  background-color: #dff0d8;
  border: 1px solid #d6e9c6;
}

@media (max-width: 575px) {
  .hidden-xs-only {
    display: none !important;
  }
}

@media (min-width: 576px) and (max-width: 767px) {
  .hidden-sm-only {
    display: none !important;
  }
}

@media (min-width: 768px) and (max-width: 991px) {
  .hidden-md-only {
    display: none !important;
  }
}

@media (min-width: 992px) and (max-width: 1199px) {
  .hidden-lg-only {
    display: none !important;
  }
}

@media (min-width: 1200px) {
  .hidden-xl-only {
    display: none !important;
  }
}

.btn-bs {
  font-weight: 500;
  color: #7952b3;
  border-color: #7952b3;
}

.btn-bs:hover, .btn-bs:focus, .btn-bs:active {
  color: #fff;
  background-color: #7952b3;
  border-color: #7952b3;
}

.bd-callout {
  padding: 1.25rem;
  margin-top: 1.25rem;
  margin-bottom: 1.25rem;
  border: 1px solid #eee;
  border-left-width: .25rem;
  border-radius: .25rem;
}

.bd-callout h4 {
  margin-top: 0;
  margin-bottom: .25rem;
}

.bd-callout p:last-child {
  margin-bottom: 0;
}

.bd-callout code {
  border-radius: .25rem;
}

.bd-callout + .bd-callout {
  margin-top: -.25rem;
}

.bd-callout-info {
  border-left-color: #5bc0de;
}

.bd-callout-info h4 {
  color: #5bc0de;
}

.bd-callout-warning {
  border-left-color: #f0ad4e;
}

.bd-callout-warning h4 {
  color: #f0ad4e;
}

.bd-callout-danger {
  border-left-color: #d9534f;
}

.bd-callout-danger h4 {
  color: #d9534f;
}

.bd-examples .img-thumbnail {
  margin-bottom: .75rem;
}

.bd-examples h4 {
  margin-bottom: .25rem;
}

.bd-examples p {
  margin-bottom: 1.25rem;
}

@media (max-width: 480px) {
  .bd-examples {
    margin-right: -.75rem;
    margin-left: -.75rem;
  }
  .bd-examples > [class^="col-"] {
    padding-right: .75rem;
    padding-left: .75rem;
  }
}

.bd-team {
  margin-bottom: 1.5rem;
}

.bd-team .team-member {
  line-height: 2rem;
  color: #555;
}

.bd-team .team-member:hover {
  color: #333;
  text-decoration: none;
}

.bd-team .github-btn {
  float: right;
  width: 180px;
  height: 1.25rem;
  margin-top: .25rem;
  border: 0;
}

.bd-team img {
  float: left;
  width: 2rem;
  margin-right: .5rem;
  border-radius: .25rem;
}

.bd-browser-bugs td p {
  margin-bottom: 0;
}

.bd-browser-bugs th:first-child {
  width: 18%;
}

.bd-brand-logos {
  display: table;
  width: 100%;
  margin-bottom: 1rem;
  overflow: hidden;
  color: #563d7c;
  background-color: #f9f9f9;
  border-radius: .25rem;
}

.bd-brand-item {
  padding: 4rem 0;
  text-align: center;
}

.bd-brand-item + .bd-brand-item {
  border-top: 1px solid #fff;
}

.bd-brand-logos .inverse {
  color: #fff;
  background-color: #563d7c;
}

.bd-brand-item h1,
.bd-brand-item h3 {
  margin-top: 0;
  margin-bottom: 0;
}

.bd-brand-item .bd-booticon {
  margin-right: auto;
  margin-left: auto;
}

@media (min-width: 768px) {
  .bd-brand-item {
    display: table-cell;
    width: 1%;
  }
  .bd-brand-item + .bd-brand-item {
    border-top: 0;
    border-left: 1px solid #fff;
  }
  .bd-brand-item h1 {
    font-size: 4rem;
  }
}

.color-swatches {
  margin: 0 -5px;
  overflow: hidden;
}

.color-swatch {
  float: left;
  width: 4rem;
  height: 4rem;
  margin-right: .25rem;
  margin-left: .25rem;
  border-radius: .25rem;
}

@media (min-width: 768px) {
  .color-swatch {
    width: 6rem;
    height: 6rem;
  }
}

.color-swatches .bd-purple {
  background-color: #563d7c;
}

.color-swatches .bd-purple-light {
  background-color: #cdbfe3;
}

.color-swatches .bd-purple-lighter {
  background-color: #e5e1ea;
}

.color-swatches .bd-gray {
  background-color: #f9f9f9;
}

.bd-clipboard {
  position: relative;
  display: none;
  float: right;
}

.bd-clipboard + .highlight {
  margin-top: 0;
}

.btn-clipboard {
  position: absolute;
  top: .5rem;
  right: .5rem;
  z-index: 10;
  display: block;
  padding: .25rem .5rem;
  font-size: 75%;
  color: #818a91;
  cursor: pointer;
  background-color: transparent;
  border-radius: .25rem;
}

.btn-clipboard:hover {
  color: #fff;
  background-color: #027de7;
}

@media (min-width: 768px) {
  .bd-clipboard {
    display: block;
  }
}

.language-bash::before {
  color: #009;
  content: "$ ";
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.language-powershell::before {
  color: #009;
  content: "PM> ";
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.anchorjs-link {
  color: inherit;
}

@media (max-width: 480px) {
  .anchorjs-link {
    display: none;
  }
}

*:hover > .anchorjs-link {
  opacity: .75;
  -webkit-transition: color .16s linear;
  -o-transition: color .16s linear;
  transition: color .16s linear;
}

*:hover > .anchorjs-link:hover,
.anchorjs-link:focus {
  text-decoration: none;
  opacity: 1;
}
</style>
</head>
<body>
<div class="error">
<p class="face">>.<</p>
<h1><?php echo strip_tags($e['message']);?></h1>
<div class="content">
<?php if(isset($e['file'])) {?>
	<div class="info">
		<div class="title">
			<h3>错误位置</h3>
		</div>
		<div class="text">
			<p>FILE: <?php echo $e['file'] ;?> &#12288;LINE: <?php echo $e['line'];?></p>
		</div>
	</div>
<?php }?>
<?php if(isset($e['trace'])) {?>
	<div class="info">
		<div class="title">
			<h3>TRACE</h3>
		</div>
		<div class="text">
			<p><?php echo nl2br($e['trace']);?></p>
		</div>
	</div>
<?php }?>
</div>
</div>
<footer class="bd-footer text-muted navbar-fixed-bottom">
  <div class="container">
  	<div style="float:left;">
		<ul class="bd-footer-links">
		  <li><a href="././././">回到首页</a></li>
		  <li><a href="javascript:window.history.back()">返回上一页</a></li>
		</ul>
		<p><a title="官方网站" href="https://security.tencent.com/xsrc">Powered By Tencent xSRC</a> <sup>1.0</sup> </p>
		<p>版本：v1.0.2. Code licensed GPL © Tencent</a>.</p>
	</div>
	<div style="float:right">
	  <img src="data:image/png;base64,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" style="float:right;width:50%;height:50%;"></img>
	</div>
  </div>
</footer>
</body>
</html>
