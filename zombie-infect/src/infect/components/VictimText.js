import React, { PropTypes } from 'react';



const styleDisplayBlock = {
    display: 'block',
};

const VictimText = ({ victimText, author, title, victimTextChangeHandler  }) => (


    <div id="zombie-posts">
        {/*  took out 'enctype' but what was it for?? <form id="usp_form" method="post" enctype="multipart/form-data" action="">*/}
            {/*<form id="usp_form" method="post" action="">*/}

        <fieldset className="usp-content">

            <label htmlFor="victimText">Victim Text</label>
            <textarea
                name="victimText"
                onChange={victimTextChangeHandler}
                id="victim-text"
                maxLength="1800"
                rows="5"
                placeholder="Victim Text"
                className="usp-textarea"
                value={victimText}/>
        </fieldset>


        {/*</form>*/}
    </div>

);

VictimText.propTypes = {
    victimText: PropTypes.string,
    author: PropTypes.string,
    title: PropTypes.string,
    victimTextChangeHandler: PropTypes.func
};


export default VictimText;
