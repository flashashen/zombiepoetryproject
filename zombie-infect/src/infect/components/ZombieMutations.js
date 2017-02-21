import React, { Component, PropTypes } from 'react';
import { Tab, Tabs, TabList, TabPanel } from 'react-tabs';


class ZombieMutations extends Component {


    const
    styleDisplayBlock = {
        display: 'block',
    };


    render() {
        let index = (this.props.selectedSentenceIndex>0 ? this.props.selectedSentenceIndex : 0)

        return (
            <div id="zombie-instructions" className="zombie-instructions" style={this.styleDisplayBlock}>
                {this.props.zombieChoices[index][this.props.zombieChosenIndexes[index]].mutations}
            </div>
        )
    };

}

ZombieMutations.propTypes = {
    selectedSentenceIndex: PropTypes.number,
    zombieChoices: PropTypes.array,
    zombieChosenIndexes: PropTypes.array,
};


export default ZombieMutations
