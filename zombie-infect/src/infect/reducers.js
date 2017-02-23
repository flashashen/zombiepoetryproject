import {
    ZOMBIE_FULL_SCREEN_TOGGLE,
    ZOMBIE_ESCAPE,
    INFO_TAB_SELECT_NEXT,
    INFO_TAB_SELECT_PREVIOUS,
    INFO_TAB_SELECT_INDEX,
    NEW_VICTIM,
    SENTENCE_SELECT,
    SENTENCE_SELECT_NEXT,
    SENTENCE_SELECT_PREVIOUS,
    SENTENCE_ZOMBIE_SELECT_NEXT,
    SENTENCE_ZOMBIE_SELECT_PREVIOUS,
    INVALIDATE_INCIDENT,
    ATTACK_REQUEST,
    ATTACK_SUCCESS,
    ATTACK_FAILURE,
    RELINEATE_REQUEST,
    RELINEATE_SUCCESS,
    more_zombies_next, more_zombies_previous, getSelectedSentenceIndex, getZombieText} from '../infect/actions';


const initState = {
    "selectedSentenceIndex": -1,
    "zombieIndexMarker": -1,
    "selectedInfoIndex": 0,
    "victimText": "Because having a college education and being a homeowner isn’t all what it’s cracked up to be. Check out these homeowner tax opportunities and take advantage of those that apply! Probably one of the most grownup emails I have received. I am now a homeowner and responsible for stuff. *Gulp* Pumpkin Growing for the Homeowner: It may not be autumn just yet, but pumpkin growing needs to be thought of. Rising home prices boost homeowner equity. Homeowner was on her way home from work & saw police, fire outside. Then she noticed vehicle in her living room.",
};

