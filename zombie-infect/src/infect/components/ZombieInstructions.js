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
                    <li><strong>Click</strong> on the clause of the 'draft' zombie poem that you want to work with.
                        <strong> Clicking again or hitting the space bar will re-zombify the clause.</strong></li>
                    <li><strong>You can repeat</strong> the process as often as you like, as you move through the zombie
                        poem.
                    </li>
                    <li>The project <strong>preserves prior iterations</strong> of the zombie process. To <strong>cycle through zombifications</strong> of a selected clause, <strong>use the arrow keys</strong> on your keyboard.</li>
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
