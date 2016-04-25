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


    /*
            On click select the sentence, displaying the Inspect bookends
     */
    $("#zombie-text").on('click', 'span.zombie_sentence',
        function (event) {

            if (!$(this).prop("selected")) {
                selectZombieSentence($(this));
            }
        }
    );

    /*
            If already selected and text received a click, rezombify the sentence
     */
    $("#zombie-text").on('click', 'span.zombie_sentence_text',
        function (event) {

            var parent = $(this).parent("span.zombie_sentence");
            if (parent.prop("selected")) {
                ajax_zombify_sentence(parent.attr("data-sentence"));
            }
        }
    );


    /*
            On A double click, rezombify the sentence
     */
    $("#zombie-text").on('dblclick', 'span.zombie_sentence',
        function (event) {
            ajax_zombify_sentence($(this).attr("data-sentence"))
        }
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



function appendSentences(zombieDiv, sentences, sentence_index) {

    // first empty the element
    zombieDiv.empty();

    // then append each sentence
    jQuery(sentences).each(function (index, sentence) {

        var sentenceSpan = jQuery('<span class="zombie_sentence"></span>');
        sentenceSpan.attr("data-sentence",index);

        sentenceSpan.append(buildInspectButton(sentence));

        var textSpan = jQuery('<span class="zombie_sentence_text"></span>');
        textSpan.append(sentence.text.replace(/(?:\r\n|\r|\n)/g, '<br />'));
        sentenceSpan.append(textSpan);

        sentenceSpan.append(buildInspectButton(sentence));


        zombieDiv.append(sentenceSpan);

        if (undefined != sentence_index && sentence_index == index){
            selectZombieSentence(sentenceSpan)
        }
    });
}


function selectZombieSentence(selectedSentenceSpan) {

    var textActions = selectedSentenceSpan.find('span.zombie_sentence_actions');

    if ("none" == textActions.css("display")) {

        // Reset background and remove buttons for all sentences
        allSentenceSpans = jQuery("span.zombie_sentence");
        allSentenceSpans.find("span.zombie_sentence_text").css({backgroundColor: "#FFFFFF"});
        allSentenceSpans.find("span.zombie_sentence_actions").css("display", "none");
        allSentenceSpans.prop("selected", false);


        // Setup this sentence as selected with background color change and Inspect button
        selectedSentenceSpan.find('span.zombie_sentence_text').css({backgroundColor: "#e6e6e6"});
        selectedSentenceSpan.find('span.zombie_sentence_actions').css({display: "inline"});
        selectedSentenceSpan.prop("selected", true);
    }
    else {
        ajax_zombify_sentence($(this).attr("data-sentence"));
    }



}


function appendMutations(mutationsDiv, mutations) {

    // first empty the element
    mutationsDiv.empty();

    // then append each sentence
    jQuery(mutations).each(function (index, mutation) {
        var span = jQuery('<span></span>');
        span.append(mutation + '<br />');
        //span.attr("data-sentence",index);
        mutationsDiv.append(span);
    });
}


function showMutationsDialog(sentence){

    var dialogspan = jQuery('<div class="widget"></div>');
    appendMutations(dialogspan, sentence.mutations);
    dialogspan.dialog({
        autoOpen: true,
        resizable: false,
        height:'auto',
        width:'auto',
        title: "Mutations",
        modal: false,
        dialogClass: 'widget',
        closeOnEscape: true,
        buttons: {
            Dismiss: function() {
                jQuery( this ).dialog('destroy').remove();
            }
        }
    });
}


//function buildZombifyButton(sentence, sentenceSpan){
//    var actionButton = jQuery('<span title="Re-zombify the selected sentence">Z</span>');
//    actionButton.css({backgroundColor: "#000000", color: "#e6e6e6", padding: '7px', margin: '4px'});
//    actionButton.tooltip({show:{delay: 2000}});
//    actionButton.click(function (event) {
//            ajax_zombify_sentence(sentenceSpan.attr("data-sentence"))
//    });
//    return actionButton;
//}

function buildInspectButton(sentence){
    actionButton = jQuery('<span class="zombie_sentence_actions" title="Inspect mutations in selected sentence" >I</span>');
    actionButton.css({display: 'none', backgroundColor: "#000000", color: "#e6e6e6", padding: '7px', margin: '4px'});
    actionButton.tooltip({show:{delay: 2000}});
    actionButton.click(function (event) {
        showMutationsDialog(sentence)
    });
    return actionButton;
}


//
//function buildZombieTextActionsSpan(sentence, sentenceSpan) {
//
//
//    var style = {display: 'none', paddingRight: '3px', paddingLeft: '3px'};
//    var actionsElment = jQuery('<span class="zombie_sentence_actions" ></span>');
//    actionsElment.css(style);
//
//    actionsElment.append(buildInspectButton(sentence, sentenceSpan));
//
//    return actionsElment;
//}



function ajax_zombify_sentence (sentence_number) {

    // Clear any previously set timer before setting a fresh one
    window.clearTimeout(jQuery(this).data("timeout"));
    jQuery(this).data("timeout", setTimeout(function () {

        hide_zombie_div();

        var sentence_index = parseInt(sentence_number);

        // Deserialize the incident to mark the selected sentence for another attack
        //var incident = null;
        var incident = JSON.parse(jQuery("#zombie-artifacts").val());
        incident.zombie[sentence_index].attack = true;
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
                appendSentences(jQuery("#zombie-text"), response.zombie, sentence_index);
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



