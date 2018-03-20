import React, { PropTypes } from 'react';



const styleDisplayBlock = {
    display: 'block',
};

const VictimText = ({ victimText, author, title, victimTextChangeHandler  }) => (


    <div id="zombie-posts">
<<<<<<< HEAD
        {/*  took out 'enctype' but what was it for?? <form id="usp_form" method="post" enctype="multipart/form-data" action="">*/}
            <form id="usp_form" method="post" action="">


        <fieldset className="usp-name">
            <label htmlFor="user-submitted-name">Author</label>
            <input name="author" type="text" value={author} placeholder="Author" className="usp-input"/>
        </fieldset>

        <fieldset className="usp-title">
            <label htmlFor="user-submitted-title">Title</label>
            <input name="title" type="text" value={title} placeholder="Post Title" className="usp-input"/>
        </fieldset>

        <fieldset className="usp-content">

            <label htmlFor="victimText">Victim Text</label>
            <textarea
                name="victimText"
=======
        <fieldset className="usp-content">

            <label htmlFor="user-submitted-content">Victim Text</label>
            <textarea
                name="user-submitted-content"
>>>>>>> split
                onChange={victimTextChangeHandler}
                id="victim-text"
                maxLength="1800"
                rows="5"
                placeholder="Victim Text"
                className="usp-textarea"
                value={victimText}/>
        </fieldset>
<<<<<<< HEAD


        </form>
=======
>>>>>>> split
    </div>

);

VictimText.propTypes = {
    victimText: PropTypes.string,
    author: PropTypes.string,
    title: PropTypes.string,
    victimTextChangeHandler: PropTypes.func
};


export default VictimText;
