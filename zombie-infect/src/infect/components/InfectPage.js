import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';

import ZombieText from './ZombieText';
import VictimText from './VictimText';
import ZombieInstructions from './ZombieInstructions';
import ZombieMutations from './ZombieMutations';

import { actionAttack, actionSentenceSelect, breakText, NEW_VICTIM, SENTENCE_SELECT_NEXT, SENTENCE_SELECT_PREVIOUS, SENTENCE_ZOMBIE_SELECT_NEXT, SENTENCE_ZOMBIE_SELECT_PREVIOUS  } from '../actions';

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

    outputDelineatedText(text){
        return (<span dangerouslySetInnerHTML={{__html: breakText(text)}}/>);
    }

    zombieElements(props){
        return (
            <div className="row-fluid">

            <ZombieText
                fullscreen={props.fullscreen}
                zombieChoices={props.zombieChoices}
                zombieChosenIndexes={props.zombieChosenIndexes}
                selectedSentenceIndex={props.selectedSentenceIndex}
                zombieIndexMarker={props.zombieIndexMarker}
                dispatch={props.dispatch}/>


                {!props.fullscreen && <div className="span5">
                <Tabs onSelect={this.handleSelect} on >

                    <TabList>
                        <Tab>Help</Tab>
                        <Tab>Text</Tab>
                        <Tab>Mutations</Tab>
                        <Tab>V Parse</Tab>
                        <Tab>Z Parse</Tab>
                    </TabList>

                    <TabPanel>
                        <ZombieInstructions/>
                    </TabPanel>

                    <TabPanel>
                        {/*<ZombieMutations*/}
                            {/*zombieChoices={props.zombieChoices}*/}
                            {/*zombieChosenIndexes={props.zombieChosenIndexes}*/}
                            {/*selectedSentenceIndex={props.selectedSentenceIndex}*/}
                            dispatch={props.dispatch}
                        {this.outputDelineatedText(this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].text)}
                         " mutated to ... "
                        {this.outputDelineatedText(this.props.victim[props.selectedSentenceIndex].text)}
                        />
                    </TabPanel>
                    <TabPanel>
                        {this.outputDelineatedText(this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].mutations.join('\n'))}
                    </TabPanel>
                    <TabPanel>
                        {this.outputDelineatedText(this.props.victim[props.selectedSentenceIndex].parseString)}
                    </TabPanel>
                    <TabPanel>
                        {this.outputDelineatedText(this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].parseString)}
                    </TabPanel>
                </Tabs>
            </div>}
        </div>);
    }



    render() {
        return (
            <div id="main"className="site-main"><div className="clearfix container">
                <div id="content" className="site-content-wide" role="main">
                <article className="container clearfix post-117 page type-page status-publish hentry">

                <div id="zombie-posts" className="clearfix entry-content">
                    <form id="usp_form" method="post" enctype="multipart/form-data" action="">

                    <VictimText victimText={this.props.victimText}
                                title={this.props.title}
                                author={this.props.author}
                                victimTextChangeHandler={this.victimTextChangeHandler}/>

                    {this.props.fullscreen ? "" : <hr/>}

                    {this.props.zombieChoices && this.props.zombieChoices.length>0 && this.zombieElements(this.props)}



                </form>
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
