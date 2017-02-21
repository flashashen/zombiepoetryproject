import { apiPost } from '../utils/apiUtils';


/*
    state transition events.

    these identify all possible events that can change the application state
 */

// Zombie sentence user interactions
export const SENTENCE_SELECT = 'SENTENCE_SELECT';
export const SENTENCE_SELECT_NEXT = 'SENTENCE_SELECT_NEXT';
export const SENTENCE_SELECT_PREVIOUS = 'SENTENCE_SELECT_PREVIOUS';
export const SENTENCE_ZOMBIE_SELECT_NEXT = 'SENTENCE_ZOMBIE_SELECT_NEXT';
export const SENTENCE_ZOMBIE_SELECT_PREVIOUS = 'SENTENCE_ZOMBIE_SELECT_PREVIOUS';

// Remote zombification results
export const ATTACK_REQUEST = 'ATTACK_REQUEST';
export const ATTACK_SUCCESS = 'ATTACK_SUCCESS';
export const ATTACK_FAILURE = 'ATTACK_FAILURE';

export const RELINEATE_REQUEST = 'RELINEATE_REQUEST';
export const RELINEATE_SUCCESS = 'RELINEATE_SUCCESS';
export const RELINEATE_FAILURE = 'RELINEATE_FAILURE';
// TODO relinate handling

export const ZOMBIE_FULL_SCREEN_TOGGLE = 'ZOMBIE_FULL_SCREEN_TOGGLE';
export const ZOMBIE_ESCAPE = 'ZOMBIE_ESCAPE';


// Miscellaneous
export const NEW_VICTIM = 'NEW_VICTIM';
// export const WALK_INTO_A_ZOMBIE_BAR = 'WALK_INTO_A_ZOMBIE_BAR';
export const INVALIDATE_INCIDENT = 'INVALIDATE_INCIDENT';




export function breakText(text){
    // console.log('breaking text:' + text)
    var brokenText = text.replace(/(?:\n\n)/g, '<br/><p></p>');
    // replace any remaining line breaks with a br, though there probably won't be any.
    brokenText = brokenText.replace(/(?:\r\n|\r|\n)/g, '<br/>');
    // console.log('broken text:' + brokenText)
    return brokenText

}


//
// export function victimTextWalksItoAZombieBar(text) {
//     return {
//         type: WALK_INTO_A_ZOMBIE_BAR,
//         victimText: text,
//     };
// }

export function updateVictimText(name, value) {
    return {
        type: NEW_VICTIM, name, value
    };
}


export function invalidateIncident() {
  return {
    type: INVALIDATE_INCIDENT,
  };
}



/*
    Zombie choice navigation
 */
export function sentenceChooseNext(index){

    actionRelineate()

    return {
        type: SENTENCE_ZOMBIE_SELECT_NEXT,
        selectedSentenceIndex: index,
    };
}

export function sentenceChoosePrevious(index){
    return {
        type: SENTENCE_ZOMBIE_SELECT_PREVIOUS,
        selectedSentenceIndex: index,
    };
}


export function actionSentenceSelect(index) {
    return {
        type: SENTENCE_SELECT,
        selectedSentenceIndex: index,
    };
}




//
//  Helpers to hide some of the array indexing in the state
//
export function getSelectedSentenceIndex(action, state){
    return (action.selectedSentenceIndex && action.selectedSentenceIndex >= 0)
        ? action.selectedSentenceIndex
        : (state.selectedSentenceIndex >= 0) ? state.selectedSentenceIndex : 0
}

export function more_zombies_next(selectedSentenceIndex, zombieChoices, zombieChosenIndexs){
    return zombieChosenIndexs[selectedSentenceIndex] < zombieChoices[selectedSentenceIndex].length-1
}

export function more_zombies_previous(selectedSentenceIndex, zombieChoices, zombieChosenIndexes){
    return zombieChosenIndexes[selectedSentenceIndex] > 0
}


export function getZombieText(zombieChoices, zombieChosenIndexes){
    var text = "";
    for (var i = 0; i < zombieChoices.length; i++) {
        text += zombieChoices[i][zombieChosenIndexes[i]].text
    }
    return text;
}
//
// export function zombieSelectionChanged(){
//     zombieIndexMarker != zombieChosenIndexes[selectedSentenceIndex])
// }


//
//  Remote NLP / zombie handlers
//

function attackRequest(index) {
  return {
    type: ATTACK_REQUEST,
      selectedSentenceIndex: index,
  };
}

function relineateRequest(index) {
    return {
        type: RELINEATE_REQUEST,
        selectedSentenceIndex: index,
    };
}

// This is a curried function that takes page as argument,
// and expects payload as argument to be passed upon API call success.
function attackSuccess(selectedSentenceIndex) {
  return function (payload) {
    console.log(payload);
    return {
      type: ATTACK_SUCCESS,
      incident: payload,
        selectedSentenceIndex: selectedSentenceIndex
    };
  };
}

// This is a curried function that takes page as argument,
// and expects error as argument to be passed upon API call failure.
function attackFailure(selectedSentenceIndex) {
  return function (error) {
    return {
      type: ATTACK_FAILURE,
      error: error,
    };
  };
}


function relineateSuccess(selectedSentenceIndex) {
    return function (payload) {
        return {
            type: RELINEATE_SUCCESS,
            incident: payload,
            selectedSentenceIndex: selectedSentenceIndex
        };
    };
}


const API_ROOT = 'http://www.zombiepoetryproject.com:8080';
// const API_ROOT = 'https://zombie-nlp-test.herokuapp.com'
function remoteAttack(incident) {
  const url = `${API_ROOT}/victim`;

   if (incident.selectedSentenceIndex != null && incident.selectedSentenceIndex>=0) {
      incident.zombie[incident.selectedSentenceIndex].attack = true;
  }
  else {
       // If no sentence is selected, then reset linesPerStanza and let it go free
       incident.linesPerStanza = -1
   }

  return apiPost(url, incident, attackRequest(
      incident.selectedSentenceIndex),
      attackSuccess(incident.selectedSentenceIndex),
      attackFailure(incident.selectedSentenceIndex));
}

// function remoteRelineate(incident) {
//     // const url = ;
//     return apiPost(`${API_ROOT}/rerealize`, incident, relineateRequest(
//         incident.selectedSentenceIndex),
//         relineateSuccess(incident.selectedSentenceIndex),
//         attackFailure(incident.selectedSentenceIndex));
// }


// Do remote request if not already in progress. The return value is itself a function
export function actionAttack() {
  return (dispatch, getState) => {
    if (!getState().incident.isFetching) {
      return dispatch(remoteAttack(getState().incident));
    }
  };
}

// Use thunk handler for async dispatch of
export function actionRelineate() {
    return (dispatch, getState) => {
        var incident = getState().incident;

        // Make sure zombieText is current with user selections
        incident.zombieText = getZombieText(incident.zombieChoices, incident.zombieChosenIndexes);

        if (!incident.isFetching
                && incident.zombieIndexMarker >= 0
                && incident.selectedSentenceIndex >= 0
                && incident.zombieIndexMarker != incident.zombieChosenIndexes[incident.selectedSentenceIndex]){
            return dispatch(apiPost(`${API_ROOT}/rerealize`, incident,
                relineateRequest(incident.selectedSentenceIndex),
                relineateSuccess(incident.selectedSentenceIndex),
                attackFailure(incident.selectedSentenceIndex)));
        }
    };
}