export function incident(incident_state = initState, action) {

    switch (action.type) {


        case ZOMBIE_FULL_SCREEN_TOGGLE:
            return Object.assign({}, incident_state, {
                fullscreen: !incident_state.fullscreen
            });


        case ZOMBIE_ESCAPE:
            if (incident_state.fullscreen){
                return Object.assign({}, incident_state, {
                    fullscreen: false
                });
            }
            return incident_state;
        //
        // case INFO_TAB_SELECT_NEXT:
        //     return Object.assign({}, incident_state, {
        //         selectedInfoIndex: (incident_state.selectedInfoIndex += 1) % 4
        //     });
        //
        // case INFO_TAB_SELECT_PREVIOUS:
        //     return Object.assign({}, incident_state, {
        //         selectedInfoIndex: incident_state.selectedInfoIndex==0 ? 3 : incident_state.selectedInfoIndex-1
        //     });
        //
        // case INFO_TAB_SELECT_INDEX:
        //     return Object.assign({}, incident_state, {
        //         selectedInfoIndex: action.index
        //     });

        case NEW_VICTIM:
            return Object.assign({}, incident_state, {
                victimText: action.text,
                selectedSentenceIndex: -1,
                zombieIndexMarker: -1,
                zombieChoices: [],
                zombie: null,
                victim: null,
                zombieText: "",
                isFetching: false
            });

        case INVALIDATE_INCIDENT:
            return Object.assign({}, incident_state, {
                didInvalidate: true,
            });


        case SENTENCE_SELECT:
            var index = getSelectedSentenceIndex(action, incident_state)
            return Object.assign({}, incident_state, {
                selectedSentenceIndex: index,
                // set marker
                zombieIndexMarker: incident_state.zombieChosenIndexes[index]
            });

        case SENTENCE_SELECT_NEXT:
            var index = getSelectedSentenceIndex(action, incident_state)
            if (index < incident_state.zombieChoices.length-1) {
                return Object.assign({}, incident_state, {
                    selectedSentenceIndex: index+1,
                    // set marker
                    zombieIndexMarker: incident_state.zombieChosenIndexes[index+1]
                });
            }
            return incident_state;

        case SENTENCE_SELECT_PREVIOUS:
            var index = getSelectedSentenceIndex(action, incident_state)
            if (index > 0) {
                return Object.assign({}, incident_state, {
                    selectedSentenceIndex: index-1,
                    // set marker
                    zombieIndexMarker: incident_state.zombieChosenIndexes[index-1]
                });
            }
            return incident_state;


        case SENTENCE_ZOMBIE_SELECT_PREVIOUS:

            var index = getSelectedSentenceIndex(action, incident_state)
            if (more_zombies_previous(index, incident_state.zombieChoices, incident_state.zombieChosenIndexes)){
            // if (incident_state.zombieChosenIndexes[index] > 0){
                var new_indexes = incident_state.zombieChosenIndexes.slice(0)
                new_indexes[index] = new_indexes[index]-1
                return Object.assign({}, incident_state, {
                    zombieChosenIndexes: new_indexes,
                    // set zombie selection marker to initial choice, don't change it after that
                    // zombieIndexMarker: (incident_state.zombieIndexMarker < 0)
                    //     ? incident_state.zombieChosenIndexes[index]
                    //     : incident_state.zombieIndexMarker,
                    // Make sure zombieText is current with user selections
                    zombieText: getZombieText(incident_state.zombieChoices, new_indexes)
            });
            }
            return incident_state;


        case SENTENCE_ZOMBIE_SELECT_NEXT:

            var index = getSelectedSentenceIndex(action, incident_state)
            if (more_zombies_next(index, incident_state.zombieChoices, incident_state.zombieChosenIndexes)){
            // if (incident_state.zombieChosenIndexes[index] < incident_state.zombieChoices[index].length-1){
                var new_indexes = incident_state.zombieChosenIndexes.slice(0)
                new_indexes[index] = new_indexes[index]+1
                var new_state = Object.assign({}, incident_state, {
                    zombieChosenIndexes: new_indexes,
                    // set zombie selection marker to initial choice, don't change it after that
                    // zombieIndexMarker: (incident_state.zombieIndexMarker < 0)
                    //     ? incident_state.zombieChosenIndexes[index]
                    //     : incident_state.zombieIndexMarker,
                    // Make sure zombieText is current with user selections
                    zombieText: getZombieText(incident_state.zombieChoices, new_indexes)
                });
                // Keep zombie updated for submit. Getting
                new_state.zombie[index] = new_state.zombieChoices[index][new_state.zombieChosenIndexes[index]]
                return new_state;
            }

            return incident_state;


        case RELINEATE_REQUEST:
            // Do nothing for now. Its ok to have more than one in flight. Prior need to be canceled
            return incident_state;


        case ATTACK_REQUEST:
            return Object.assign({}, incident_state, {
                isFetching: true,
                didInvalidate: false,
            });


        case RELINEATE_SUCCESS:

            var new_state;
            new_state =  Object.assign({}, incident_state, {
                isFetching: false,
                didInvalidate: false,
                zombieText: action.incident.zombieText,
                zombie: action.incident.zombie,
            });
            for (var i = 0; i < action.incident.zombie.length; i++) {
                new_state.zombieChoices[i][new_state.zombieChosenIndexes[i]] = action.incident.zombie[i];
            }
            return new_state;
            // return incident_state;

        case ATTACK_SUCCESS:

            var new_state;
            new_state = Object.assign({}, incident_state, {
                isFetching: false,
                didInvalidate: false,
                linesPerStanza: action.incident.linesPerStanza,
                victimText: action.incident.victimText,
                victim: action.incident.victim,
                zombieText: action.incident.zombieText,
                zombie: action.incident.zombie,
            });

            if (action.selectedSentenceIndex >= 0){

                // Check if the zombie text is not already
                // var duplicate = incident_state.zombieChoices.find(function(text){
                //         return text == action.incident.zombie[action.selectedSentenceIndex].text;
                //     }
                // );
                //
                // if (!duplicate) {
                //     console.log('zombie already in choices list. will add anyway for now')
                // }

                // Copy the arrays as arrays to maintain the Array prototype to maintain functions like map. using
                // Object.assign only copies enumerable properties so no prototype methods survive the copy.
                new_state.zombieChoices = incident_state.zombieChoices.slice(0);
                new_state.zombieChoices[action.selectedSentenceIndex] = new_state.zombieChoices[action.selectedSentenceIndex].slice(0)
                new_state.zombieChosenIndexes = incident_state.zombieChosenIndexes.slice(0)


                // Add to the array of zombie for this sentence. Note, the existing zombies did not need to be copied, only the array
                // of references to the zombies is changed and the new zombie is added to that.
                new_state.zombieChoices[action.selectedSentenceIndex].push(action.incident.zombie[action.selectedSentenceIndex]);
                // Set the chosen index to the last index of the zombie sentence list
                new_state.zombieChosenIndexes[action.selectedSentenceIndex] = new_state.zombieChoices[action.selectedSentenceIndex].length-1;

                // Now copy all current zombies to force all to re-render. This is to pick up any relineation
                for (var i = 0; i < action.incident.zombie.length; i++) {
                    new_state.zombieChoices[i][new_state.zombieChosenIndexes[i]] = action.incident.zombie[i];
                }

            }
            else
            {
                // Copy zombie into a list of len 1 choice lists.
                new_state.zombieChoices = []
                new_state.zombieChosenIndexes = []
                for (var i = 0; i < action.incident.zombie.length; i++) {

                    new_state.zombieChoices.push([action.incident.zombie[i]]);
                    new_state.zombieChosenIndexes.push(0)
                }
                new_state.selectedSentenceIndex = 0;
                new_state.zombieIndexMarker = -1;

            }

            return new_state;


        case ATTACK_FAILURE:
            return Object.assign({}, incident_state, {
                isFetching: false,
                didInvalidate: false,
                error: action.error,
            });

        default:
            return incident_state;
    }
}





