import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';

import ZombieText from './ZombieText';
import VictimText from './VictimText';
import ZombieInstructions from './ZombieInstructions';

import { actionAttack, actionSentenceSelect,  NEW_VICTIM, SENTENCE_SELECT_NEXT, SENTENCE_SELECT_PREVIOUS, SENTENCE_ZOMBIE_SELECT_NEXT, SENTENCE_ZOMBIE_SELECT_PREVIOUS  } from '../actions';

// import './fashionistas.css';


import './css/athemes-symbols.css';
import './css/zombie.css';


class InfectPage extends Component {

    constructor(props) {
        super(props);
        this.handleZombieTextUpdatedDebounced = this.handleZombieTextUpdatedDebounced.bind(this);
        this.victimTextChangeHandler = this.victimTextChangeHandler.bind(this);
    }

    debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            var later = function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    handleZombieTextUpdatedDebounced = this.debounce( (e) => {
        // this.props.dispatch(victimTextWalksItoAZombieBar(e.target.value));
        this.props.dispatch(actionAttack());
    }, 1000, 0);



    victimTextChangeHandler(e) {
        e.preventDefault();
        this.props.dispatch({
            type: NEW_VICTIM,
            text: e.target.value
        });
        this.handleZombieTextUpdatedDebounced(e);
    }


    render() {
        return (
            <div id="main"
                 className="site-main"><div className="clearfix container">
                <div id="content" className="site-content-wide" role="main">
                <article className="container clearfix post-117 page type-page status-publish hentry">
                <div>

                    <VictimText victimText={this.props.victimText}
                                title={this.props.title}
                                author={this.props.author}
                                victimTextChangeHandler={this.victimTextChangeHandler}/>
                    <ZombieText fullscreen={this.props.fullscreen}
                                zombieChoices={this.props.zombieChoices}
                                zombieChosenIndexes={this.props.zombieChosenIndexes}
                                selectedSentenceIndex={this.props.selectedSentenceIndex}
                                zombieIndexMarker={this.props.zombieIndexMarker}
                                dispatch={this.props.dispatch}/>
                   {/*<ZombieInstructions/>*/}

                </div>
                </article>
                </div>
            </div></div>
        );
    }
}

InfectPage.propTypes = {
    selectedSentenceIndex: PropTypes.number,
    linesPerStanza: PropTypes.number,
    title: PropTypes.string,
    author: PropTypes.string,
    victimText: PropTypes.string,
    victim: PropTypes.array,
    zombieText: PropTypes.string,
    zombieChoices: PropTypes.array,
    zombieChosenIndexes: PropTypes.array,
    isFetching: PropTypes.bool,
    error: PropTypes.object,
    zombieIndexMarker: PropTypes.number,
    fullscreen: PropTypes.bool,
};



function mapStateToProps(state) {

    return {
        linesPerStanza: state.linesPerStanza,
        title: state.incident.title,
        author: state.incident.author,
        victimText: state.incident.victimText,
        victim: state.incident.victim,
        zombieText: state.incident.zombieText,
        zombieChoices: state.incident.zombieChoices,
        zombieChosenIndexes: state.incident.zombieChosenIndexes,

        isFetching: state.incident.isFetching,
        error: state.incident.error,
        selectedSentenceIndex: state.incident.selectedSentenceIndex,
        zombieIndexMarker: state.incident.zombieIndexMarker,
        fullscreen: state.incident.fullscreen,
    };
}

export default connect(mapStateToProps)(InfectPage);
