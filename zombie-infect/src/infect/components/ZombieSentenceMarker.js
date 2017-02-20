import React, { PropTypes } from 'react';

import './css/zombie.css';


const ZombieSentenceMarker = ({ sentenceIndex, leftOrRigt }) => (
  <i className="icon-chevron-right"/>
);

// {/*<span className="zombie_sentence_actions ">S</span>*/}

// <span className="zombie_sentence_actions ">
//     <i className="fa fa-caret-right"/>
// </span>

ZombieSentenceMarker.propTypes = {
  sentenceIndex: PropTypes.number,
    leftOrRigt: PropTypes.string
};

export default ZombieSentenceMarker;
