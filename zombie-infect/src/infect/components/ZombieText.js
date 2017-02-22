import React, { PropTypes } from 'react';
import * as actions from '../actions';

import ZombieSentence from './ZombieSentence';

const styleDisplayBlock = {
    display: 'block',
    outline: '0px solid tranparent'
};
//
//
// // Get the selected sentence index with a bit of a DOM hack
// function getSelectedSentenceIndexFromEvent(e){
//     var nodes = Array.prototype.slice.call(e.currentTarget.children);
//     return nodes.indexOf(e.target.parentNode);
// }
//
// // Return an event handler for a sentence selection event given a function that
// // will dispatch the appropriate redux action. This allows DOM details to remain
// // here while state logic and composition concerns remain above
// function getSentenceSelectHandler(selected_index, select, attack) {
//     return function(e) {
//         e.preventDefault(); // just in case
//         var index = getSelectedSentenceIndexFromEvent(e)
//         if (index>=0 && index == selected_index)
//             attack(index);
//         else
//             select(index);
//     }
// }
//
// function zombiesLeft(selectedSentence, choices, chosenIndexes){
//     return true
// }
//
// function zombiesRight(selectedSentence, choices, chosenIndexes){
//     return false
// }



function zombieKeyNavigate(dispatch, e) {

    if (e.key == 'ArrowUp') {
        // up arrow
        e.preventDefault();
        dispatch({type: actions.SENTENCE_SELECT_PREVIOUS});
    }
    else if (e.key == 'ArrowDown') {
        // down arrow
        e.preventDefault();
        dispatch(actions.actionRelineate())
        dispatch({ type: actions.SENTENCE_SELECT_NEXT});
    }
    else if (e.key == 'ArrowLeft') {
        // left arrow
        e.preventDefault();
        dispatch({type: actions.SENTENCE_ZOMBIE_SELECT_PREVIOUS});
    }
    else if (e.key == "ArrowRight") {
        // right arrow
        e.preventDefault();
        dispatch({type: actions.SENTENCE_ZOMBIE_SELECT_NEXT});
    }
    else if (e.key == "f") {
        // Instigate a new zombie attack
        // var nodes = Array.prototype.slice.call(e.target.parentNode.childNodes);
        e.preventDefault();
        dispatch({type: actions.ZOMBIE_FULL_SCREEN_TOGGLE});
    }
    else if (e.key == "Escape") {
        // Instigate a new zombie attack
        // var nodes = Array.prototype.slice.call(e.target.parentNode.childNodes);
        e.preventDefault();
        dispatch({type: actions.ZOMBIE_ESCAPE});
    }
    else if (e.key == " ") {
        // Instigate a new zombie attack
        // var nodes = Array.prototype.slice.call(e.target.parentNode.childNodes);
        e.preventDefault();
        dispatch(actions.actionAttack())
    }
}


const ZombieText = ({
    fullscreen,
    zombieChoices,
    zombieChosenIndexes,
    selectedSentenceIndex,
    zombieIndexMarker,
    dispatch}) => (

    <div className="span6">

        <label htmlFor="zombie-text">Zombie Text</label><br/><p/>

        <div id="zombie-text"
             className={fullscreen ? 'zombie_fullscreen' : 'zombie_inplace'}
             style={styleDisplayBlock}>

            {zombieChoices && zombieChoices.map(function(z, i){
                return <ZombieSentence
                    dispatch={dispatch}
                    key={i.toString()}
                    active={i==selectedSentenceIndex || (selectedSentenceIndex<0 && i==0) ? true : false}
                    sentenceIndex={i}
                    zombieIndexMarker={-1}
                    zombiesLeft={actions.more_zombies_previous(i, zombieChoices, zombieChosenIndexes)}
                    zombiesRight={actions.more_zombies_next(i, zombieChoices, zombieChosenIndexes)}
                    text={zombieChoices[i][zombieChosenIndexes[i]].text}
                    keyHandler={(e) => zombieKeyNavigate(dispatch, e)}/>
            })}

        </div>
    </div>
);



ZombieText.propTypes = {
    zombieChoices: PropTypes.array,
    zombieChosenIndexes: PropTypes.array,
    selectedSentenceIndex: PropTypes.number,
    dispatch: PropTypes.func,
    fullscreen: PropTypes.bool,
};



export default ZombieText;
