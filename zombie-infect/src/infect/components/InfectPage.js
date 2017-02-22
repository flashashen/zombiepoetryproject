import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';

import ZombieText from './ZombieText';
import VictimText from './VictimText';
import ZombieInstructions from './ZombieInstructions';
import ZombieMutations from './ZombieMutations';

import { actionAttack, actionSentenceSelect, breakText, NEW_VICTIM, INFO_TAB_SELECT_PREVIOUS, INFO_TAB_SELECT_NEXT, INFO_TAB_SELECT_INDEX, SENTENCE_SELECT_NEXT, SENTENCE_SELECT_PREVIOUS, SENTENCE_ZOMBIE_SELECT_NEXT, SENTENCE_ZOMBIE_SELECT_PREVIOUS  } from '../actions';

// import './fashionistas.css';


import './css/athemes-symbols.css';
import './css/zombie.css';


class InfectPage extends Component {

    constructor(props) {
        super(props);
        this.handleZombieTextUpdatedDebounced = this.handleZombieTextUpdatedDebounced.bind(this);
        this.victimTextChangeHandler = this.victimTextChangeHandler.bind(this);
        this.keyHandler = this.keyHandler.bind(this);
        this.focus = this.focus.bind(this);
        this.setref = this.setref.bind(this);
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



    componentWillMount() {
        this.panel0 = null;
        this.panel1 = null;
        this.panel2 = null;
        this.panel3 = null;
    }

    componentDidUpdate(prevProps, prevState) {

        if (!this.panel0)
            return;

        switch (this.props.selectedInfoIndex) {
            case 0:
                this.panel0.focus();
                break;
            case 1:
                this.panel1.focus();
                break;
            case 2:
                this.panel2.focus();
                break;
            case 3:
                this.panel3.focus();
                break;
        }
     }


    focusTab(input, index) {
        if (input != null && this.props.selectedInfoIndex==index) {
            input.focus();
            input.select();
        }
    }

    focus() {
        // Explicitly focus the text input using the raw DOM API
        if (this.tabs) {
            this.tabs.focus();
        }
    }
     //autoFocus

    setref(component){
        if (component)
            this.tabs = component;
    }

    keyHandler(e) {

        // if (e.key == 'ArrowUp') {
        //     // up arrow
        //     e.preventDefault();
        //     e.stopPropagation()
        //
        //     this.props.dispatch({type: SENTENCE_SELECT_PREVIOUS});
        // }
        // else if (e.key == 'ArrowDown') {
        //     // down arrow
        //     e.preventDefault();
        //     e.stopPropagation()
        //
        //     this.props.dispatch({ type: SENTENCE_SELECT_NEXT});
        // }
        // else if (e.key == 'ArrowLeft') {
        //     // down arrow
        //     e.preventDefault();
        //     this.props.dispatch({ type: INFO_TAB_SELECT_PREVIOUS });
        // }
        // else if (e.key == 'ArrowRight') {
        //     // down arrow
        //     e.preventDefault();
        //     this.props.dispatch({ type: INFO_TAB_SELECT_NEXT });
        // }

    }


    victimTextChangeHandler(e) {
        e.preventDefault();
        this.props.dispatch({
            type: NEW_VICTIM,
            text: e.target.value
        });
        this.handleZombieTextUpdatedDebounced(e);
    }

    // handleSelect(index, last) {
    //     console.log('Selected tab: ' + index + ', Last tab: ' + last);
    // }

    outputDelineatedText(text){
        return (<span dangerouslySetInnerHTML={{__html: breakText(text)}}/>);
    }


    zombieElements(props) {
        return (
            <div className="row-fluid">

                <ZombieText
                    fullscreen={props.fullscreen}
                    zombieChoices={props.zombieChoices}
                    zombieChosenIndexes={props.zombieChosenIndexes}
                    selectedSentenceIndex={props.selectedSentenceIndex}
                    zombieIndexMarker={props.zombieIndexMarker}
                    dispatch={props.dispatch}/>

                <p className="span1"/>

                {!props.fullscreen && <div className="span6">
                    <div>

                        <Tabs >

                            <TabList>
                                <Tab>Help</Tab>
                                <Tab>Mutations</Tab>
                                <Tab>V Parse</Tab>
                                <Tab>Z Parse</Tab>
                            </TabList>

                            <TabPanel>
                                <ZombieInstructions/>
                            </TabPanel>

                            <TabPanel>
                                <div>
                                    <br/><span>{this.props.victim[props.selectedSentenceIndex].text}<br/></span>

                                    <hr/>
                                    {this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].mutations.map(function (line) {
                                        return <span className="zombie_block_quote">{line}</span>
                                    })}
                                    <hr/>

                                    <span
                                        className="zombie_sentence_active">{this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].text}</span>
                                </div>
                            </TabPanel>

                            <TabPanel>
                                {this.outputDelineatedText(this.props.victim[props.selectedSentenceIndex].parseString)}
                            </TabPanel>

                            <TabPanel>
                                {this.outputDelineatedText(this.props.zombieChoices[props.selectedSentenceIndex][this.props.zombieChosenIndexes[props.selectedSentenceIndex]].parseString)}
                            </TabPanel>

                        </Tabs>
                    </div>
                </div>}
            </div>);
    }



    render() {
        return (
            <div id="main"className="site-main"><div className="clearfix container">
                <div id="content" className="site-content-wide" role="main">
                {/*<article className="container clearfix post-117 page type-page status-publish hentry">*/}

                <div id="zombie-posts" className="clearfix entry-content">
                    <form id="usp_form" method="post" encType="multipart/form-data" action="">


                        {this.props.fullscreen ? "" :
                            <span>
                            <fieldset className="usp-name">
                                <label htmlFor="user-submitted-name">Author</label>
                                <input name="author" type="text" value={this.props.author} placeholder="Author" className="usp-input"/>
                            </fieldset>

                            <fieldset className="usp-title">
                                <label htmlFor="user-submitted-title">Title</label>
                                <input name="title" type="text" value={this.props.title} placeholder="Post Title" className="usp-input"/>
                            </fieldset>

                            <VictimText victimText={this.props.victimText}
                                        victimTextChangeHandler={this.victimTextChangeHandler}/>
                            <hr/>
                            </span>
                        }

                    {this.props.zombieChoices && this.props.zombieChoices.length>0 && this.zombieElements(this.props)}

                </form>
                </div>
                {/*</article>*/}
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
    selectedInfoIndex: PropTypes.number,
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
        selectedInfoIndex: state.incident.selectedInfoIndex
    };
}

export default connect(mapStateToProps)(InfectPage);
