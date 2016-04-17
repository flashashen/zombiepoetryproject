/**
 *
 */

jQuery(document).ready(function($) {

    //$("#zombie-text").val("hello world");

    var requestTimer;
    var xhr;

//    $(document).on({
//        ajaxStart: function() {
//            $("#zombie-text").addClass("fa");
//            $("#zombie-text").addClass("fa-refresh");
//            $("#zombie-text").addClass("fa-spin");
//        },
//        ajaxStop: function() { $("#zombie-text").removeClass("loading"); }
//    });
//
//    // Adding Font Awsome spinner, hidden by default
//    $('img.ajax-loader').after('<i class="fa fa-refresh fa-spin ajax-loader-cusom" style="visibility: hidden"></i>');
//
//// Show new spinner on Send button click
//    $('.wpcf7-submit').on('click', function () {
//        $('.ajax-loader-cusom').css({ visibility: 'visible' });
//    });
//
//// Hide new spinner on result
//    $('div.wpcf7').on('wpcf7:invalid wpcf7:spam wpcf7:mailsent wpcf7:mailfailed', function () {
//        $('.ajax-loader-cusom').css({ visibility: 'hidden' });
//    });

    $("input[type=submit]").attr('disabled','disabled');
    $('#zombie-text-loading').hide();
    $('#zombie-text').show();


    // register the double click re-zombity handler
    //$("#zombieDiv").dblclick(function(){alert("sentence number is "
    //    + $(this).attr("data-sentence"));});

    $("#zombie-text").on('click', 'span',
        function (event) { ajax_zombify_sentence($(this).attr("data-sentence")) }
        //function(){alert("sentence number is " + $(this).attr("data-sentence"));}
    );



    $("#victim-text").bind("input propertychange", function (event) {

        // If it's the propertychange event, make sure it's the value that changed.
        if (window.event && event.type == "propertychange" && event.propertyName != "value")
            return;

        // Clear any previously set timer before setting a fresh one
        window.clearTimeout($(this).data("timeout"));
        $(this).data("timeout", setTimeout(function () {

            hide_zombie_div();

            //  via wp handler
            var incident = { 'victimText' : $("#victim-text").val() };
            var data = {
                'action': 'fetch_zombie_text',
                'incident': JSON.stringify(incident)
            };
            $.ajax({
                type: "POST",
                url: ajax_object.ajax_url,
                data: data,
                dataType: 'json',
                success: function (response) {
                    console.log('the value is' + response);
                    appendSentences($("#zombie-text"), response.zombie);
                    // Re-jsonify the response hoping for an assosiative array in php of artifacts to save as post meta
                    $("#zombie-artifacts").val(JSON.stringify(response));
                    $("#zombie-sentences").val(response.zombie)
                },
                complete: show_zombie_div
            });

            // why return false?
            return false;
        }, 1000));
    });
});

function hide_zombie_div(){

    //var target = document.getElementById('zombie-text')
    //var spinner = new Spinner(opts).spin(target);
    jQuery('#zombie-text-loading').show();
    jQuery('#zombie-text').hide();
    jQuery("input[type=submit]").attr('disabled','disabled');
}

function show_zombie_div(){
    //jQuery('.spin').spin('hide');
    jQuery('#zombie-text-loading').hide();
    jQuery('#zombie-text').show();
    jQuery("input[type=submit]").removeAttr('disabled');
}



function appendSentences(zombieDiv, sentences) {

    // first empty the element
    zombieDiv.empty();

    // then append each sentence
    jQuery(sentences).each(function (index, sentence) {
        var span = jQuery('<span class="zombie_text"></span>');
        span.append(sentence.text.replace(/(?:\r\n|\r|\n)/g, '<br />'));
        span.attr("data-sentence",index);
        zombieDiv.append(span);
    });
}

function ajax_zombify_sentence (sentence_number) {

    // Clear any previously set timer before setting a fresh one
    window.clearTimeout(jQuery(this).data("timeout"));
    jQuery(this).data("timeout", setTimeout(function () {

        hide_zombie_div();

        // Deserialize the incident to mark the selected sentence for another attack
        //var incident = null;
        var incident = JSON.parse(jQuery("#zombie-artifacts").val());
        incident.zombie[parseInt(sentence_number)].attack = true;
        var data = {
            'action': 'fetch_zombie_text',
            'incident': JSON.stringify(incident)
        };

        jQuery.ajax({
            type: "POST",
            url: ajax_object.ajax_url,
            data: data,
            dataType: 'json',
            success: function (response) {
                console.log('the value is' + response);
                appendSentences(jQuery("#zombie-text"), response.zombie);
                // Re-jsonify the response hoping for an assosiative array in php of artifacts to save as post meta
                jQuery("#zombie-artifacts").val(JSON.stringify(response));
                jQuery("#zombie-sentences").val(response.zombie)
            },
            complete: show_zombie_div
        });

        // why return false?
        return false;
    }, 1000));
};



