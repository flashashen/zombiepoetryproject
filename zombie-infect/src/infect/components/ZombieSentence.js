import React, { PropTypes } from 'react';
import { actionAttack, actionSentenceSelect, breakText } from '../actions';





const styleDisplayBlock = {
    outline: '0px solid tranparent'
};


const ZombieSentence = ({ dispatch, text, sentenceIndex, zombieIndexMarker, active, zombiesLeft, zombiesRight, keyHandler, clickHandler }) => (


    <span
        onKeyDown={keyHandler}
        tabIndex="-1"
        id={'zombie_sentence_'+sentenceIndex.toString()}>

         {zombieIndexMarker>=0 ? <p/> : ""}

        { active
            ? zombiesLeft
                ? <i className="icon-chevron-left"/>
                : <i className="icon-stop"/>
            : '' }


        { active
            ? <span
                className="zombie_sentence_active"
                onClick={() => dispatch(actionAttack())}
                tabIndex="0"
                dangerouslySetInnerHTML={{__html: (zombieIndexMarker>=0) ? (text) : breakText(text)}}/>
            : <span
                style={styleDisplayBlock}
                className="zombie_sentence"
                tabIndex="0"
                onClick={() => dispatch(actionSentenceSelect(sentenceIndex))}
                dangerouslySetInnerHTML={{__html: breakText(text)}}/>
        }


        { active
            ? zombiesRight
                ? <i className="icon-chevron-right"/>
                : <i className="icon-stop"/>
            : '' }

        {zombieIndexMarker>=0 ? <p/> : ""}

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
