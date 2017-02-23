import React, { PropTypes } from 'react';



const styleDisplayBlock = {
    display: 'block',
};

const VictimText = ({ victimText, author, title, victimTextChangeHandler  }) => (


    <div id="zombie-posts">
        <fieldset className="usp-content">

            <label htmlFor="user-submitted-content">Victim Text</label>
            <textarea
                name="user-submitted-content"
                onChange={victimTextChangeHandler}
                id="victim-text"
                maxLength="1800"
                rows="5"
                placeholder="Victim Text"
                className="usp-textarea"
                value={victimText}/>
        </fieldset>
    </div>

);

VictimText.propTypes = {
    victimText: PropTypes.string,
    author: PropTypes.string,
    title: PropTypes.string,
    victimTextChangeHandler: PropTypes.func
};


export default VictimText;
