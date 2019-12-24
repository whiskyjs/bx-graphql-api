import React from "react";
import PropTypes from "prop-types";

const StatelessApp = () => {
    const greeting = "React: Stateless компонент (JSX)";

    return (<div className="react-stateless-app">
        <Paragraph value={greeting}/>
    </div>);
};

const Paragraph = ({value}) => {
    return (<p>{value}</p>);
};

Paragraph.propTypes = {
    value: PropTypes.string,
};

export {StatelessApp};
