import React, { Component, PropTypes } from 'react';


class ZombieInstructions extends Component {


    const
    styleDisplayBlock = {
        display: 'block',
    };


    render() {
        return (
            <div id="zombie-instructions" className="zombie-instructions" style={this.styleDisplayBlock}>

                <ul>
                    <li className="zombie-instructions"><strong>You can re-zombify portions of the poem with which you
                        are unsatisfied.</strong></li>
                    <li><strong>Click</strong> on the sentence of the "draft' zombie poem that you want to work with.
                        <strong>Clicking again will re-zombify.</strong></li>
                    <li>To see the mutations that have occurred within any selected passage, <strong>click on one of the
                        black “S” markers</strong>. You will also be able to see the parse trees of both zombie and
                        victim text this way.
                    </li>
                    <li><strong>You can repeat</strong> the process as often as you like, as you move through the zombie
                        poem.
                    </li>
                    <li>Note: <strong>Short to medium length sentences, or longer sentences demarcated by semi-colons,
                        colons, and em-dashes, work best.</strong> Very short sentences and long sentences without
                        sentence terminals may require several re-zombifications, but that’s part of the fun.
                    </li>
                    <li>When you are satisfied with your zombie, <strong>click submit</strong> to add it to the growing
                        anthology of zombie poems archived at <strong>Incidents</strong>.
                    </li>
                </ul>


            </div>
        )
    };

}

export default ZombieInstructions
