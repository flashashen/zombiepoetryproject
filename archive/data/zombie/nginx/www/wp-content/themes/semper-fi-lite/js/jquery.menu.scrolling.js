/*global jQuery */
/*!	
* menu.scrolling.js 1.1
*
* Added a class to the menu upon scrolling
*
* Copyright 2014, Eric Schwarz http://schwarttzy.com/
* Released under the WTFPL license 
* http://sam.zoy.org/wtfpl/
*
* Date: Thu Feb 26 10:33:00 2014 -0600
*/

( function( $ ) {
    
    $( document ).ready(function() {

        $( window ).scroll(function() {

            $( ".header" ).addClass( "small" );
        
            switchHeader(); }); });

function switchHeader(){

    if (document.documentElement.clientWidth <= 400){

        if ($(window).scrollTop() <= 65){

            $('.header').removeClass('small'); } }

    else if (document.documentElement.clientWidth <= 600){

        if ($(window).scrollTop() <= 90){

            $('.header').removeClass('small'); } }

    else if (document.documentElement.clientWidth <= 900){

        if ($(window).scrollTop() <= 118){

            $('.header').removeClass('small'); } }

    else {

        if ($(window).scrollTop() <= 140){

            $('.header').removeClass('small'); } } } } )( jQuery );