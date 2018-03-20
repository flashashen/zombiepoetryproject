import React, { PropTypes } from 'react';
<<<<<<< HEAD
import { actionAttack, actionSentenceSelect } from '../actions';
=======
import { actionAttack, actionSentenceSelect, breakText, SENTENCE_ZOMBIE_SELECT_PREVIOUS, SENTENCE_ZOMBIE_SELECT_NEXT  } from '../actions';
>>>>>>> split




<<<<<<< HEAD
function breakText(text){
    // console.log('breaking text:' + text)
    var brokenText = text.replace(/(?:\n\n)/g, '<br/><p></p>');
    // replace any remaining line breaks with a br, though there probably won't be any.
    brokenText = brokenText.replace(/(?:\r\n|\r|\n)/g, '<br/>');
    // console.log('broken text:' + brokenText)
    return brokenText

}
=======
>>>>>>> split

const styleDisplayBlock = {
    outline: '0px solid tranparent'
};


const ZombieSentence = ({ dispatch, text, sentenceIndex, zombieIndexMarker, active, zombiesLeft, zombiesRight, keyHandler, clickHandler }) => (


    <span
        onKeyDown={keyHandler}
<<<<<<< HEAD
        tabIndex="-1"
        id={'zombie_sentence_'+sentenceIndex.toString()}>

         {zombieIndexMarker>=0 ? <p/> : ""}

        { active
            ? zombiesLeft
                ? <i className="icon-chevron-left"/>
                : <i className="icon-stop"/>
=======
        id={'zombie_sentence_'+sentenceIndex.toString()}>

        { active
            ? zombiesLeft
                ? <i className="icon-chevron-left" tabIndex="-1" onClick={(e) => {e.preventDefault(); dispatch({type: SENTENCE_ZOMBIE_SELECT_PREVIOUS })}}/>
                : <i className="icon-stop" tabIndex="-1" />
>>>>>>> split
            : '' }


        { active
            ? <span
                className="zombie_sentence_active"
                onClick={() => dispatch(actionAttack())}
                tabIndex="0"
<<<<<<< HEAD
                dangerouslySetInnerHTML={{__html: (zombieIndexMarker>=0) ? (text) : breakText(text)}}/>
            : <span
                style={styleDisplayBlock}
                className="zombie_sentence"
                tabIndex="0"
                onClick={() => dispatch(actionSentenceSelect(sentenceIndex))}
=======
                dangerouslySetInnerHTML={{__html: breakText(text) }}/>
            : <span
                style={styleDisplayBlock}
                className="zombie_sentence"
                onClick={() => dispatch(actionSentenceSelect(sentenceIndex))}
                tabIndex="-1"
>>>>>>> split
                dangerouslySetInnerHTML={{__html: breakText(text)}}/>
        }


        { active
            ? zombiesRight
<<<<<<< HEAD
                ? <i className="icon-chevron-right"/>
                : <i className="icon-stop"/>
            : '' }

        {zombieIndexMarker>=0 ? <p/> : ""}
=======
                ? <i className="icon-chevron-right" tabIndex="-1"  onClick={() => {dispatch({type: SENTENCE_ZOMBIE_SELECT_NEXT})}}/>
                : <i className="icon-stop" tabIndex="-1" />
            : '' }

>>>>>>> split

    </span>

);

ZombieSentence.propTypes = {
    dispatch: PropTypes.func,
    active: PropTypes.bool,
    text: PropTypes.string,
    sentenceIndex: PropTypes.number,
    zombiesLeft: PropTypes.bool,
    zombiesRight: PropTypes.bool,
    keyHandler: PropTypes.func,
};

export default ZombieSentence;
