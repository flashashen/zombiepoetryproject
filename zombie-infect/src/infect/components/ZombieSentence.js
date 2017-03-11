import React, { PropTypes } from 'react';
import { actionAttack, actionSentenceSelect, breakText, SENTENCE_ZOMBIE_SELECT_PREVIOUS, SENTENCE_ZOMBIE_SELECT_NEXT  } from '../actions';





const styleDisplayBlock = {
    outline: '0px solid tranparent'
};


const ZombieSentence = ({ dispatch, text, sentenceIndex, zombieIndexMarker, active, zombiesLeft, zombiesRight, keyHandler, clickHandler }) => (


    <span
        onKeyDown={keyHandler}
        id={'zombie_sentence_'+sentenceIndex.toString()}>

        { active
            ? zombiesLeft
                ? <i className="icon-chevron-left" tabIndex="-1" onClick={(e) => {e.preventDefault(); dispatch({type: SENTENCE_ZOMBIE_SELECT_PREVIOUS })}}/>
                : <i className="icon-stop" tabIndex="-1" />
            : '' }


        { active
            ? <span
                className="zombie_sentence_active"
                onClick={() => dispatch(actionAttack())}
                tabIndex="0"
                dangerouslySetInnerHTML={{__html: breakText(text) }}/>
            : <span
                style={styleDisplayBlock}
                className="zombie_sentence"
                onClick={() => dispatch(actionSentenceSelect(sentenceIndex))}
                tabIndex="-1"
                dangerouslySetInnerHTML={{__html: breakText(text)}}/>
        }


        { active
            ? zombiesRight
                ? <i className="icon-chevron-right" tabIndex="-1"  onClick={() => {dispatch({type: SENTENCE_ZOMBIE_SELECT_NEXT})}}/>
                : <i className="icon-stop" tabIndex="-1" />
            : '' }


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
