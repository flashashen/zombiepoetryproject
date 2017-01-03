/**
 *
 */

jQuery(document).ready(function($) {

   
    $("#user-submitted-post").attr('disabled','disabled');
    $('#zombie-text-loading').hide();
    $('#zombie-text').show();
    $('#zombie-instructions').hide();


    /*
            On click select the sentence, displaying the Inspect bookends
     */
    $("#zombie-text").on('click', 'span.zombie_sentence',
        function (event) {

            if (!$(this).prop("selected")) {
                selectZombieSentence($(this));
            }

            // clicks in the zombie sentence are handled. Kill this event so
            // clicks not matching span.zombie_sentence will deselect all sentences
            event.stopPropagation();
        }
    );


    /*
     On click select that is not a zombie sentence, deselect all sentences
     */
    $("#zombie-text").on('click',
        function (event) {
            deselectAllZombieSentences();
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
                    appendSentences($("#zombie-text"), response);
                    // Re-jsonify the response hoping for an assosiative array in php of artifacts to save as post meta
                    $("#zombie-artifacts").val(JSON.stringify(response));
                    jQuery("#zombie-text-full").val(response.zombieText);
                    //$("#zombie-sentences").val(response.zombie)
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    jQuery("#zombie-text").html(msg);},
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
    //jQuery('#zombie-instructions').hide();

    jQuery("#user-submitted-post").attr('disabled','disabled');
}

function show_zombie_div(){
    //jQuery('.spin').spin('hide');
    jQuery('#zombie-text-loading').hide();
    jQuery('#zombie-text').show();
    jQuery('#zombie-instructions').show();
    jQuery("#user-submitted-post").removeAttr('disabled');
}



function appendSentences(zombieDiv, model, sentence_index) {

    // first empty the element
    zombieDiv.empty();

    // then append each sentence
    jQuery(model.zombie).each(function (index, sentence) {

        //if (sentence.endsStanza){
        //    zombieDiv.append("</br></p>");
        //}
        //else {
            var sentenceSpan = jQuery('<span class="zombie_sentence"></span>');
            sentenceSpan.attr("data-sentence", index);

            sentenceSpan.append(buildSupplementalButton(sentence, model.victim[index]));

            var textSpan = jQuery('<span class="zombie_sentence_text"></span>');

            // replace double line breaks with a br and a paragraph. this is a stanza break
            var text = sentence.text.replace(/(?:\n\n)/g, '<br/><p/>');
            // replace any remaining line breaks with a br, though there probably won't be any.
            textSpan.append(sentence.text.replace(/(?:\r\n|\r|\n)/g, '<br/>'));
            sentenceSpan.append(textSpan);

            sentenceSpan.append(buildSupplementalButton(sentence, model.victim[index]));


            zombieDiv.append(sentenceSpan);

            if (undefined != sentence_index && sentence_index == index) {
                selectZombieSentence(sentenceSpan)
            }
        //}
    });
}


function deselectAllZombieSentences(){

    // Reset background and remove buttons for all sentences
    allSentenceSpans = jQuery("span.zombie_sentence");
    allSentenceSpans.find("span.zombie_sentence_text").css({backgroundColor: "#FFFFFF"});
    allSentenceSpans.find("span.zombie_sentence_actions").css("display", "none");
    allSentenceSpans.prop("selected", false);

}

function selectZombieSentence(selectedSentenceSpan) {

    var textActions = selectedSentenceSpan.find('span.zombie_sentence_actions');

    if ("none" == textActions.css("display")) {

        // Reset background and remove buttons for all sentences
        deselectAllZombieSentences();


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
    //mutationsDiv.empty();

    // then append each sentence
    jQuery(mutations).each(function (index, mutation) {
        var span = jQuery('<span></span>');
        span.append(mutation.replace(/(?:\r\n|\r|\n)/g, '<br/>') + '<br/>');
        //span.attr("data-sentence",index);
        mutationsDiv.append(span);
    });
}

function appendParseString(parseDiv, parseString) {

    // first empty the element
   // parseDiv.empty();
    var finalString = parseString.replace(/(?:\r\n|\r|\n)/g, '<br/>');
    finalString = finalString.replace(/\t/g, '&nbsp;&nbsp;&nbsp;&nbsp;');
    finalString = finalString.replace(/ /g, '&nbsp');
    //finalString = finalString.replace(/(?:\r\n|\r|\n)/g, '<br/>');
    parseDiv.append(finalString);

}


function showSupplementalDialog(zombieSentence, victimSentence){

    /*
            destroy exiting dialog if there is one. Only support a single, modal for now.
     */
    try {
        jQuery('div.ui-dialog').remove();
    }
    catch(err) { }


    var dialogspan = jQuery('<div id="supl" class="widget"></div>');

    var list = jQuery('<ul class="nav nav-tabs"><li class="active"><a data-toggle="tab" href="#supl_text">Text</a></li><li><a data-toggle="tab" href="#supl_mutations">Mutations</a></li><li><a data-toggle="tab" href="#supl_vparse">Victim Parse</a></li><li><a data-toggle="tab" href="#supl_zparse">Zombie Parse</a></li></ul>');


    dialogspan.append(list);

    var contentDiv = jQuery('<div class="tab-content"></div>');
    contentDiv.css({fontSize: "x-small"})

    var tDiv = jQuery('<div class="tab-pane fade in active" id="supl_text"></div>');
    var p = jQuery('</p>')
    p.append(victimSentence.text)
    tDiv.append(p);

    p = jQuery('</p>')
    p.append(' ..... mutated to ....')
    tDiv.append(p);

    p = jQuery('</p>')
    p.append(zombieSentence.text)
    tDiv.append(p);
    contentDiv.append(tDiv);

    var mDiv = jQuery('<div class="tab-pane fade" id="supl_mutations"></div>');
    appendMutations(mDiv, zombieSentence.mutations);
    contentDiv.append(mDiv);

    var vpDiv = jQuery('<div class="tab-pane fade" id="supl_vparse"></div>');
    appendParseString(vpDiv, victimSentence.parseString);
    contentDiv.append(vpDiv);

    var zpDiv = jQuery('<div class="tab-pane fade" id="supl_zparse"></div>');
    appendParseString(zpDiv, zombieSentence.parseString);
    contentDiv.append(zpDiv);




    //appendParseString(dialogspan, sentence.parseString);
    dialogspan.append(contentDiv);
    //dialogspan.tabs();

    dialogspan.dialog({
        autoOpen: true,
        resizable: true,
        height:'auto',
        width:'auto',
        title: "Supplemental",
        modal: true,
        dialogClass: 'widget',
        closeOnEscape: true,
        buttons: {
            Dismiss: function() {
                jQuery( this ).dialog('destroy').remove();
            }
        },
        create: function() {
            jQuery(this).css("maxHeight", jQuery(window).height());
        }
    });
}



function buildSupplementalButton(victimSentence, zombieSentence){
    actionButton = jQuery('<span class="zombie_sentence_actions" title="Inspect mutations in selected sentence" >S</span>');
    actionButton.css({display: 'none', backgroundColor: "#000000", color: "#e6e6e6", padding: '7px', margin: '4px'});
    actionButton.tooltip({show:{delay: 2000}});
    actionButton.click(function (event) {
        showSupplementalDialog(victimSentence, zombieSentence)
    });
    return actionButton;
}




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

            // direct
            //url: "http://localhost:8090/victim",
            //data: incident,

            // via WP ajax handler
            url: ajax_object.ajax_url,
            data: data,

            dataType: 'json',
            success: function (response) {
                console.log('the value is' + response);
                appendSentences(jQuery("#zombie-text"), response, sentence_index);
                // Re-jsonify the response hoping for an assosiative array in php of artifacts to save as post meta
                jQuery("#zombie-artifacts").val(JSON.stringify(response));
                jQuery("#zombie-text-full").val(response.zombieText);
                //jQuery("#zombie-sentences").val(response.zombie)
            },
            error: function (jqXHR, exception) {
                var msg = '';
                if (jqXHR.status === 0) {
                    msg = 'Not connect.\n Verify Network.';
                } else if (jqXHR.status == 404) {
                    msg = 'Requested page not found. [404]';
                } else if (jqXHR.status == 500) {
                    msg = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msg = 'Requested JSON parse failed.';
                } else if (exception === 'timeout') {
                    msg = 'Time out error.';
                } else if (exception === 'abort') {
                    msg = 'Ajax request aborted.';
                } else {
                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                }
                jQuery("#zombie-text").html(msg);
            },
            complete: show_zombie_div
        });

        // why return false?
        return false;
    }, 1000));
};



