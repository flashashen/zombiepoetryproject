import React, { PropTypes } from 'react';

import './css/zombie.css';


const ZombieSentenceMarker = ({ sentenceIndex, leftOrRigt, clickHandler }) => (
  <i className="icon-chevron-right" onClick={clickHandler}/>
);

// {/*<span className="zombie_sentence_actions ">S</span>*/}

// <span className="zombie_sentence_actions ">
//     <i className="fa fa-caret-right"/>
// </span>

ZombieSentenceMarker.propTypes = {
  sentenceIndex: PropTypes.number,
  leftOrRigt: PropTypes.string,
  clickHandler: PropTypes.func,
};

export default ZombieSentenceMarker;
