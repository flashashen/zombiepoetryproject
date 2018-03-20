import React, { PropTypes } from 'react';

import './css/zombie.css';


<<<<<<< HEAD
const ZombieSentenceMarker = ({ sentenceIndex, leftOrRigt }) => (
  <i className="icon-chevron-right"/>
=======
const ZombieSentenceMarker = ({ sentenceIndex, leftOrRigt, clickHandler }) => (
  <i className="icon-chevron-right" onClick={clickHandler}/>
>>>>>>> split
);

// {/*<span className="zombie_sentence_actions ">S</span>*/}

// <span className="zombie_sentence_actions ">
//     <i className="fa fa-caret-right"/>
// </span>

ZombieSentenceMarker.propTypes = {
  sentenceIndex: PropTypes.number,
<<<<<<< HEAD
    leftOrRigt: PropTypes.string
=======
  leftOrRigt: PropTypes.string,
  clickHandler: PropTypes.func,
>>>>>>> split
};

export default ZombieSentenceMarker;
