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
        return function () {
            var context = this, args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate) func.apply(context, args);
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) func.apply(context, args);
        };
    };

    handleZombieTextUpdatedDebounced = this.debounce((e) => {
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
        if (input != null && this.props.selectedInfoIndex == index) {
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

    setref(component) {
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

    outputDelineatedText(text) {
        return (<span dangerouslySetInnerHTML={{__html: breakText(text)}}/>);
    }

    submit() {
        return (
            <div id="usp-submit">
                <input className="exclude" name="user-submitted-post"
                       id="user-submitted-post"
                       type="submit" value="Submit Post"/>

                <input type="hidden" id="usp-nonce" name="usp-nonce" value="7a150f8af9"/>
            </div>);
    }

    captchya() {
        return (
            <div id="captcha_zombie">
                <input type="hidden" name="cntctfrm_contact_action" value="true"/>

                <span className="cptch_wrap">

                        <label className="cptch_label" htmlFor="cptch_input_66">
                            <span className="cptch_span">
                                <img className="cptch_img "
                                     src="data: image/png;base64,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"/></span>
                            <span className="cptch_span">&nbsp;×&nbsp;</span>
                            <span className="cptch_span">

                                <input id="cptch_input_66" className="cptch_input" type="text"
                                        autoComplete="off" name="cptch_number" value=""
                                        maxLength="2"
                                        size="2" aria-required="true" required="required"
                                        style={{marginBottom: "0", display: "inline", fontSize: "12px", width: "40px"}}
                                />

                            </span>
                            <span className="cptch_span">&nbsp;=&nbsp;</span>
                            <span className="cptch_span">42</span>
                            <input type="hidden" name="cptch_result" value="4FU="/>
                            <input type="hidden" name="cptch_time" value="1487802991"/>
                            <input type="hidden" value="Version: 4.1.9"/>
                        </label>

                        <span className="cptch_reload_button_wrap hide-if-no-js">
						    <span className="cptch_reload_button dashicons dashicons-update"></span>
					    </span>
                    </span>

                {this.submit()}

            </div>);
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



                {!props.fullscreen && <div className="span6 ">
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
            <div id="main" className="site-main">
                <div className="clearfix container">
                    <div id="content" className="site-content-wide" role="main">

                        <div id="zombie-posts" className="clearfix entry-content">

                                {this.props.fullscreen ? "" :
                                    <span>
                                        <fieldset className="usp-name">
                                            <label htmlFor="user-submitted-name">Author</label>
                                            <input name="user-submitted-name" type="text" value={this.props.author}
                                                   placeholder="Author"
                                                   className="usp-input"/>
                                        </fieldset>

                                        <fieldset className="usp-title">
                                            <label htmlFor="user-submitted-title">Title</label>
                                            <input name="user-submitted-title" type="text" value={this.props.title}
                                                   placeholder="Post Title"
                                                   className="usp-input"/>
                                        </fieldset>

                                        <VictimText victimText={this.props.victimText}
                                                    victimTextChangeHandler={this.victimTextChangeHandler}/>
                                        <hr/>
                                    </span>}

                                {this.props.zombieChoices && this.props.zombieChoices.length > 0 && this.zombieElements(this.props)}

                            <fieldset className="zombie-text-full">
                                <input type="hidden" name="zombie-text-full" id="zombie-text-full"
                                       value={this.props.zombieText}/>
                                </fieldset>

                            <fieldset className="zombie-artifacts">
                                <input type="hidden" name="zombie-artifacts" id="zombie-artifacts"
                                       value={this.props.zombie}/>
                            </fieldset>

                                {/*{this.captchya()}*/}

                        </div>

                    </div>
                </div>
            </div>
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
